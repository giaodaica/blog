<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Vouchers;
use App\Models\Product_variants;
use App\Models\VouchersUsers;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    //
public function index()
{
    $userId = Auth::id();

    $cartItems = Cart::with('productVariant.color')->where('user_id', $userId)->get();

    $subtotal = $cartItems->sum(fn($item) => $item->quantity * $item->price_at_time);

    // CHỈ lấy voucher nếu thực sự có session mã
    $voucherDiscount = session()->has('voucher_code') && session()->has('voucher_discount')
        ? session('voucher_discount')
        : 0;

    $shippingFee = session('shipping_fee', 0);
    $total = $subtotal - $voucherDiscount + $shippingFee;

    // Lấy danh sách voucher người dùng đang có
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
    try {
        $cartItem = Cart::findOrFail($request->id);
        $variant = $cartItem->productVariant;

        if ($request->action === 'increase') {
            if ($cartItem->quantity >= $variant->stock) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không thể tăng vượt quá tồn kho.'
                ]);
            }
            $cartItem->quantity += 1;
        } elseif ($request->action === 'decrease') {
            if ($cartItem->quantity > 1) {
                $cartItem->quantity -= 1;
            }
        }

        $cartItem->save();

        // Tính lại
        $subtotal = Cart::where('user_id', auth()->id())->sum(DB::raw('quantity * price_at_time'));
        $voucherDiscount = session('voucher_discount', 0);
        $shippingFee = session('shipping_fee', 0);
        $total = $subtotal - $voucherDiscount + $shippingFee;

        return response()->json([
            'success' => true,
            'quantity' => $cartItem->quantity,
            'item_total' => number_format($cartItem->quantity * $cartItem->price_at_time, 0, ',', '.') . ' đ',
            'subtotal' => number_format($subtotal, 0, ',', '.') . ' đ',
            'total' => number_format($total, 0, ',', '.') . ' đ',
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Lỗi hệ thống: ' . $e->getMessage(),
        ], 500);
    }
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
    $request->validate([
        'code' => 'required|string'
    ]);

    $voucher = DB::table('vouchers')
        ->where('code', $request->code)
        ->where('status', 'active')
        ->first();

    if (!$voucher) {
        return redirect()->back()->with('error', 'Mã giảm giá không hợp lệ');
    }

    $userId = Auth::id();
    $cartItems = Cart::where('user_id', $userId)->get();

    $subtotal = $cartItems->sum(function ($item) {
        return $item->quantity * $item->price_at_time;
    });

    if ($voucher->min_order_value && $subtotal < $voucher->min_order_value) {
        return redirect()->back()->with('error', 'Đơn hàng phải có giá trị tối thiểu ' . number_format($voucher->min_order_value, 0, ',', '.') . ' đ để sử dụng mã giảm giá này.');
    }

    $discount = 0;
    if ($voucher->type_discount === 'percent') {
        $discount = round($subtotal * ($voucher->value / 100));
        if ($voucher->max_discount && $discount > $voucher->max_discount) {
            $discount = $voucher->max_discount;
        }
    } else {
        $discount = $voucher->value;
    }

    session([
        'voucher_code' => $voucher->code,
        'voucher_discount' => $discount
    ]);

    return redirect()->back()->with('success', 'Áp dụng mã giảm giá thành công!');
}

public function removeVoucher()
{
    session()->forget(['voucher_code', 'voucher_discount']);
    return redirect()->back()->with('info', 'Đã huỷ mã giảm giá');
}


    public function add_to_cart($id,request $request){

        $request->validate([
            'color' => 'required|exists:colors,id',
            'size' => 'required|exists:sizes,id',
            'quantity' => 'required|integer|min:1',
        ],[
            'color.required' => 'Bạn chưa chọn màu',
            'color.exists' => 'Không có màu này',
            'size.required' => 'Bạn chưa chọn size',
            'size.exists' => 'Không có size này',
            'quantity.required' => 'Bạn phải chọn số lượng',
            'quantity.integer' => 'Số lượng không hợp lệ',
            'quantity.min' => 'Số lượng sản phẩm tối thiểu phải là 1',

        ]);
        $product = Products::find($id);
        if(!$product){
            return redirect()->back()->with('error', 'Sản phẩm không tồn tại');
        }
        $variants = Product_variants::where('product_id',$id)->
        where('color_id',$request->color)->
        where('size_id',$request->size)->first();
        // dd($variants->price_atti);
        if(!$variants){
            return redirect()->back()->with('error','Sản phẩm này đã hết hàng hoặc không có xin vui lòng thao tác lại');
        }
        if($variants->stock < $request->quantity){
            return redirect()->back()->with('error',"Số lượng sản phẩm tồn kho chỉ còn $variants->stock");
        }
        $user_id = auth::user()->id;
        $items_cart = Cart::where('user_id',$user_id)->where('product_variants_id',$variants->id)->first();
        $quantity_in_db = $items_cart->quantity ?? 0;
        $new_quantity = $request->quantity+$quantity_in_db;
        // dd($new_quantity);

        if($new_quantity > $variants->stock){
            return redirect()->back()->with('error','Số lượng sản phẩm tồn kho không đủ vui lòng kiểm tra lại'); // kiểm tra xem hàng tồn kho có đủ khi khách hàng thêm 1 sản phẩm mới vào giỏ khi sản phẩm đó đã có sẵn
        }

        if(auth::user()){
            if(!$items_cart){
                Cart::create([
                    'user_id' => $user_id,
                    'product_variants_id' => $variants->id,
                    'quantity' => $request->quantity,
                    'price_at_time' => $variants->sale_price
                ]);
            return redirect()->back()->with('success','Thêm thành công');
            }else{
                $items_cart->update([
                     'quantity' => $items_cart->quantity + $request->quantity
                ]);
             return redirect()->back()->with('success','Thêm thành công');

            }
        }

    }
}
