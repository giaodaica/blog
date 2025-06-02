<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdsRequest;
use App\Http\Requests\VoucherRequest;
use App\Models\CategoriesVouchers;
use App\Models\Vouchers;
use App\Models\VouchersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        if (!$title) {
            abort(403, 'Không tìm thấy trang này');
        } else if ($action) {
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
        if (!$data_voucher) {
            abort(403, 'Không thấy');
        }
        return view('dashboard.pages.voucher.detail', compact('data_voucher', 'action', 'categories'));
    }
    public function update(VoucherRequest $request, $id)
    {
        $data_voucher = Vouchers::findOrFail($id);
        if ($data_voucher->status !== 'draft') {
            abort(403, 'Không được phép sửa');
        } else {
            $data_voucher->update($request->validated());
            return redirect()->back();
        }
    }
    public function ads(AdsRequest $request)
    {
        $data = $request->validated();
        CategoriesVouchers::create($data);
        return redirect()->back();
    }
    public function disable($id)
    {
        $data = Vouchers::findOrFail($id);
        if ($data->status !== 'active') {
            abort(403, 'Không thể làm hành động này');
        }
        $data->update(['status' => 'disabled']);
        return redirect()->back();
    }
    public function active($id)
    {
        $data = Vouchers::findOrFail($id);
        if ($data->status !== 'draft') {
            abort(403, 'Không thể làm hành động này');
        }
        $data->update(['status' => 'active']);
        return redirect()->back();
    }
    public function accept_voucher($id)
    {
        if (!Auth::user()->email_verified_at) {
            return redirect()->back()->with('error', 'Tài khoản của bạn chưa xác thực vui lòng xác thực tài khoản để nhận được ưu đãi từ chúng tôi');
        }
        $user_id = Auth::id();
        $voucher = Vouchers::find($id);
        if (!$voucher) {
            return redirect()->back()->with('error', 'Voucher này không tồn tại vui lòng thử lại sau');
        }
        $voucher_user = VouchersUsers::where('voucher_id', $id)->where('user_id', $user_id)->exists();
        if ($voucher_user) {
            return redirect()->back()->with('error', 'Bạn đã có voucher này');
        }
        if ($voucher->max_used == 0) {
            return redirect()->back()->with('error', 'Voucher này đã hết lượt nhận. Cảm ơn bạn đã quan tâm! Hãy đón chờ nhiều ưu đãi mới từ chúng tôi trong thời gian tới');
        }
        VouchersUsers::create([
            'user_id' => $user_id,
            'voucher_id' => $id
        ]);
        $voucher->update([
            'max_used' => $voucher->max_used - 1,
            'received' => $voucher->received + 1
        ]);
        return redirect()->back()->with('success', 'Nhận thành công');
    }
}
