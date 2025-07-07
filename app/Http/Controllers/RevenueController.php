<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class RevenueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // dd($_POST);

        $query = Order::selectRaw('
        COUNT(*) as sodonhang,
        SUM(final_amount) as doanhthu,
        SUM(discount_amount) as tong_giam_gia,
        SUM(quantity) as tongsanpham
    ')
            ->join('order_items', 'order_items.order_id', 'orders.id')
            ->where('status', 'success');

        switch ($request->type) {
            case 'hour':
                $query->whereDate('orders.created_at', '>=', $request->datetime_from)
                    ->whereDate('orders.created_at', '<=', $request->datetime_to);
                break;
            case 'day':
                $query->whereDate('orders.created_at', '>=', $request->date_from)
                    ->whereDate('orders.created_at', '<=', $request->date_to);
                break;
            case 'month':
                [$year_s, $month_s] = explode('-', $request->month_from);
                [$year_z, $month_z] = explode('-', $request->month_to);

                $query->where(function ($q) use ($year_s, $month_s, $year_z, $month_z) {
                    $q->whereYear('orders.created_at', '>=', $year_s)
                        ->whereYear('orders.created_at', '<=', $year_z)
                        ->whereMonth('orders.created_at', '>=', $month_s)
                        ->whereMonth('orders.created_at', '<=', $month_z);
                });

                // dd($query->toSql(), $query->getBindings());
                break;
            case 'year':
                $query->whereYear('orders.created_at', '>=', $request->year_from)
                    ->whereYear('orders.created_at', '<=', $request->year_to);
                break;
        }

        $data = $query->first();
        // dd($data);
        $sodonhang = $data->sodonhang ?? 0;
        $doanhthu = $data->doanhthu ?? 0;
        $dtb = $sodonhang > 0 ? $doanhthu / $sodonhang : 0;

        return view('dashboard.pages.revenue.index', compact('data', 'dtb'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
