<?php

namespace App\Http\Controllers;

use App\Models\AddressBook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\OrderHistories;
use App\Models\OrderItem;
use App\Models\RefundMoney;
use App\Models\Vouchers;
use App\Models\VouchersLog;
use App\Models\VouchersUsers;

class InfoController extends Controller
{
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'default_phone' => 'nullable|string|max:20',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        DB::table('users')->where('id', $user->id)->update($validatedData);

        return redirect()->back()->with('success', 'Thông tin đã được cập nhật thành công!');
    }

    public function account(Request $request)
    {
        $query = Order::where('user_id', auth()->id());

        // Lọc theo ngày nếu có
        if ($request->has('from') && $request->has('to')) {
            $from = $request->input('from');
            $to = $request->input('to');
            $query->whereDate('created_at', '>=', $from)
                  ->whereDate('created_at', '<=', $to);
        }

        $orders = $query->latest()->get();

        $user = Auth::user();

        $addresses = AddressBook::where('user_id', $user->id)->limit(2)->get();
        $pendingOrders = $orders->where('status', 'pending')->values();
        $confirmedOrders = $orders->where('status', 'confirmed')->values();
        $shippingOrders = $orders->where('status', 'shipping')->values();
        $successOrders = $orders->where('status', 'success')->values();
        $failedOrders = $orders->where('status', 'failed')->values();
        $cancelledOrders = $orders->where('status', 'cancelled')->values();
        // dd($cancelledOrders);
        // dd($shippingOrders, $orders, $confirmedOrders,$successOrders,$pendingOrders,  $failedOrders,   $cancelledOrders);
        return view('pages.shop.account', compact('orders', 'addresses', 'pendingOrders', 'confirmedOrders', 'shippingOrders', 'successOrders', 'cancelledOrders'));
    }
    public function orderDetail($id)
    {
        $order = Order::with([
            'orderItems.productVariant.color',
            'orderItems.productVariant.size',
            'orderItems.productVariant.product'
        ])->find($id);

        if (!$order) {
            abort(404, 'Order not found');
        }

        $shippingAddress = $order->addressBook; // đúng với quan hệ trong model
        $subtotal = $order->orderItems->sum(function($item) {
            return $item->sale_price * $item->quantity;
        });
        $discount = $order->discount_amount ?? 0; // hoặc trường discount nếu có
        // dd($discount);
        $shipping = $order->shipping_fee ?? 0;
        $total = $subtotal - $discount + $shipping;

        $refund = RefundMoney::where('order_id',$id)
                             ->where('user_id',Auth::user()->id)
                             ->first();
                            //  dd($refund);
        return view('pages.shop.partials.order-detail', compact(
            'order', 'shippingAddress', 'subtotal', 'discount', 'shipping', 'total','refund'
        ));
    }
    public function cancel(Request $request, $id)
    {
        $request->validate([
            'cancel_reason' => 'required|string|max:255',
            // 'cancel_note' => 'nullable|string|max:500',
        ]);
        $order = Order::findOrFail($id);
        // Chỉ cho phép hủy nếu trạng thái phù hợp
        if ($order->status !== 'pending') {
            return back()->with('error', 'Chỉ có thể hủy đơn hàng ở trạng thái chờ xác nhận.');
        }
        $order->status = 'cancelled';
        if ($order->status == 'cancelled') {
            OrderItem::where('order_id', $id)->get()->each(function ($item) {
                $item->productVariant->increment('stock', $item->quantity);
            });
            $voucher = Vouchers::find($order->voucher_id);
            if ($order->voucher_id && $voucher->end_date < now()) {
                VouchersUsers::updateOrCreate(
                    [
                        'user_id' => $order->user_id,
                        'voucher_id' => $order->voucher_id,
                    ],
                    [
                        'is_used'    => 'unused',
                        'start_date' => now(),
                        'end_date'   => now()->addDays(7),
                    ]
                );
                VouchersLog::create([
                    'user_id' => $order->user_id,
                    'voucher_id' => $order->voucher_id,
                    'order_id' => $id,
                    'type' => 'refund_new',
                    'content' => 'Voucher đã được tạo lại do đơn hàng bị hủy',
                ]);
            } else if ($order->voucher_id) {
                VouchersUsers::where('user_id', $order->user_id)
                    ->where('voucher_id', $order->voucher_id)
                    ->update([
                        'is_used' => 'unused',
                    ]);
                VouchersLog::create([
                    'user_id' => $order->user_id,
                    'voucher_id' => $order->voucher_id,
                    'order_id' => $id,
                    'type' => 'refund_reuse',
                    'content' => 'Voucher đã được đánh dấu là chưa sử dụng do đơn hàng bị hủy',
                ]);
            }
        }


        $order->save();

        // Lưu lịch sử hủy đơn nếu cần
        OrderHistories::create([
            'users' => Auth::id(),
            'order_id' => $order->id,
            'from_status' => 'pending',
            'to_status' => 'cancelled',
            'note' => $request->cancel_reason,
            'content' => $request->cancel_note,
        ]);

        return redirect()->back()->with('success', 'Đã hủy đơn hàng thành công!');
    }

    public function filterOrders(Request $request)
    {
        $query = Order::where('user_id', auth()->id());
        if ($request->has('from') && $request->has('to')) {
            $query->whereDate('created_at', '>=', $request->from)
                  ->whereDate('created_at', '<=', $request->to);
        }
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }
        $orders = $query->latest()->get();

        // Trả về HTML của partial order-list
        return view('pages.shop.partials.order-list', ['orders' => $orders])->render();
    }
}
