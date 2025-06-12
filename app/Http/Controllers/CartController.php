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
}
