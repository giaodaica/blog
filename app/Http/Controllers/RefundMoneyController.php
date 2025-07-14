<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RefundMoney;
use Illuminate\Support\Facades\Auth;

class RefundMoneyController extends Controller
{
    public function store(Request $request, $id)
    {
        // dd($request->all());
        $user = Auth::user();
        $order = \App\Models\Order::findOrFail($id);

        // Chỉ cho phép chủ đơn hàng gửi yêu cầu hoàn tiền
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Bạn không có quyền truy cập đơn hàng này!');
        }

        // Chặn nếu đơn hàng đã hoàn tiền
        if ($order->status === 'refunded') {
            abort(403, 'Đơn hàng này đã được hoàn tiền!');
        }

        $refund = RefundMoney::where('order_id', $id)->where('user_id', $user->id)->first();
        if ($refund && $refund->status !== 'admin') {
            return back()->with('error', 'Yêu cầu hoàn tiền đã được xử lý hoặc đang chờ duyệt.');
        }

        // Debug: log dữ liệu request
        \Log::info('Refund request data:', $request->all());

        $data = [
            'user_id' => $user->id,
            'order_id' => $id,
            'status' => 'pending',
        ];

        $request->validate([
            'amount' => 'required|numeric|min:0',
        ]);
        
        // Kiểm tra số tiền hoàn phải đúng bằng giá trị đơn hàng
        if ($request->amount != $order->final_amount) {
            return back()->withErrors(['amount' => 'Sai giá trị đơn hàng'])->withInput();
        }
        $data['amount'] = $request->amount;

        // Debug: log dữ liệu sẽ ghi vào DB
        \Log::info('Refund DB data:', $data);

        // Kiểm tra xem có dữ liệu STK hay QR
        $hasStkData = $request->filled('bank_code') && $request->filled('account_number') && $request->filled('account_name') && $request->filled('reason');
        $hasQrData = $request->hasFile('qr_image');

        if ($hasStkData) {
            $request->validate([
                'bank_code' => 'required|string',
                'account_number' => 'required|string',
                'account_name' => 'required|string',
                'reason' => 'required|string',
            ]);
            $data['bank'] = $request->bank_code;
            $data['stk'] = $request->account_number;
            $data['bank_account_name'] = $request->account_name;
            $data['reason'] = $request->reason;
        } elseif ($hasQrData) {
            $request->validate([
                'qr_image' => 'required|image|max:4096',
            ]);
            $file = $request->file('qr_image');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/qr_refund'), $fileName);
            $data['QR_images'] = 'uploads/qr_refund/' . $fileName;
        } else {
            return back()->withErrors(['general' => 'Vui lòng điền đầy đủ thông tin STK hoặc upload mã QR.'])->withInput();
        }

        // Nếu đã có record thì update, chưa có thì tạo mới
        if ($refund) {
            $refund->update($data);
        } else {
            RefundMoney::create($data);
        }

        return redirect()->route('home.orderDetail', $id)
            ->with('success', 'Yêu cầu hoàn tiền đã được gửi thành công, vui lòng chờ duyệt!');
    }

    public function showRefundRequest($id)
    {
        $order = \App\Models\Order::findOrFail($id);

        // Chỉ cho phép chủ đơn hàng truy cập
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Bạn không có quyền truy cập đơn hàng này!');
        }

        // Chặn nếu đơn hàng đã hoàn tiền
        if ($order->status === 'refunded') {
            abort(403, 'Đơn hàng này đã được hoàn tiền!');
        }

        $user = Auth::user();
        $refund = \App\Models\RefundMoney::where('order_id', $id)->where('user_id', $user->id)->first();

        // Nếu đã gửi yêu cầu hoàn tiền và chưa bị admin từ chối, chặn truy cập
        if ($refund && in_array($refund->status, ['pending'])) {
            abort(403, 'Bạn đã gửi yêu cầu hoàn tiền cho đơn hàng này và đang chờ xử lý!');
        }

        $total = $order->final_amount ?? 0;
        return view('pages.shop.refund-request', compact('order', 'total', 'refund'));
    }
}
