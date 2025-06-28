<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderHistories;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\AddressBook;
use App\Models\Vouchers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        // Kiểm tra đăng nhập
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $userId = Auth::id();
        
        // Lấy giỏ hàng
        $cartItems = Cart::with(['productVariant.color', 'productVariant.size', 'productVariant.product'])
            ->where('user_id', $userId)
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('home.cart')->with('error', 'Giỏ hàng trống!');
        }

        // Tính toán giá
        $subtotal = $cartItems->sum(fn($item) => $item->quantity * $item->price_at_time);
        $voucherDiscount = session('voucher_discount', 0);
        $shippingFee = session('shipping_fee', 0);
        $total = $subtotal - $voucherDiscount + $shippingFee;

        // Lấy địa chỉ giao hàng
        $addresses = AddressBook::where('user_id', $userId)->get();

        // Lấy voucher đã áp dụng
        $appliedVoucher = null;
        if (session('voucher_code')) {
            $appliedVoucher = Vouchers::where('code', session('voucher_code'))->first();
        }

        return view('pages.shop.checkout', compact(
            'cartItems',
            'subtotal',
            'voucherDiscount',
            'shippingFee',
            'total',
            'addresses',
            'appliedVoucher'
        ));
    }

    public function processCheckout(Request $request)
    {
        $request->validate([
            'address_id' => 'required|exists:address_books,id',
            'payment_method' => 'required|in:COD,QR',
            'notes' => 'nullable|string|max:500',
            'terms_condition' => 'required|accepted'
        ], [
            'address_id.required' => 'Vui lòng chọn địa chỉ giao hàng',
            'address_id.exists' => 'Địa chỉ không hợp lệ',
            'payment_method.required' => 'Vui lòng chọn phương thức thanh toán',
            'payment_method.in' => 'Phương thức thanh toán không hợp lệ',
            'terms_condition.required' => 'Vui lòng đồng ý với điều khoản',
            'terms_condition.accepted' => 'Vui lòng đồng ý với điều khoản'
        ]);

        $userId = Auth::id();
        
        // Lấy giỏ hàng
        $cartItems = Cart::with(['productVariant.color', 'productVariant.size', 'productVariant.product'])
            ->where('user_id', $userId)
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('home.cart')->with('error', 'Giỏ hàng trống!');
        }

        // Kiểm tra tồn kho
        $outOfStockItems = [];
        foreach ($cartItems as $item) {
            if ($item->quantity > $item->productVariant->stock) {
                $outOfStockItems[] = [
                    'name' => $item->productVariant->product->name,
                    'requested' => $item->quantity,
                    'available' => $item->productVariant->stock
                ];
            }
        }

        if (!empty($outOfStockItems)) {
            $errorMessage = 'Một số sản phẩm không đủ tồn kho:';
            foreach ($outOfStockItems as $item) {
                $errorMessage .= "\n- {$item['name']}: Yêu cầu {$item['requested']}, có sẵn {$item['available']}";
            }
            return redirect()->back()->with('error', $errorMessage);
        }

        try {
            DB::beginTransaction();

            // Tính toán giá
            $subtotal = $cartItems->sum(fn($item) => $item->quantity * $item->price_at_time);
            $voucherDiscount = session('voucher_discount', 0);
            $shippingFee = session('shipping_fee', 0);
            $finalAmount = $subtotal - $voucherDiscount + $shippingFee;

            // Lấy địa chỉ
            $address = AddressBook::where('id', $request->address_id)
                ->where('user_id', $userId)
                ->firstOrFail();

            // Tạo mã đơn hàng
            $orderCode = 'ORD' . date('Ymd') . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);

            // Tạo đơn hàng
            $order = Order::create([
                'user_id' => $userId,
                'address_books_id' => $address->id,
                'voucher_id' => session('voucher_code') ? Vouchers::where('code', session('voucher_code'))->first()?->id : null,
                'name' => $address->name,
                'phone' => $address->phone,
                'address' => $address->address,
                'total_amount' => $subtotal,
                'final_amount' => $finalAmount,
                'status' => 'pending',
                'code_order' => $orderCode,
                'pay_method' => $request->payment_method,
                'status_pay' => $request->payment_method === 'COD' ? 'cod_paid' : 'unpaid',
                'notes' => $request->notes
            ]);

            // Tạo chi tiết đơn hàng
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_variant_id' => $item->product_variant_id,
                    'product_id' => $item->productVariant->product_id,
                    'product_name' => $item->productVariant->product->name,
                    'product_image_url' => $item->productVariant->product->image_url ?? '',
                    'import_price' => $item->productVariant->import_price,
                    'listed_price' => $item->productVariant->listed_price,
                    'sale_price' => $item->price_at_time,
                    'quantity' => $item->quantity,
                    'promotion_type' => '0'
                ]);

                // Cập nhật tồn kho
                $item->productVariant->decrement('stock', $item->quantity);
            }

            // Xóa giỏ hàng
            Cart::where('user_id', $userId)->delete();

            // Xóa session voucher
            session()->forget(['voucher_code', 'voucher_discount', 'shipping_fee']);

            // Lưu thông tin thanh toán vào session để hiển thị ở trang thành công
            session(['payment_method' => $request->payment_method]);

            DB::commit();

            return redirect()->route('home.done')->with('success', 'Đặt hàng thành công! Mã đơn hàng: ' . $orderCode);

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Checkout error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi đặt hàng. Vui lòng thử lại!');
        }
    }

    public function done()
    {
        return view('pages.shop.success_checkout');
    }

    public function db_order(Request $request)
    {
        $action = ['pending', 'confirmed', 'shipping', 'success', 'cancelled'];
        $type = $request->query('type');
        if ($type && !in_array($type, $action)) {
            return abort(403, 'Không có hành động này');
        }
        if ($type) {
            $data_order = Order::where('status', $type)->paginate(10);
        } else {
            $data_order = Order::paginate(10);
        }
        // dd($data_order);
        return view('dashboard.pages.order.index', compact('data_order'));
    }
    public function db_order_change(Request $request, $id)
    {
        $before = $request->change;
        // dd($before);
        $data_change = ['pending', 'confirmed', 'shipping', 'cancelled', 'failed', 'return'];
        if ($before && !in_array($before, $data_change)) {
            return  abort(403, "Hành động không hợp lệ");
        }
        $old_status = Order::find($id);
        $present = Order::find($id);
        if (!$present || !$old_status) {
            return abort(403, 'Không thấy đơn hàng này vui lòng kiểm tra lại');
        }
        switch ($before) {
            case 'pending':
                if ($present->status != 'pending') {
                    return abort(403, "Bạn không thể đổi sang trạng thái đã xác nhận khi đơn hàng không ở trạng thái chưa xác nhận ");
                } else {
                    $present->status = 'confirmed';
                    $note = 'Đơn hàng đã được xác nhận';
                }
                break;
            case 'confirmed':
                if ($present->status != 'confirmed') {
                    return abort(403, 'Bạn không thể đổi sang trạng thái giao hàng khi đơn hàng không ở trạng thái đã xác nhận ');
                } else {
                    $present->status = 'shipping';
                    $note = 'Đơn vị vận chuyển đã lấy hàng, chuẩn bị giao hàng';
                }
                break;
            case 'shipping':
                if ($present->status != 'shipping') {
                    return abort(403, 'Bạn không thể đổi sang trạng thái đã giao hàng khi đơn hàng không ở trạng thái đang giao hàng ');
                } else {
                    $present->status = 'success';
                    $note = 'Đơn hàng đã được giao thành công';
                }
                break;
            case 'failed':
                if ($present->status != 'shipping') {
                    return abort(403, 'Bạn không thể đổi sang trạng thái giao hàng thất bại khi đơn hàng không ở trạng thái đang giao hàng ');
                } else {
                    $present->status = 'failed';
                    $note = 'Giao hàng thất bại';
                }
                break;
            case 'return':
                if ($present->status != 'failed') {
                    return abort(403, 'Bạn không thể đổi sang trạng thái giao lại khi đơn hàng không ở trạng thái giao hàng thất bại ');
                } else {
                    $present->status = 'shipping';
                    $note = 'Đơn vị vận chuyển đã lấy hàng , chuẩn bị giao hàng';
                }
                break;
            case 'cancelled':
                if ($present->status == 'failed' || $present->status == 'pending' || $present->status == 'confirmed') {
                    $present->status = 'cancelled';
                    $note = 'Đơn hàng đã được hủy theo yêu cầu của khách hàng';
                } else {
                    return abort(403, 'Đơn chỉ được hủy khi ở trạng thái chưa xác nhận , đã xác nhận hoặc đơn giao thất bại');
                }
                break;
        }

            $present->save();
            OrderHistories::create([
                'users' => Auth::user()->id,
                'order_id' => $id,
                'from_status' => $old_status->status,
                'to_status' => $present->status,
                'note' => $note

            ]);


        return redirect()->back()->with('success', 'Cập nhật trạng thái đơn hàng thành công!');
    }
    public function db_order_show($id)
    {
        $data_order = Order::join('vouchers','vouchers.id','orders.voucher_id')->
        join('address_books','address_books.id','orders.address_books_id')->
        join('users','users.id','orders.user_id')->
        select(
            'orders.*',
            'vouchers.code',
            'address_books.name as ad_name',
            'address_books.address as ad_address',
            'address_books.phone as ad_phone',
            'users.email',
        )->where('orders.id',$id)
        ->first();
        $data_order_items = OrderItem::join('orders', 'orders.id', 'order_items.order_id')->
        join('product_variants', 'product_variants.id', 'order_items.product_variant_id')->
        join('sizes', 'sizes.id', 'product_variants.size_id')->
        join('colors', 'colors.id', 'product_variants.color_id')->
        where('order_id', $id)->
        select(
                'order_items.*',
                'sizes.size_name',
                'colors.color_name',
            )->get();
            $history_1 = OrderHistories::where('from_status','pending')->where('to_status','confirmed')->where('order_id',$id)->first();
            $history_2 = OrderHistories::where('from_status','confirmed')->where('to_status','shipping')->where('order_id',$id)->first();
            $history_3 = OrderHistories::where('from_status','shipping')->where('to_status','failed')->where('order_id',$id)->first();
            $history_4 = OrderHistories::where('from_status','failed')->where('to_status','shipping')->where('order_id',$id)->first();
            $history_5 = OrderHistories::where('from_status','shipping')->where('to_status','success')->where('order_id',$id)->first();
        // $historyItems = OrderHistories::where('order_id', $id)->get()->keyBy('from_status');
        // dd($historyItems);
        // dd($data_order);
        // dd($data_order_items);

        return view('dashboard.pages.order.detail', compact('data_order', 'data_order_items'));
    }
}
