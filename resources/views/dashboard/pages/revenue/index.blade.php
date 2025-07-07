@extends('dashboard.layouts.layout')
@section('css-content')
<!-- Thêm CSS nếu cần -->
@endsection
@section('main-content')
<div class="page-content">
    <div class="container-fluid">
         <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Thống kê</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Hệ Thống</a></li>
                                <li class="breadcrumb-item active">Thống kê doanh thu</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Form lọc thống kê -->
            <div class="row mb-4">
                <div class="col-12">
                    <form method="post" action="{{route('dashboard.order.fillter')}}" class="row g-3 align-items-end p-3 bg-light rounded shadow-sm" id="filter-form">
                        @csrf
                        <div class="col-md-3">
                            <label for="type" class="form-label fw-bold">Kiểu thống kê</label>
                            <select class="form-select" id="type" name="type">
                                <option value="day" {{ request('type') == 'day' ? 'selected' : '' }}>Theo ngày</option>
                                <option value="month" {{ request('type') == 'month' ? 'selected' : '' }}>Theo tháng</option>
                                <option value="year" {{ request('type') == 'year' ? 'selected' : '' }}>Theo năm</option>
                                <option value="hour" {{ request('type') == 'hour' ? 'selected' : '' }}>Theo giờ</option>
                            </select>
                        </div>
                        <div class="col-md-4" id="filter-date">
                            <label class="form-label fw-bold">Khoảng ngày</label>
                            <div class="input-group">
                                <input type="date" class="form-control" id="date_from" name="date_from" value="{{ request('date_from') }}">
                                <span class="input-group-text">-</span>
                                <input type="date" class="form-control" id="date_to" name="date_to" value="{{ request('date_to') }}">
                            </div>
                        </div>
                        <div class="col-md-4 d-none" id="filter-month">
                            <label class="form-label fw-bold">Khoảng tháng</label>
                            <div class="input-group">
                                <input type="month" class="form-control" id="month_from" name="month_from" value="{{ request('month_from') }}">
                                <span class="input-group-text">-</span>
                                <input type="month" class="form-control" id="month_to" name="month_to" value="{{ request('month_to') }}">
                            </div>
                        </div>
                        <div class="col-md-4 d-none" id="filter-year">
                            <label class="form-label fw-bold">Khoảng năm</label>
                            <div class="input-group">
                                <input type="number" min="2000" max="2100" class="form-control" id="year_from" name="year_from" value="{{ request('year_from', date('Y')) }}">
                                <span class="input-group-text">-</span>
                                <input type="number" min="2000" max="2100" class="form-control" id="year_to" name="year_to" value="{{ request('year_to', date('Y')) }}">
                            </div>
                        </div>
                        <div class="col-md-4 d-none" id="filter-hour">
                            <label class="form-label fw-bold">Khoảng ngày/giờ</label>
                            <div class="input-group">
                                <input type="datetime-local" class="form-control" id="datetime_from" name="datetime_from" value="{{ request('datetime_from') }}">
                                <span class="input-group-text">-</span>
                                <input type="datetime-local" class="form-control" id="datetime_to" name="datetime_to" value="{{ request('datetime_to') }}">
                            </div>
                        </div>
                        <div class="col-md-1 d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Lọc</button>
                            <a href="{{route('dashboard.revenue')}}" class="btn btn-primary">Xóa</a>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Hiển thị kết quả thống kê -->
            <div class="row">
                <div class="col-12">
                    <!-- Thay thế bảng này bằng dữ liệu thực tế -->
                    <div class="card">
                        <div class="card-header">Kết quả thống kê</div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Doanh thu</th>
                                        <th>Số đơn hàng</th>
                                        <th>Số sản phẩm bán</th>
                                        <th>Doanh thu trung bình/đơn</th>
                                        <th>Tổng giảm giá</th>
                                        <th>Lợi nhuận</th>
                                    </tr>
                                </thead>
                                <tbody>

                                 @if($data->sodonhang > 0)
                                    <tr>
                                        <td>{{ number_format($data->doanhthu) }} đ</td>
                                        <td>{{ $data->sodonhang }}</td>
                                        <td>{{ $data->tongsanpham }}</td>
                                        <td>{{ number_format($dtb) }} đ</td>
                                        <td>{{ number_format($data->tong_giam_gia) }} đ</td>
                                        <td>{{ number_format($data->loinhuan) }} đ</td>
                                    </tr>
                                 @else
                                    <tr>
                                        <td colspan="6" class="text-center">Không có dữ liệu thống kê</td>
                                    </tr>   

                                 @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</div>
@endsection

@section('js-content')
<script>
    function showFilterInput() {
        let type = document.getElementById('type').value;
        document.getElementById('filter-date').classList.add('d-none');
        document.getElementById('filter-month').classList.add('d-none');
        document.getElementById('filter-year').classList.add('d-none');
        document.getElementById('filter-hour').classList.add('d-none');
        if(type === 'day') document.getElementById('filter-date').classList.remove('d-none');
        if(type === 'month') document.getElementById('filter-month').classList.remove('d-none');
        if(type === 'year') document.getElementById('filter-year').classList.remove('d-none');
        if(type === 'hour') document.getElementById('filter-hour').classList.remove('d-none');
    }
    document.getElementById('type').addEventListener('change', showFilterInput);
    window.onload = showFilterInput;
</script>
@endsection

