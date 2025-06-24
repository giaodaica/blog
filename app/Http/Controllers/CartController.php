<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product_variants;
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
        $variants = Product_variants::where('product_id',$id)->
        where('color_id',$request->color)->
        where('size_id',$request->size)->first();
        // dd($variants->price_atti);
        if(!$variants){
            return redirect()->back()->with('error','Sản phẩm này đã hết hàng hoặc không có xin vui lòng thao tác lại');
        }
        if($variants->stock < $request->quantity){
            return redirect()->back()->with('error','Số lượng sản phẩm tồn kho không đủ vui lòng kiểm tra lại');
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
