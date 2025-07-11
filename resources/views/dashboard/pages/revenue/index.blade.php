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
                        <h4 class="mb-sm-0">
                            @if ($start == $end)
                                Thống kê trong ngày
                            @else
                                Kết quả thống kê
                                {{ 'Từ ' . formatDate($start ?? '01-01-2025') . ' đến ' . formatDate($end ?? now()) }}
                            @endif
                        </h4>
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
                    <form method="get" action="{{ route('dashboard.revenue') }}"
                        class="row g-3 align-items-end p-3 bg-light rounded shadow-sm" id="filter-form">
                        @csrf
                        <div class="col-md-3">
                            <label for="type" class="form-label fw-bold">Kiểu thống kê</label>
                            <select class="form-select" id="type" name="type">
                                <option value="day" {{ request('type') == 'day' ? 'selected' : '' }}>Theo ngày</option>
                                <option value="month" {{ request('type') == 'month' ? 'selected' : '' }}>Theo tháng
                                </option>
                                <option value="year" {{ request('type') == 'year' ? 'selected' : '' }}>Theo năm</option>
                                <option value="hour" {{ request('type') == 'hour' ? 'selected' : '' }}>Theo giờ</option>
                            </select>
                        </div>
                        <div class="col-md-4" id="filter-date">
                            <label class="form-label fw-bold">Khoảng ngày</label>
                            <div class="input-group">
                                <input type="date" class="form-control" id="date_from" name="date_from"
                                    value="{{ request('date_from') }}">
                                <span class="input-group-text">-</span>
                                <input type="date" class="form-control" id="date_to" name="date_to"
                                    value="{{ request('date_to') }}">
                            </div>
                        </div>
                        <div class="col-md-4 d-none" id="filter-month">
                            <label class="form-label fw-bold">Khoảng tháng</label>
                            <div class="input-group">
                                <input type="month" class="form-control" id="month_from" name="month_from"
                                    value="{{ request('month_from') }}">
                                <span class="input-group-text">-</span>
                                <input type="month" class="form-control" id="month_to" name="month_to"
                                    value="{{ request('month_to') }}">
                            </div>
                        </div>
                        <div class="col-md-4 d-none" id="filter-year">
                            <label class="form-label fw-bold">Khoảng năm</label>
                            <div class="input-group">
                                <input type="number" min="2000" max="2100" class="form-control" id="year_from"
                                    name="year_from" value="{{ request('year_from', date('Y')) }}">
                                @error('year_from')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <span class="input-group-text">-</span>
                                <input type="number" min="2000" max="2100" class="form-control" id="year_to"
                                    name="year_to" value="{{ request('year_to', date('Y')) }}">

                            </div>
                        </div>
                        <div class="col-md-4 d-none" id="filter-hour">
                            <label class="form-label fw-bold">Khoảng ngày/giờ</label>
                            <div class="input-group">
                                <input type="datetime-local" class="form-control" id="datetime_from" name="datetime_from"
                                    value="{{ request('datetime_from') }}">
                                <span class="input-group-text">-</span>
                                <input type="datetime-local" class="form-control" id="datetime_to" name="datetime_to"
                                    value="{{ request('datetime_to') }}">
                            </div>
                        </div>
                        <div class="col-md-1 d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Lọc</button>
                            <a href="{{ route('dashboard.revenue') }}" class="btn btn-primary">Xóa</a>

                        </div>
                             @if ($errors->any())
                            <div class="text-danger">
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </div>
                            @endif
                    </form>
                </div>
            </div>
            <!-- Thống kê nhanh đơn hàng -->
            <div class="row mb-3 align-items-stretch">
                <div class="col-md-2">
                    <div class="card text-center border-primary h-100">
                        <div class="card-body">
                            <div class="fw-bold text-primary" style="font-size: 1.5rem;">
                                {{ $data_order->sodonhang ?? 0 }}</div>
                            <div class="text-muted">Tổng đơn hàng</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card text-center border-warning h-100">
                        <div class="card-body">
                            <div class="fw-bold text-warning" style="font-size: 1.5rem;">
                                {{ $data_order->donhang_dangcho ?? 0 }}</div>
                            <div class="text-muted">Đơn chưa xử lý</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card text-center border-info h-100">
                        <div class="card-body">
                            <div class="fw-bold text-info" style="font-size: 1.5rem;">
                                {{ $data_order->donhang_dangvanchuyen ?? 0 }}</div>
                            <div class="text-muted">Đang giao hàng</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card text-center border-success h-100">
                        <div class="card-body">
                            <div class="fw-bold text-success" style="font-size: 1.5rem;">
                                {{ $data_order->donhang_thanhcong ?? 0 }}</div>
                            <div class="text-muted">Đơn đã hoàn thành</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card text-center border-danger h-100">
                        <div class="card-body">
                            <div class="fw-bold text-danger" style="font-size: 1.5rem;">
                                {{ $data_order->donhang_huy ?? 0 }}</div>
                            <div class="text-muted">Đơn đã hủy</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card text-center border-danger h-100">
                        <div class="card-body">
                            <div class="fw-bold text-danger" style="font-size: 1.5rem;">
                                {{ $data_order->donhang_thatbai ?? 0 }}</div>
                            <div class="text-muted">Giao thất bại</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 d-flex align-items-center justify-content-center">
                    <a href="" class="btn btn-outline-primary w-100">
                        Xem chi tiết
                    </a>
                </div>
            </div>
            <!-- Hiển thị kết quả thống kê -->
            <div class="row">
                <div class="col-12">
                    <!-- Thay thế bảng này bằng dữ liệu thực tế -->
                    <div class="card">
                        <div class="card-header">Thống Kê Doanh Thu</div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Doanh thu</th>
                                        <th>Số sản phẩm bán</th>
                                        <th>Doanh thu trung bình/đơn</th>
                                        <th>Tổng giảm giá</th>
                                        <th>Lợi nhuận</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @if ($data_doanhthu->sodonhang > 0)
                                        <tr>
                                            <td>{{ number_format($data_doanhthu->doanhthu) }} đ</td>
                                            <td>{{ $data_doanhthu->tongsanpham }}</td>
                                            <td>{{ number_format($dtb) }} đ</td>
                                            <td>{{ number_format($data_doanhthu->tong_giam_gia) }} đ</td>
                                            <td>{{ number_format($data_doanhthu->loinhuan) }} đ</td>
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
            <!-- Sản phẩm bán chạy -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card border-info">
                        <div class="card-header bg-info text-white fw-bold">
                            Top sản phẩm bán chạy
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Tên sản phẩm</th>
                                        <th>Số lượng bán</th>
                                        {{-- <th>Doanh thu</th> --}}
                                    </tr>
                                </thead>
                                <tbody>

                                    @forelse($data_top_5 as $i => $product)
                                        <tr>
                                            <td>{{ $i + 1 }}</td>
                                            <td>{{ $product->ten_san_pham }}</td>
                                            <td>{{ $product->soluong_ban }}</td>
                                            {{-- <td>{{ number_format($product->doanhthu) }} đ</td> --}}
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">Không có dữ liệu</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Top người dùng mua hàng nhiều -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card border-success">
                        <div class="card-header bg-success text-white fw-bold">
                            Top khách hàng mua nhiều nhất
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Tên khách hàng</th>
                                        <th>Số đơn hàng</th>
                                        <th>Tổng giá trị mua</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($data_top_5_users as $i => $user)
                                        <tr>
                                            <td>{{ $i + 1 }}</td>
                                            <td>{{ $user->user_name }}</td>
                                            <td>{{ $user->so_don_hang }}</td>
                                            <td>{{ number_format($user->tong_tien_mua) }} đ</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">Không có dữ liệu</td>
                                        </tr>
                                    @endforelse
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
            if (type === 'day') document.getElementById('filter-date').classList.remove('d-none');
            if (type === 'month') document.getElementById('filter-month').classList.remove('d-none');
            if (type === 'year') document.getElementById('filter-year').classList.remove('d-none');
            if (type === 'hour') document.getElementById('filter-hour').classList.remove('d-none');
        }
        document.getElementById('type').addEventListener('change', showFilterInput);
        window.onload = showFilterInput;
    </script>
@endsection

{{-- Fake dữ liệu sản phẩm bán chạy --}}
