<?php

namespace App\Http\Controllers;

use App\Http\Requests\VoucherRequest;
use App\Models\CategoriesVouchers;
use App\Models\Vouchers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class VouchersController extends Controller
{
    public function show($id, Request $request)
    {
        $action = $request->query('type');
        $name_voucher = CategoriesVouchers::all();
        $title = CategoriesVouchers::where('slug', $id)->first();
        if ($title) {
            $type = $title->name;
        }
        if ($action) {
            $data_voucher = Vouchers::with('cate_vouchers')->where('category_id', $title->id)->Where('status', $action)->paginate(5);
        } else {
            $data_voucher = Vouchers::with('cate_vouchers')->where('category_id', $title->id)->paginate(5);
        }
        return view('dashboard.pages.voucher.index', compact('type', 'name_voucher', 'id', 'data_voucher'));
    }
    public function store(VoucherRequest $voucherRequest)
    {
        $action = $voucherRequest->query('action');
        $data = $voucherRequest->validated();
        $data['code'] = strtoupper($data['code']);
        Vouchers::create($data);
        return redirect()->back();
    }
    public function detail($action, $id)
    {
        $categories = CategoriesVouchers::all();
        $data_voucher = Vouchers::with('cate_vouchers')->where('id', $id)->first();
        if(!$data_voucher){
        abort(403, 'Không thấy');
        }
        return view('dashboard.pages.voucher.detail', compact('data_voucher', 'action', 'categories'));
    }
    public function update(VoucherRequest $request, $id)
    {
       $data_voucher = Vouchers::findOrFail($id);
       if($data_voucher->status !== 'draft'){
        abort(403, 'Không được phép sửa');
       }else{
         $data_voucher->update($request->validated());
        return redirect()->back();
       }
    }
}
