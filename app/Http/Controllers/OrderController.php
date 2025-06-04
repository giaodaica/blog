<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderHistories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    //
    public function index()
    {
        return view('pages.shop.checkout');
    }
    public function done()
    {
        return view('pages.shop.success_checkout');
    }
    public function db_order(Request $request)
    {
        $action = ['pending', 'confirmed', 'shipping', 'success', 'cancelled'];
        $type = $request->query('type');
        if ($type && !in_array($type, $action)) {
            return abort(403, 'Không có hành động này');
        }
        if ($type) {
            $data_order = Order::where('status', $type)->paginate(10);
        } else {
            $data_order = Order::paginate(10);
        }
        // dd($data_order);
        return view('dashboard.pages.order.index', compact('data_order'));
    }
    public function db_order_change(Request $request, $id)
    {
        $before = $request->change;
        // dd($before);
        $data_change = ['pending', 'confirmed', 'shipping', 'cancelled', 'failed', 'return'];
        if ($before && !in_array($before, $data_change)) {
            return  abort(403, "Hành động không hợp lệ");
        }
        $old_status = Order::find($id);
        $present = Order::find($id);
        if (!$present || !$old_status) {
            return abort(403, 'Không thấy đơn hàng này vui lòng kiểm tra lại');
        }
        switch ($before) {
            case 'pending':
                if ($present->status != 'pending') {
                    return abort(403, "Bạn không thể đổi sang trạng thái đã xác nhận khi đơn hàng không ở trạng thái chưa xác nhận ");
                } else {
                    $present->status = 'confirmed';
                    $note = 'Đã gọi xác nhận đặt hàng';
                }
                break;
            case 'confirmed':
                if ($present->status != 'confirmed') {
                    return abort(403, 'Bạn không thể đổi sang trạng thái giao hàng khi đơn hàng không ở trạng thái đã xác nhận ');
                } else {
                    $present->status = 'shipping';
                    $note = 'không có vấn đề gì ';
                }
                break;
            case 'shipping':
                if ($present->status != 'shipping') {
                    return abort(403, 'Bạn không thể đổi sang trạng thái đã giao hàng khi đơn hàng không ở trạng thái đang giao hàng ');
                } else {
                    $present->status = 'success';
                    $note = 'không có vấn đề gì ';
                }
                break;
            case 'failed':
                if ($present->status != 'shipping') {
                    return abort(403, 'Bạn không thể đổi sang trạng thái giao hàng thất bại khi đơn hàng không ở trạng thái đang giao hàng ');
                } else {
                    $present->status = 'failed';
                    $note = 'không có vấn đề gì ';
                }
                break;
            case 'return':
                if ($present->status != 'failed') {
                    return abort(403, 'Bạn không thể đổi sang trạng thái giao lại khi đơn hàng không ở trạng thái giao hàng thất bại ');
                } else {
                    $present->status = 'shipping';
                    $note = 'không có vấn đề gì ';
                }
                break;
            case 'cancelled':
                if ($present->status == 'failed' || $present->status == 'pending' || $present->status == 'confirmed') {
                    $present->status = 'cancelled';
                    $note = 'Khách yêu cầu hủy đơn ';
                } else {
                    return abort(403, 'Đơn chỉ được hủy khi ở trạng thái chưa xác nhận , đã xác nhận hoặc đơn giao thất bại');
                }
                break;
        }
        try {
            $present->save();
            OrderHistories::create([
                'users' => Auth::user()->id,
                'order_id' => $id,
                'from_status' => $old_status->status,
                'to_status' => $present->status,
                'note' => $note
            ]);
        } catch (\Exception $e) {
            Log::error('Lỗi khi cập nhật trạng thái đơn hàng: ' . $e->getMessage());
            return redirect()->back()->withErrors('Cập nhật trạng thái đơn hàng thất bại, vui lòng thử lại sau.');
        }

        return redirect()->back()->with('success', 'Cập nhật trạng thái đơn hàng thành công!');
    }
}
