<?php

namespace App\Http\Controllers;

use App\Models\AddressBook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\OrderHistories;
use App\Models\OrderItem;

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

    public function account()
    {
        $user = Auth::user();
    
        $addresses = AddressBook::where('user_id', $user->id)->limit(2)->get();
        $orders = Order::with([
            'orderItems.productVariant.color',
            'orderItems.productVariant.size',
            'orderItems.productVariant.product'
        ])
        ->where('user_id', $user->id)
        ->orderBy('created_at', 'desc')
        ->get(); 
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

        return view('pages.shop.partials.order-detail', compact(
            'order', 'shippingAddress', 'subtotal', 'discount', 'shipping', 'total'
        ));
    }
    public function cancel(Request $request, $id)
    {
        $request->validate([
            'cancel_reason' => 'required|string|max:255',
            'cancel_note' => 'nullable|string|max:500',
        ]);
        $order = Order::findOrFail($id);
        // Chỉ cho phép hủy nếu trạng thái phù hợp
        if ($order->status !== 'pending') {
            return back()->with('error', 'Chỉ có thể hủy đơn hàng ở trạng thái chờ xác nhận.');
        }
        $order->status = 'cancelled';
       
        $order->save();
    
        // Lưu lịch sử hủy đơn nếu cần
        OrderHistories::create([
            'users' => Auth::id(),
            'order_id' => $order->id,
            'from_status' => 'pending', 
            'to_status' => 'cancelled',
            'content' => $request->cancel_reason,
            'note' => $request->cancel_note,
        ]);
    
        return redirect()->back()->with('success', 'Đã hủy đơn hàng thành công!');
    }
}
