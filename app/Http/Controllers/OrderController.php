<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    //
    public function index(){
        return view('pages.shop.checkout');
    }
    public function done(){
        return view('pages.shop.success_checkout');
    }
    public function db_order(Request $request)  {
        $action = ['pending','confirmed','shipping','success','cancelled'];
        $type = $request->query('type');
        if($type && !in_array($type,$action)){
            abort(403,'Không có hành động này');
        }
        if($type){
            $data_order = Order::where('status',$type)->paginate(10);
        }else{
          $data_order = Order::paginate(10);

        }
        // dd($data_order);
        return view('dashboard.pages.order.index',compact('data_order'));

    }
}
