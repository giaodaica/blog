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
use Illuminate\Support\Facades\Validator;

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
        $shippingType = session('shipping_type', 'basic');
        $shippingFee = $this->calculateShippingFee($subtotal, $shippingType);
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
            'shippingType',
            'total',
            'addresses',
            'appliedVoucher'
        ));
    }

    // Thêm method tính phí vận chuyển
    private function calculateShippingFee($subtotal, $shippingType = 'basic')
    {
        $baseShippingFee = 0;
        
        // Tính phí cơ bản
        if ($subtotal >= 200000) {
            $baseShippingFee = 0; // Free shipping cho đơn hàng >= 200k
        } else {
            $baseShippingFee = 20000; // 20k cho đơn hàng < 200k
        }
        
        // Thêm phí vận chuyển nhanh nếu chọn
        if ($shippingType === 'express') {
            $baseShippingFee += 30000; // Thêm 30k cho vận chuyển nhanh
        }
        
        return $baseShippingFee;
    }

    public function processCheckout(Request $request)
    {
        try {
            Log::info('Checkout started', ['user_id' => Auth::id(), 'request_data' => $request->all()]);

            // Debug validation
            $request->validate([
                'address_id' => 'required|exists:address_books,id',
                'payment_method' => 'required|in:COD,QR',
                'shipping_type' => 'required|in:basic,express',
                'notes' => 'nullable|string|max:500',
                'terms_condition' => 'required|accepted'
            ], [
                'address_id.required' => 'Vui lòng chọn địa chỉ giao hàng',
                'address_id.exists' => 'Địa chỉ không hợp lệ',
                'payment_method.required' => 'Vui lòng chọn phương thức thanh toán',
                'payment_method.in' => 'Phương thức thanh toán không hợp lệ',
                'shipping_type.required' => 'Vui lòng chọn loại vận chuyển',
                'shipping_type.in' => 'Loại vận chuyển không hợp lệ',
                'terms_condition.required' => 'Vui lòng đồng ý với điều khoản',
                'terms_condition.accepted' => 'Vui lòng đồng ý với điều khoản'
            ]);

            $userId = Auth::id();
            
            // Lấy giỏ hàng
            $cartItems = Cart::with(['productVariant.color', 'productVariant.size', 'productVariant.product'])
                ->where('user_id', $userId)
                ->get();

            Log::info('Cart items loaded', ['count' => $cartItems->count()]);

            if ($cartItems->isEmpty()) {
                return redirect()->route('home.cart')->with('error', 'Giỏ hàng trống!');
            }

            // Debug cart items
            foreach ($cartItems as $item) {
                Log::info('Cart item', [
                    'id' => $item->id,
                    'product_variants_id' => $item->product_variants_id,
                    'quantity' => $item->quantity,
                    'price_at_time' => $item->price_at_time,
                    'has_product_variant' => $item->productVariant ? 'yes' : 'no',
                    'has_product' => $item->productVariant && $item->productVariant->product ? 'yes' : 'no'
                ]);
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

            DB::beginTransaction();

            // Tính toán giá
            $subtotal = $cartItems->sum(fn($item) => $item->quantity * $item->price_at_time);
            $voucherDiscount = session('voucher_discount', 0);
            $shippingFee = $this->calculateShippingFee($subtotal, $request->shipping_type);
            $finalAmount = $subtotal - $voucherDiscount + $shippingFee;

            Log::info('Price calculation', [
                'subtotal' => $subtotal,
                'voucher_discount' => $voucherDiscount,
                'shipping_fee' => $shippingFee,
                'final_amount' => $finalAmount
            ]);

            // Lấy địa chỉ
            $address = AddressBook::where('id', $request->address_id)
                ->where('user_id', $userId)
                ->firstOrFail();

            // Tạo mã đơn hàng
            $orderCode = 'ORD' . date('Ymd') . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);

            Log::info('Creating order', ['order_code' => $orderCode]);

            // Tạo đơn hàng
            $orderData = [
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
                'pay_method' => 'COD',
                'status_pay' => $request->payment_method === 'QR' ? 'unpaid' : 'cod_paid',
                'notes' => $request->notes ?? null
            ];

            Log::info('Order data prepared', $orderData);

            $order = Order::create($orderData);

            Log::info('Order created', ['order_id' => $order->id]);

            // Tạo chi tiết đơn hàng
            foreach ($cartItems as $item) {
                $orderItemData = [
                    'order_id' => $order->id,
                    'product_variant_id' => $item->product_variants_id,
                    'product_id' => $item->productVariant->product_id,
                    'product_name' => $item->productVariant->product->name,
                    'product_image_url' => $item->productVariant->product->image_url ?? '',
                    'import_price' => $item->productVariant->import_price,
                    'listed_price' => $item->productVariant->listed_price,
                    'sale_price' => $item->price_at_time,
                    'quantity' => $item->quantity,
                    'promotion_type' => '0'
                ];

                OrderItem::create($orderItemData);

                // Cập nhật tồn kho
                $item->productVariant->decrement('stock', $item->quantity);
            }

            Log::info('Order items created', ['count' => $cartItems->count()]);

            // Xóa giỏ hàng
            Cart::where('user_id', $userId)->delete();

            // Xóa session voucher
            session()->forget(['voucher_code', 'voucher_discount', 'shipping_fee']);

            // Lưu thông tin thanh toán vào session để hiển thị ở trang thành công
            session([
                'payment_method' => $request->payment_method,
                'shipping_type' => $request->shipping_type,
                'order_code' => $orderCode
            ]);

            DB::commit();

            Log::info('Checkout completed successfully', ['order_id' => $order->id]);

            // Xử lý thanh toán theo phương thức (không ảnh hưởng đến database)
            if ($request->payment_method === 'QR') {
                return $this->processMomoPayment($order, $finalAmount);
            } else {
                return redirect()->route('home.done')->with('success', 'Đặt hàng thành công! Mã đơn hàng: ' . $orderCode);
            }

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Checkout error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi đặt hàng: ' . $e->getMessage());
        }
    }

    // Xử lý thanh toán MOMO
    private function processMomoPayment($order, $amount)
    {
        // Tạo URL thanh toán MOMO (giả lập)
        $momoUrl = "https://payment.momo.vn/v2/gateway/api/create";
        
        // Trong thực tế, bạn sẽ tích hợp với API MOMO thật
        // Đây chỉ là demo
        $paymentData = [
            'partnerCode' => 'MOMO',
            'orderId' => $order->code_order,
            'amount' => $amount,
            'orderInfo' => 'Thanh toan don hang ' . $order->code_order,
            'returnUrl' => route('home.done'),
            'ipnUrl' => route('momo.ipn'),
            'requestType' => 'captureWallet',
            'extraData' => ''
        ];

        // Lưu thông tin thanh toán vào session
        session(['momo_payment_data' => $paymentData]);

        // Redirect đến trang thanh toán MOMO (demo)
        return redirect()->route('momo.payment')->with('order', $order);
    }

    // Trang thanh toán MOMO (demo)
    public function momoPayment()
    {
        $order = session('order');
        $paymentData = session('momo_payment_data');
        
        if (!$order || !$paymentData) {
            return redirect()->route('home.cart')->with('error', 'Không tìm thấy thông tin thanh toán');
        }

        return view('pages.shop.momo_payment', compact('order', 'paymentData'));
    }

    // IPN callback từ MOMO
    public function momoIpn(Request $request)
    {
        // Xử lý callback từ MOMO
        // Trong thực tế, bạn sẽ verify signature và cập nhật trạng thái đơn hàng
        
        $orderId = $request->input('orderId');
        $resultCode = $request->input('resultCode');
        
        $order = Order::where('code_order', $orderId)->first();
        
        if ($order) {
            if ($resultCode == 0) {
                // Thanh toán thành công
                $order->update(['status_pay' => 'paid']);
                
                // Gửi email xác nhận
                // Mail::to($order->user->email)->send(new OrderConfirmation($order));
            } else {
                // Thanh toán thất bại
                $order->update(['status_pay' => 'failed']);
            }
        }
        
        return response()->json(['status' => 'success']);
    }

    public function done()
    {
        return view('pages.shop.success_checkout');
    }

    public function db_order(Request $request)
    {
        $action = ['pending', 'confirmed', 'shipping', 'success', 'cancelled'];
        $type = $request->query('type');
        $count = OrderHistories::where('from_status', 'failed')->count();

        if ($type && !in_array($type, $action)) {
            return abort(403, 'Không có hành động này');
        }
        if ($type) {
            $data_order = Order::where('status', $type)->paginate(10);
        } else {
            $data_order = Order::paginate(10);
        }
        // dd($data_order);
        return view('dashboard.pages.order.index', compact('data_order', 'count'));
    }
    public function db_order_change(Request $request, $id)
    {

        $before = $request->change;
        // dd($before);
        $request->validate(
            [
                'content' => 'nullable|string|max:255',
            ],
            [
                'content.max' => 'Nội dung không được quá 255 ký tự',
                'content.string' => 'Nội dung phải là chuỗi ký tự',
            ]
        );
        if (!$request->content) {
            $content = $request->content1;
        }
        $data_change = ['pending', 'confirmed', 'shipping', 'cancelled', 'failed', 'return'];
        if ($before && !in_array($before, $data_change)) {
            return  abort(403, "Hành động không hợp lệ");
        }
        $old_status = Order::find($id);
        $present = Order::find($id);
        $count = OrderHistories::where('from_status', 'failed')->count();

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
                if ($present->status == 'failed' || $present->status == 'pending' || $present->status == 'confirmed' || $count == 2) {
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
            'note' => $note,
            'content' => $request->content ?? $content,


        ]);

        if($count >= 2 && $present->status == 'failed') {
            $present->status = 'cancelled';
            $present->save();
            OrderHistories::create([
                'users' => Auth::user()->id,
                'order_id' => $id,
                'from_status' => 'failed',
                'to_status' => 'cancelled',
                'note' => 'Đơn hàng đã tự động hủy do giao thất bại 3 lần',
                'content' => "",
            ]);
        }

        return redirect()->back()->with('success', 'Cập nhật trạng thái đơn hàng thành công!');
    }
    public function db_order_show($id)
    {
        $data_order = Order::Join('vouchers', 'vouchers.id', 'orders.voucher_id')->leftJoin('address_books', 'address_books.id', 'orders.address_books_id')->join('users', 'users.id', 'orders.user_id')->select(
            'orders.*',
            'vouchers.code',
            'address_books.name as ad_name',
            'address_books.address as ad_address',
            'address_books.phone as ad_phone',
            'users.email',
        )->where('orders.id', $id)
            ->first();
        $data_order_items = OrderItem::join('orders', 'orders.id', 'order_items.order_id')->join('product_variants', 'product_variants.id', 'order_items.product_variant_id')->join('sizes', 'sizes.id', 'product_variants.size_id')->join('colors', 'colors.id', 'product_variants.color_id')->where('order_id', $id)->select(
            'order_items.*',
            'sizes.size_name',
            'colors.color_name',
        )->get();
        $histoty_order = OrderHistories::join('users', 'users.id', 'order_histories.users')->where('order_id', $id)->select(
            'order_histories.*',
            'users.name as user_name'
        )->orderBy('created_at', 'desc')->get();
        // dd($data_order);
        // dd($histoty_order);
        // $historyItems = OrderHistories::where('order_id', $id)->get()->keyBy('from_status');
        // dd($historyItems);
        // dd($data_order);
        // dd($data_order_items);

        return view('dashboard.pages.order.detail', compact('data_order', 'data_order_items', 'histoty_order'));
    }

    // Test method for simple checkout
    public function testCheckout(Request $request)
    {
        try {
            $userId = Auth::id();
            
            // Lấy giỏ hàng với relationship
            $cartItems = Cart::with(['productVariant.color', 'productVariant.size', 'productVariant.product'])
                ->where('user_id', $userId)
                ->get();
            
            if ($cartItems->isEmpty()) {
                return response()->json(['error' => 'Giỏ hàng trống'], 400);
            }

            // Tính toán đơn giản
            $subtotal = $cartItems->sum(fn($item) => $item->quantity * $item->price_at_time);
            $finalAmount = $subtotal;

            // Lấy địa chỉ đầu tiên
            $address = AddressBook::where('user_id', $userId)->first();
            
            if (!$address) {
                return response()->json(['error' => 'Không có địa chỉ giao hàng'], 400);
            }

            DB::beginTransaction();

            // Tạo mã đơn hàng
            $orderCode = 'TEST' . date('Ymd') . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);

            // Tạo đơn hàng đơn giản
            $order = Order::create([
                'user_id' => $userId,
                'address_books_id' => $address->id,
                'voucher_id' => null,
                'name' => $address->name,
                'phone' => $address->phone,
                'address' => $address->address,
                'total_amount' => $subtotal,
                'final_amount' => $finalAmount,
                'status' => 'pending',
                'code_order' => $orderCode,
                'pay_method' => 'COD',
                'status_pay' => 'cod_paid',
                'notes' => 'Test order'
            ]);

            // Tạo chi tiết đơn hàng với dữ liệu thực tế
            foreach ($cartItems as $item) {
                if ($item->productVariant && $item->productVariant->product) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_variant_id' => $item->product_variants_id,
                        'product_id' => $item->productVariant->product_id,
                        'product_name' => $item->productVariant->product->name,
                        'product_image_url' => $item->productVariant->product->image_url ?? '',
                        'import_price' => $item->productVariant->import_price ?? 0,
                        'listed_price' => $item->productVariant->listed_price ?? $item->price_at_time,
                        'sale_price' => $item->price_at_time,
                        'quantity' => $item->quantity,
                        'promotion_type' => '0'
                    ]);
                } else {
                    // Fallback nếu không có dữ liệu product
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_variant_id' => $item->product_variants_id,
                        'product_id' => 1,
                        'product_name' => 'Unknown Product',
                        'product_image_url' => '',
                        'import_price' => 0,
                        'listed_price' => $item->price_at_time,
                        'sale_price' => $item->price_at_time,
                        'quantity' => $item->quantity,
                        'promotion_type' => '0'
                    ]);
                }
            }

            // Xóa giỏ hàng
            Cart::where('user_id', $userId)->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'order_id' => $order->id,
                'order_code' => $orderCode,
                'message' => 'Test checkout thành công!'
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'error' => 'Lỗi: ' . $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ], 500);
        }
    }
}
