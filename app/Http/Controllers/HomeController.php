<?php

namespace App\Http\Controllers;

use App\Models\Vouchers;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $voucher_id = Vouchers::where('type_discount','percent')->where('status','active')->where('value',15)->where('max_used','>=',1)->first();
        return view('pages.shop.index',compact('voucher_id'));
    }
    public function info_customer(){
        return view('pages.shop.account');
    }
    public function show($id){
        return view('pages.shop.show');
    }
    public function admin(){
        return view('dashboard.index');
    }

}
