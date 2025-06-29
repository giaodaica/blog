@extends('dashboard.layouts.layout')
@section('css-content')
@endsection
@section('main-content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Chi tiết đơn hàng</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Hệ thống</a></li>
                                <li class="breadcrumb-item active">Chi tiết</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-xl-9">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h5 class="card-title flex-grow-1 mb-0">Đơn hàng#{{ $data_order->code_order }}</h5>
                                <div class="flex-shrink-0">
                                    <a href="apps-invoices-details.html" class="btn btn-success btn-sm"><i
                                            class="ri-download-2-fill align-middle me-1"></i> Invoice</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive table-card">
                                <table class="table table-nowrap align-middle table-borderless mb-0">
                                    <thead class="table-light text-muted">
                                        <tr>
                                            <th scope="col">Sản phẩm</th>
                                            <th scope="col">Giá</th>
                                            <th scope="col">Số lượng</th>
                                            <th scope="col" class="text-end">Tổng tiền</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data_order_items as $rende_order_items)
                                            <tr>
                                                <td>
                                                    <div class="d-flex">
                                                        <div class="flex-shrink-0 avatar-md bg-light rounded p-1">
                                                            <img src="assets/images/products/img-8.png" alt=""
                                                                class="img-fluid d-block">
                                                        </div>
                                                        <div class="flex-grow-1 ms-3">
                                                            <h5 class="fs-15"><a href=""
                                                                    class="link-primary">{{ $rende_order_items->product_name . ' ' . $rende_order_items->color_name }}</a>
                                                            </h5>
                                                            <p class="text-muted mb-0">Màu: <span
                                                                    class="fw-medium">{{ $rende_order_items->color_name }}</span>
                                                            </p>
                                                            <p class="text-muted mb-0">Size: <span
                                                                    class="fw-medium">{{ $rende_order_items->size_name }}</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ number_format($rende_order_items->sale_price) }}</td>
                                                <td>{{ $rende_order_items->quantity }}</td>
                                                <td class="fw-medium text-end">
                                                    {{ number_format($rende_order_items->sale_price * $rende_order_items->quantity) }}
                                                </td>
                                            </tr>
                                        @endforeach
                                        <tr class="border-top border-top-dashed">
                                            <td colspan="3"></td>
                                            <td colspan="2" class="fw-medium p-0">
                                                <table class="table table-borderless mb-0">
                                                    <tbody>
                                                        <tr>
                                                            <td>Tổng đơn :</td>
                                                            <td class="text-end">
                                                                {{ number_format($data_order->total_amount) }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Giảm giá : 15% <br>
                                                                <b><a rel="noopener noreferrer" target="_blank"
                                                                        href="{{ url("dashboard/voucher/s/$data_order->voucher_id") }}">{{ $data_order->code }}</a></b>
                                                            </td>

                                                            <td class="text-end">
                                                                -{{ number_format($data_order->discount_amount) }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Phí giao hàng :</td>
                                                            <td class="text-end">
                                                                {{ number_format($data_order->shipping_fee) }}</td>
                                                        </tr>
                                                        {{-- <tr>
                                                                    <td>Estimated Tax :</td>
                                                                    <td class="text-end">$44.99</td>
                                                                </tr> --}}
                                                        <tr class="border-top border-top-dashed">
                                                            <th scope="row">Tổng (VND) :</th>
                                                            <th class="text-end">
                                                                {{ number_format($data_order->final_amount) }}</th>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!--end card-->
                    <div class="card">
                        <div class="card-header">
                            <div class="d-sm-flex align-items-center">
                                <h5 class="card-title flex-grow-1 mb-0">Trạng thái đơn hàng</h5>
                                <div class="flex-shrink-0 mt-2 mt-sm-0">
                                    <a href="javascript:void(0);" class="btn btn-soft-info btn-sm mt-2 mt-sm-0"><i
                                            class="ri-map-pin-line align-middle me-1"></i> Thay đổi địa chỉ</a>
                                    <a href="javascript:void(0);" class="btn btn-soft-danger btn-sm mt-2 mt-sm-0"><i
                                            class="mdi mdi-archive-remove-outline align-middle me-1"></i> Hủy đơn</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th scope="col">STT</th>
                                            <th scope="col">Người duyệt</th>
                                            <th scope="col">Thời gian duyệt</th>
                                            <th scope="col">Trạng thái thay đổi</th>
                                            <th scope="col">Nội dung</th>
                                            <th scope="col">Ghi chú</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($histoty_order as $key => $history)
                                            <tr>
                                            <td>{{ count($histoty_order) - $key }}</td>
                                                <td>{{ $history->user_name }}</td>
                                                <td>{{ formatDate($history->created_at) }}</td>
                                                @php
                                                    $statusMap = [
                                                        'pending' => 'Chờ duyệt',
                                                        'confirmed' => 'Đã duyệt',
                                                        'shipping' => 'Đang giao',
                                                        'success' => 'Hoàn thành',
                                                        'failed' => 'Giao thất bại',
                                                        'cancelled' => 'Đã hủy',
                                                        // Thêm các trạng thái khác nếu có
                                                    ];
                                                @endphp
                                                <td>
                                                    {{ $statusMap[$history->from_status] ?? $history->from_status }}
                                                    =>
                                                    {{ $statusMap[$history->to_status] ?? $history->to_status }}
                                                </td>
                                                <td>{{ $history->note }}</td>
                                                <td>{{ $history->content }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center text-muted">Chưa có lịch sử duyệt đơn
                                                    hàng</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!--end card-->
                </div>
                <!--end col-->
                <div class="col-xl-3">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex">
                                <h5 class="card-title flex-grow-1 mb-0"><i
                                        class="mdi mdi-truck-fast-outline align-middle me-1 text-muted"></i> Logistics
                                    Details</h5>
                                <div class="flex-shrink-0">
                                    <a href="javascript:void(0);" class="badge bg-primary-subtle text-primary fs-11">Track
                                        Order</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="text-center">
                                <lord-icon src="https://cdn.lordicon.com/uetqnvvg.json" trigger="loop"
                                    colors="primary:#405189,secondary:#0ab39c" style="width:80px;height:80px"></lord-icon>
                                <h5 class="fs-16 mt-2">RQK Logistics</h5>
                                <p class="text-muted mb-0">ID: MFDS1400457854</p>
                                <p class="text-muted mb-0">Payment Mode : Debit Card</p>
                            </div>
                        </div>
                    </div>
                    <!--end card-->

                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex">
                                <h5 class="card-title flex-grow-1 mb-0">Khách đặt</h5>
                                <div class="flex-shrink-0">
                                    <a href="javascript:void(0);" class="link-secondary">Thông tin</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled mb-0 vstack gap-3">
                                <li>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <img src="assets/images/users/avatar-3.jpg" alt=""
                                                class="avatar-sm rounded">
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="fs-14 mb-1">{{ $data_order->name }}</h6>
                                            <p class="text-muted mb-0">Khách hàng</p>
                                        </div>
                                    </div>
                                </li>
                                <li><i
                                        class="ri-mail-line me-2 align-middle text-muted fs-16"></i>{{ $data_order->email }}
                                </li>
                                <li><i
                                        class="ri-phone-line me-2 align-middle text-muted fs-16"></i>{{ $data_order->phone }}
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!--end card-->
                    {{-- <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0"><i class="ri-map-pin-line align-middle me-1 text-muted"></i>
                                Billing Address</h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled vstack gap-2 fs-13 mb-0">
                                <li class="fw-medium fs-14">Joseph Parker</li>
                                <li>+(256) 245451 451</li>
                                <li>2186 Joyce Street Rocky Mount</li>
                                <li>New York - 25645</li>
                                <li>United States</li>
                            </ul>
                        </div>
                    </div> --}}
                    <!--end card-->
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0"><i class="ri-map-pin-line align-middle me-1 text-muted"></i>
                                Địa chỉ nhận hàng</h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled vstack gap-2 fs-13 mb-0">
                                <li class="fw-medium fs-14">Họ Tên : {{ $data_order->ad_name ?? $data_order->name }}</li>
                                <li>Số điện thoại : {{ $data_order->ad_phone ?? $data_order->phone }}</li>
                                <li>Địa chỉ : {{ $data_order->ad_address ?? $data_order->address }}</li>
                                {{-- <li>California - 24567</li> --}}
                                {{-- <li>United States</li> --}}
                            </ul>
                        </div>
                    </div>
                    <!--end card-->

                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0"><i
                                    class="ri-secure-payment-line align-bottom me-1 text-muted"></i> Payment Details</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-2">
                                <div class="flex-shrink-0">
                                    <p class="text-muted mb-0">Transactions:</p>
                                </div>
                                <div class="flex-grow-1 ms-2">
                                    <h6 class="mb-0">#VLZ124561278124</h6>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <div class="flex-shrink-0">
                                    <p class="text-muted mb-0">Payment Method:</p>
                                </div>
                                <div class="flex-grow-1 ms-2">
                                    <h6 class="mb-0">Debit Card</h6>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <div class="flex-shrink-0">
                                    <p class="text-muted mb-0">Card Holder Name:</p>
                                </div>
                                <div class="flex-grow-1 ms-2">
                                    <h6 class="mb-0">Joseph Parker</h6>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <div class="flex-shrink-0">
                                    <p class="text-muted mb-0">Card Number:</p>
                                </div>
                                <div class="flex-grow-1 ms-2">
                                    <h6 class="mb-0">xxxx xxxx xxxx 2456</h6>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <p class="text-muted mb-0">Total Amount:</p>
                                </div>
                                <div class="flex-grow-1 ms-2">
                                    <h6 class="mb-0">$415.96</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end card-->
                </div>
                <!--end col-->
            </div>
            <!--end row-->

        </div><!-- container-fluid -->
    </div><!-- End Page-content -->
@endsection
@section('js-content')
@endsection
