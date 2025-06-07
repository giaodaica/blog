<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    //
    public function index(){
         $userId = Auth::id(); // hoặc gán user_id = 1 nếu đang test
        $cartItems = Cart::with('productVariant')->where('user_id', $userId)->get();
        return view('pages.shop.cart',compact('cartItems'));
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
    $cartItem = Cart::findOrFail($request->id);
    
    if ($request->action === 'increase') {
        $cartItem->quantity += 1;
    } elseif ($request->action === 'decrease') {
        $cartItem->quantity = max(1, $cartItem->quantity - 1);
    }

    $cartItem->save();

    return response()->json([
        'success' => true,
        'quantity' => $cartItem->quantity,
        'subtotal' => number_format($cartItem->quantity * $cartItem->price_at_time, 0, ',', '.') . ' đ'
    ]);
}

}
