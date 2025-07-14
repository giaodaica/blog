<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RefundMoney;
use Illuminate\Support\Facades\Auth;

class RefundMoneyController extends Controller
{
    public function store(Request $request, $id)
    {
        $user = Auth::user();
        $refund = RefundMoney::where('order_id', $id)->where('user_id', $user->id)->first();
        if ($refund && $refund->status !== 'pending') {
            return back()->with('error', 'Yêu cầu hoàn tiền đã được xử lý hoặc đang chờ duyệt.');
        }

        $data = [
            'user_id' => $user->id,
            'order_id' => $id,
            'status' => 'pending',
        ];

        $request->validate([
            'amount' => 'required|numeric|min:0',
        ]);
        $data['amount'] = $request->amount;

        if ($request->has('bank_code')) {
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
        } elseif ($request->hasFile('qr_image')) {
            $request->validate([
                'qr_image' => 'required|image|max:4096',
            ]);
            $qrPath = $request->file('qr_image')->store('uploads/qr_refund', 'public');
            $data['QR_images'] = 'storage/' . $qrPath;
        }

        // Nếu đã có record thì update, chưa có thì tạo mới
        if ($refund) {
            $refund->update($data);
        } else {
            RefundMoney::create($data);
        }

        return back()->with('success', 'Đã gửi yêu cầu hoàn tiền, vui lòng chờ duyệt!');
    }
}
