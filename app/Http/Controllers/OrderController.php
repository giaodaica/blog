<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderHistories;
use App\Models\OrderItem;
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
                    $note = 'Đơn hàng đã được xác nhận';
                }
                break;
            case 'confirmed':
                if ($present->status != 'confirmed') {
                    return abort(403, 'Bạn không thể đổi sang trạng thái giao hàng khi đơn hàng không ở trạng thái đã xác nhận ');
                } else {
                    $present->status = 'shipping';
                    $note = 'Đơn vị vận chuyển đã lấy hàng, chuẩn bị giao hàng';
                }
                break;
            case 'shipping':
                if ($present->status != 'shipping') {
                    return abort(403, 'Bạn không thể đổi sang trạng thái đã giao hàng khi đơn hàng không ở trạng thái đang giao hàng ');
                } else {
                    $present->status = 'success';
                    $note = 'Đơn hàng đã được giao thành công';
                }
                break;
            case 'failed':
                if ($present->status != 'shipping') {
                    return abort(403, 'Bạn không thể đổi sang trạng thái giao hàng thất bại khi đơn hàng không ở trạng thái đang giao hàng ');
                } else {
                    $present->status = 'failed';
                    $note = 'Giao hàng thất bại';
                }
                break;
            case 'return':
                if ($present->status != 'failed') {
                    return abort(403, 'Bạn không thể đổi sang trạng thái giao lại khi đơn hàng không ở trạng thái giao hàng thất bại ');
                } else {
                    $present->status = 'shipping';
                    $note = 'Đơn vị vận chuyển đã lấy hàng , chuẩn bị giao hàng';
                }
                break;
            case 'cancelled':
                if ($present->status == 'failed' || $present->status == 'pending' || $present->status == 'confirmed') {
                    $present->status = 'cancelled';
                    $note = 'Đơn hàng đã được hủy theo yêu cầu của khách hàng';
                } else {
                    return abort(403, 'Đơn chỉ được hủy khi ở trạng thái chưa xác nhận , đã xác nhận hoặc đơn giao thất bại');
                }
                break;
        }

            $present->save();
            OrderHistories::create([
                'users' => Auth::user()->id,
                'order_id' => $id,
                'from_status' => $old_status->status,
                'to_status' => $present->status,
                'note' => $note

            ]);


        return redirect()->back()->with('success', 'Cập nhật trạng thái đơn hàng thành công!');
    }
    public function db_order_show($id)
    {
        $data_order = Order::join('vouchers','vouchers.id','orders.voucher_id')->
        join('address_books','address_books.id','orders.address_books_id')->
        join('users','users.id','orders.user_id')->
        select(
            'orders.*',
            'vouchers.code',
            'address_books.name as ad_name',
            'address_books.address as ad_address',
            'address_books.phone as ad_phone',
            'users.email',
        )->where('orders.id',$id)
        ->first();
        $data_order_items = OrderItem::join('orders', 'orders.id', 'order_items.order_id')->
        join('product_variants', 'product_variants.id', 'order_items.product_variant_id')->
        join('sizes', 'sizes.id', 'product_variants.size_id')->
        join('colors', 'colors.id', 'product_variants.color_id')->
        where('order_id', $id)->
        select(
                'order_items.*',
                'sizes.size_name',
                'colors.color_name',
            )->get();
            $history_1 = OrderHistories::where('from_status','pending')->where('to_status','confirmed')->where('order_id',$id)->first();
            $history_2 = OrderHistories::where('from_status','confirmed')->where('to_status','shipping')->where('order_id',$id)->first();
            $history_3 = OrderHistories::where('from_status','shipping')->where('to_status','failed')->where('order_id',$id)->first();
            $history_4 = OrderHistories::where('from_status','failed')->where('to_status','shipping')->where('order_id',$id)->first();
            $history_5 = OrderHistories::where('from_status','shipping')->where('to_status','success')->where('order_id',$id)->first();
        // $historyItems = OrderHistories::where('order_id', $id)->get()->keyBy('from_status');
        // dd($historyItems);
        // dd($data_order);
        // dd($data_order_items);

        return view('dashboard.pages.order.detail', compact('data_order', 'data_order_items'));
    }
}
