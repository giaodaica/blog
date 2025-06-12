<?php

namespace App\Http\Controllers;

use App\Models\Vouchers;
use App\Models\Products;
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
        $voucher_id = Vouchers::where('type_discount', 'percent')->where('status', 'active')->where('value', 15)->where('max_used', '>=', 1)->first();
        // Sản Phẩm Bán Chạy Nhất   
        $bestSellers = Products::with(['category', 'variants.color', 'variants.size'])
            ->whereHas('category', function ($query) {
                $query->where('status', '1');
            })
            ->whereHas('variants', function ($query) {
                $query->where('is_show', 1)->whereNull('deleted_at');
            })
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        // Sản Phẩm Nổi Bật
        $featured = Products::with(['category', 'variants.color', 'variants.size'])
            ->whereHas('category', function ($query) {
                $query->where('status', '1');
            })
            ->whereHas('variants', function ($query) {
                $query->where('is_show', 1)->whereNull('deleted_at');
            })
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'desc')
            ->paginate(5);
        return view('pages.shop.index', compact('voucher_id', 'bestSellers', 'featured'));
    }
    public function info_customer()
    {
        return view('pages.shop.account');
    }
    public function show($id)
    {
        return view('pages.shop.show');
    }
    public function admin()
    {
        return view('dashboard.index');
    }

    public function shop(){
        return view('pages.shop.index');
    }


}
