<?php

namespace App\Http\Controllers;

use App\Models\AddressBook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\OrderItem;

class InfoController extends Controller
{
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $user->update($request->validate([
            'name' => 'required|string|max:255',
            'default_phone' => 'nullable|string|max:20',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]));
        // dd($user);
        return redirect()->back()->with('success', 'Thông tin đã được cập nhật thành công!');
    }

    public function account()
    {
        $user = Auth::user();
    
        $orders = Order::with([
            'orderItems.productVariant.color',
            'orderItems.productVariant.size',
            'orderItems.productVariant.product'
        ])
        ->where('user_id', $user->id)
        ->orderBy('created_at', 'desc')
        ->get();
    
        $addresses = AddressBook::where('user_id', $user->id)->limit(2)->get();
    
        return view('pages.shop.account', compact('orders', 'addresses'));
    }
   
}
