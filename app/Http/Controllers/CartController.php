<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Vouchers;
use App\Models\VouchersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    //
public function index()
{
    $userId = Auth::id(); 

    // Nếu không có mã áp dụng, xoá giảm giá để tránh tự trừ tiền
    if (!session()->has('voucher_code')) {
        session()->forget('voucher_discount');
    }

    $cartItems = Cart::with('productVariant.color')->where('user_id', $userId)->get();

    // Tính tổng phụ (subtotal)
    $subtotal = $cartItems->sum(function ($item) {
        return $item->quantity * $item->price_at_time;
    });

    // Voucher giảm giá nếu có
    $voucherDiscount = session('voucher_discount', 0);

    // Phí vận chuyển (nếu có)
    $shippingFee = session('shipping_fee', 0);

    // Tổng tiền cuối cùng
    $total = $subtotal - $voucherDiscount + $shippingFee;

    // Lấy danh sách voucher còn hiệu lực
    $availableVouchers = DB::table('vouchers')
        ->join('vouchers_users', 'vouchers.id', '=', 'vouchers_users.voucher_id')
        ->where('vouchers_users.user_id', $userId)
        ->where('vouchers_users.status', 'available')
        ->select('vouchers.*')
        ->get();

    return view('pages.shop.cart', compact(
        'cartItems',
        'subtotal',
        'voucherDiscount',
        'shippingFee',
        'total',
        'availableVouchers'
    ));
}







   public function deleteSelected(Request $request)
{
    $ids = $request->input('ids');

    if (is_array($ids)) {
        Cart::whereIn('id', $ids)->delete();

        return response()->json(['success' => true]);
    }

    return response()->json(['success' => false], 400);
}
public function updateQuantity(Request $request)
{
    $cartItem = Cart::where('id', $request->id)
        ->where('user_id', auth()->id())
        ->firstOrFail();

    if ($request->action === 'increase') {
        $cartItem->quantity += 1;
    } elseif ($request->action === 'decrease') {
        $cartItem->quantity = max(1, $cartItem->quantity - 1);
    }

    $cartItem->save();

    // Tính lại tổng giỏ hàng
    $cartItems = Cart::where('user_id', auth()->id())->get();
    $subtotal = $cartItems->sum(fn($item) => $item->quantity * $item->price_at_time);
    $voucherDiscount = session('voucher_discount', 0);
    $shippingFee = session('shipping_fee', 0);
    $total = $subtotal - $voucherDiscount + $shippingFee;

    return response()->json([
        'success' => true,
        'quantity' => $cartItem->quantity,
        'item_total' => number_format($cartItem->quantity * $cartItem->price_at_time, 0, ',', '.') . ' đ',
        'subtotal' => number_format($subtotal, 0, ',', '.') . ' đ',
        'total' => number_format($total, 0, ',', '.') . ' đ'
    ]);
}
public function calculateTotal(Request $request)
{
    $cartItems = Cart::where('user_id', Auth::id())->get();
    $subtotal = $cartItems->sum(function ($item) {
        return $item->quantity * $item->price_at_time;
    });

    $voucherDiscount = session('max_discount', 0);
    $shippingFee = $request->shipping_fee ?? session('shipping_fee', 0);

    $total = $subtotal - $voucherDiscount + $shippingFee;

    return response()->json([
        'subtotal' => number_format($subtotal, 0, ',', '.') . ' đ',
        'total' => number_format($total, 0, ',', '.') . ' đ'
    ]);
}

public function getUserVouchers()
{
    $userId = Auth::id();

    $vouchers = DB::table('vouchers_users')
        ->join('vouchers', 'vouchers_users.voucher_id', '=', 'vouchers.id')
        ->where('vouchers_users.user_id', $userId)
        ->where('vouchers_users.status', 'available')
        ->select('vouchers.*', 'voucher_user.status', 'vouchers_users.is_used')
        ->get();

    return response()->json($vouchers);
}
public function applyVoucher(Request $request)
{
    $voucher = Vouchers::where('code', $request->code)->first();

    if (!$voucher) {
        return response()->json(['success' => false, 'message' => 'Mã không tồn tại']);
    }

    // Lưu session
        session([
            'voucher_code' => $voucher->code,
            'voucher_discount' => $voucher->max_discount, // hoặc discount_amount nếu dùng trường này
            // 'voucher_applied' => true,
        ]);

    $userId = Auth::id();
    $cartItems = Cart::where('user_id', $userId)->get();

    $subtotal = $cartItems->sum(function ($item) {
        return $item->quantity * $item->price_at_time;
    });

    $shippingFee = session('shipping_fee', 0);

    // Tính tổng tiền sau khi giảm
    $total = $subtotal - $voucher->max_discount + $shippingFee;

    return response()->json([
        'success' => true,
        'subtotal' => number_format($subtotal, 0, ',', '.') . ' đ',
        'total' => number_format($total, 0, ',', '.') . ' đ',
        'discount' => number_format($voucher->max_discount, 0, ',', '.') . ' đ' // Trả về để JS cập nhật
    ]);
}

}
