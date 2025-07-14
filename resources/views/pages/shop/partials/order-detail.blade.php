@extends('layouts.layout')


@section('content')
    <section class="page-title-center-alignment cover-background top-space-padding">
        <div class="container">
            <div class="row">

                <div class="col-12 breadcrumb breadcrumb-style-01 d-flex justify-content-center">
                    <ul>
                        <li><a href="{{ route('home') }}">Trang chủ</a></li>
                        <li>Chi tiết đơn hàng</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section class="py-4">
        <div class="container">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <div class="card mb-4">

                <div class="card-body">
                    <div class="col-lg-12">
                        <div class="card-body p-4">
                            <div class="row g-3">
                                <div class="col-lg-3 col-6">
                                    <p class="text-muted mb-2 text-uppercase fw-semibold fs-14">Mã hóa đơn</p>
                                    <strong>{{ $order->code_order }}</strong>
                                </div>
                                <div class="col-lg-3 col-6">
                                    <p class="text-muted mb-2 text-uppercase fw-semibold fs-14">Ngày đặt</p>
                                    <h5 class="fs-15 mb-0">
                                        <strong>{{ $order->created_at->format('d/m/Y') }}</strong>
                                        <small class="text-muted"
                                            id="invoice-time">{{ $order->created_at->format('H:i:s') }}</small>
                                    </h5>
                                </div>
                                <div class="col-lg-3 col-6">
                                    <p class="text-muted mb-2 text-uppercase fw-semibold fs-14">Trạng thái đơn hàng</p>
                                    @php
                                        $statusMap = [
                                            'pending' => ['color' => 'warning', 'label' => 'Chờ xác nhận'],
                                            'confirmed' => ['color' => 'info', 'label' => 'Đã xác nhận'],
                                            'shipping' => ['color' => 'primary', 'label' => 'Đang giao'],
                                            'success' => ['color' => 'success', 'label' => 'Thành công'],
                                            'failed' => ['color' => 'danger', 'label' => 'Thất bại'],
                                            'cancelled' => ['color' => 'secondary', 'label' => 'Đã hủy'],
                                        ];
                                        $status = $order->status;
                                        $statusColor = $statusMap[$status]['color'] ?? 'secondary';
                                        $statusLabel = $statusMap[$status]['label'] ?? ucfirst($status);
                                    @endphp
                                    <span class="badge bg-{{ $statusColor }}-subtle text-{{ $statusColor }}">
                                        {{ $statusLabel }}
                                    </span>
                                </div>
                                <div class="col-lg-3 col-6">
                                    <p class="text-muted mb-2 text-uppercase fw-semibold fs-14">Tổng tiền</p>
                                    <strong>{{ number_format($order->total_amount) }}đ</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        @if (isset($shippingAddress))
                            <div>
                                <strong>{{ $shippingAddress->is_default ? 'Địa chỉ mặc định' : 'Địa chỉ giao hàng' }}</strong><br>
                                {{ $shippingAddress->name }}<br>
                                {{ $shippingAddress->address }}<br>
                                Điện thoại: {{ $shippingAddress->phone }}
                            </div>
                        @endif
                    </div>
                    <!-- Bảng cho màn hình lớn -->
                    <div class="table-responsive mb-3 d-none d-md-block">
                        <table class="table table-bordered text-center">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Chi tiết sản phẩm</th>
                                    <th>Giá</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->orderItems as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td class="d-flex align-items-center gap-2">
                                            <img src="{{ asset($item->productVariant->product->image_url) }}"
                                                alt="{{ $item->product_name }}" class="order-img"
                                                style="width: 60px; height: 60px;" />
                                            <div style="line-height:1.3;">
                                                <div class="product-name-truncate fw-bold">
                                                    {{ $item->product_name }}
                                                </div>
                                                <div style="font-size: 13px; color: #555;">
                                                    {{ $item->productVariant->color->color_name ?? '-' }},
                                                    {{ $item->productVariant->size->size_name ?? '-' }}
                                                    <br>
                                                    x{{ $item->quantity }}
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ number_format($item->sale_price) }}đ</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Layout cho mobile -->
                    <div class="d-block d-md-none">
                        @foreach ($order->orderItems as $index => $item)
                            <div class="border rounded p-2 mb-2">
                                <div class="d-flex align-items-center gap-2">
                                    <img src="{{ asset($item->productVariant->product->image_url) }}"
                                        alt="{{ $item->product_name }}" style="width: 60px; height: 60px;" />
                                    <div style="line-height: 1.3;">
                                        <div class="fw-bold">{{ $item->product_name }}</div>
                                        <div style="font-size: 13px; color: #555;">
                                            {{ $item->productVariant->color->color_name ?? '-' }},
                                            {{ $item->productVariant->size->size_name ?? '-' }}<br>
                                            x{{ $item->quantity }}
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-2 text-end fw-bold text-danger">
                                    {{ number_format($item->sale_price) }}đ
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mb-3">
                        <table class="table table-borderless w-auto ms-auto">
                            <tr>
                                <td>Tổng phụ</td>
                                <td class="text-end">{{ number_format($subtotal) }}đ</td>
                            </tr>
                            @if ($discount > 0)
                                <tr>
                                    <td>Giảm giá</td>
                                    <td class="text-end">- {{ number_format($discount) }}đ</td>
                                </tr>
                            @endif
                            <tr>
                                <td>Phí vận chuyển</td>
                                <td class="text-end">{{ number_format($shipping) }}đ</td>
                            </tr>
                            <tr>
                                <th>Tổng cộng</th>
                                <th class="text-end">{{ number_format($total) }}đ</th>
                            </tr>
                        </table>
                    </div>
                    <div class="mb-3">
                        <strong>Chi tiết thanh toán:</strong><br>
                        Phương thức thanh toán: <strong>{{ $order->pay_method }}</strong><br>
                        Thời gian thanh toán: <strong>{{ $order->created_at }}</strong>
                    </div>
                    <div class="d-flex justify-content-end gap-2">
                        @if ($order->status == 'pending')
                            <a href="javascript:void(0)" class="btn btn-danger no-hover" data-bs-toggle="modal"
                                data-bs-target="#cancelOrderModal">Hủy đơn hàng</a>
                        @endif
                        <a href="{{ route('home.info') }}" class="btn btn-warning no-hover">Quay lại</a>
                        @if ($refund)
                            @if ($refund->status == 'approved')
                                <span class="btn btn-success no-hover">Đã hoàn tiền</span>
                                @if (!empty($refund->QR_images))
                                    <a href="{{ asset($refund->QR_images) }}" target="_blank" class="btn btn-info no-hover">Xem bill</a>
                                @endif
                            @else
                                <a href="#" class="btn btn-primary no-hover" data-bs-toggle="modal" data-bs-target="#refundModal">Yêu cầu hoàn tiền</a>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal -->
    <div class="modal fade" id="cancelOrderModal" tabindex="-1" role="dialog" aria-labelledby="cancelOrderModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form method="POST" action="{{ route('order.cancel', $order->id) }}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="cancelOrderModalLabel">Chọn lý do hủy đơn hàng</h5>

                    </div>
                    <div class="modal-body">
                        <select name="cancel_reason" class="form-control" required>
                            <option value="">-- Chọn lý do --</option>
                            <option value="Đổi ý, không muốn mua nữa">Đổi ý, không muốn mua nữa</option>
                            <option value="Đặt nhầm sản phẩm">Đặt nhầm sản phẩm</option>
                            <option value="Tìm được giá tốt hơn">Tìm được giá tốt hơn</option>
                            <option value="Không liên lạc được với shop">Không liên lạc được với shop</option>
                            <option value="Thời gian giao hàng quá lâu">Thời gian giao hàng quá lâu</option>
                            <option value="Muốn thay đổi địa chỉ nhận hàng">Muốn thay đổi địa chỉ nhận hàng</option>
                            <option value="Sản phẩm không còn nhu cầu">Sản phẩm không còn nhu cầu</option>
                            <option value="Khác">Khác</option>
                        </select>
                        <textarea name="cancel_note" class="form-control mt-2" placeholder="Ghi chú thêm (nếu có)"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary no-hover" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-danger no-hover">Xác nhận hủy đơn</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Hoàn tiền -->
    <div class="modal fade" id="refundModal" tabindex="-1" role="dialog" aria-labelledby="refundModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="refundForm" method="POST" action="{{ route('order.refund', $order->id) }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="refundModalLabel">Yêu cầu hoàn tiền</h5>
                    </div>
                    <div class="modal-body">
                        <ul class="nav nav-tabs mb-3" id="refundTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="tab-stk" data-bs-toggle="tab" data-bs-target="#stk" type="button" role="tab">STK</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="tab-qr" data-bs-toggle="tab" data-bs-target="#qr" type="button" role="tab">QR</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="refundTabContent">
                            <div class="tab-pane fade show active" id="stk" role="tabpanel">
                                <div class="mb-2">
                                    <label>Ngân hàng</label>
                                    <select class="form-control" name="bank_code" id="bankSelect" required></select>
                                </div>
                                <div class="mb-2">
                                    <label>Số tài khoản</label>
                                    <input type="text" class="form-control" name="account_number" required />
                                </div>
                                <div class="mb-2">
                                    <label>Tên chủ thẻ</label>
                                    <input type="text" class="form-control" name="account_name" required />
                                </div>
                                <div class="mb-2">
                                    <label>Số tiền hoàn (VNĐ)</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" name="amount" id="refundAmountStk" value="{{ $total ?? ($order->total_amount ?? 0) }}" readonly required min="0">
                                        <button type="button" class="btn btn-outline-secondary btn-sm" id="editAmountStk">Sửa</button>
                                    </div>
                                    <small class="text-muted">Bạn có thể chỉnh sửa số tiền nếu không đúng với đơn hàng.</small>
                                </div>
                                <div class="mb-2">
                                    <label>Lý do hoàn tiền</label>
                                    <input type="text" class="form-control" name="reason" required />
                                </div>
                            </div>
                            <div class="tab-pane fade" id="qr" role="tabpanel">
                                <div class="mb-2">
                                    <label>Upload mã QR</label>
                                    <input type="file" class="form-control" name="qr_image" accept="image/*" />
                                </div>
                                <div class="mb-2">
                                    <label>Số tiền hoàn (VNĐ)</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" name="amount" id="refundAmountQr" value="{{ $total ?? ($order->total_amount ?? 0) }}" readonly required min="0">
                                        <button type="button" class="btn btn-outline-secondary btn-sm" id="editAmountQr">Sửa</button>
                                    </div>
                                    <small class="text-muted">Bạn có thể chỉnh sửa số tiền nếu không đúng với đơn hàng.</small>
                                </div>
                                @if (!empty($refund->QR_images))
                                    <div class="mb-2">
                                        <label>Mã QR đã upload:</label><br>
                                        <img src="{{ asset($refund->QR_images) }}" alt="QR Code" style="max-width: 200px;" />
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary no-hover" data-bs-dismiss="modal">Đóng</button>
                        @if ($refund->status == 'pending')
                            <button type="submit" class="btn btn-primary no-hover">Gửi yêu cầu</button>
                        @else
                            <button type="button" class="btn btn-primary no-hover" disabled>Không thể gửi yêu cầu</button>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
<style>
    .order-img {
        width: 60px;
        height: 60px;
        object-fit: cover;
    }

    .no-hover:hover,
    .no-hover:focus,
    .no-hover:active {
        background-color: #dc3545 !important;
        color: #fff !important;
        text-decoration: none !important;
        box-shadow: none !important;
        border-color: #dc3545 !important;
        outline: none !important;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Call API lấy danh sách ngân hàng khi mở modal
        var bankSelect = document.getElementById('bankSelect');
        if (bankSelect) {
            fetch('https://api.vietqr.io/v2/banks')
                .then(res => res.json())
                .then(data => {
                    if (data && data.data) {
                        data.data.forEach(function(bank) {
                            var option = document.createElement('option');
                            option.value = bank.code;
                            option.text = bank.shortName + ' - ' + bank.name;
                            bankSelect.appendChild(option);
                        });
                    }
                });
        }
        // Sửa số tiền ở tab STK
        document.getElementById('editAmountStk').addEventListener('click', function() {
            var input = document.getElementById('refundAmountStk');
            input.readOnly = !input.readOnly;
            if (!input.readOnly) input.focus();
        });
        // Sửa số tiền ở tab QR
        document.getElementById('editAmountQr').addEventListener('click', function() {
            var input = document.getElementById('refundAmountQr');
            input.readOnly = !input.readOnly;
            if (!input.readOnly) input.focus();
        });
    });
</script>
