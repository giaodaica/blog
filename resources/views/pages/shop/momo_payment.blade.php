@extends('layouts.layout')
@section('content')
    <!-- start section -->
    <section class="top-space-margin half-section bg-gradient-very-light-gray">
        <div class="container">
            <div class="row align-items-center justify-content-center" data-anime='{ "el": "childs", "translateY": [-15, 0], "opacity": [0,1], "duration": 300, "delay": 0, "staggervalue": 200, "easing": "easeOutQuad" }'>
                <div class="col-12 col-xl-8 col-lg-10 text-center position-relative page-title-extra-large">
                    <h1 class="alt-font fw-600 text-dark-gray mb-10px">Thanh toán qua MOMO</h1>
                </div>
                <div class="col-12 breadcrumb breadcrumb-style-01 d-flex justify-content-center">
                    <ul>
                        <li><a href="{{ route('home') }}">Trang chủ</a></li>
                        <li>Thanh toán MOMO</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!-- end section -->

    <!-- start section -->
    <section class="pt-0">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="card border shadow-sm">
                        <div class="card-header bg-primary text-white text-center">
                            <h4 class="mb-0">
                                <i class="fas fa-wallet me-2"></i>
                                Thanh toán qua MOMO
                            </h4>
                        </div>
                        <div class="card-body p-4">
                            <div class="text-center mb-4">
                                <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                                    <i class="fas fa-mobile-alt fa-2x text-primary"></i>
                                </div>
                                <h5 class="fw-600">Thông tin đơn hàng</h5>
                            </div>

                            <div class="row mb-3">
                                <div class="col-6">
                                    <strong>Mã đơn hàng:</strong>
                                </div>
                                <div class="col-6 text-end">
                                    <span class="badge bg-primary">{{ $order->code_order }}</span>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-6">
                                    <strong>Số tiền:</strong>
                                </div>
                                <div class="col-6 text-end">
                                    <span class="fw-600 text-primary fs-5">{{ number_format($order->final_amount, 0, ',', '.') }} đ</span>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-6">
                                    <strong>Người nhận:</strong>
                                </div>
                                <div class="col-6 text-end">
                                    {{ $order->name }}
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-6">
                                    <strong>Địa chỉ:</strong>
                                </div>
                                <div class="col-6 text-end">
                                    {{ $order->address }}
                                </div>
                            </div>

                            <hr>

                            <div class="text-center mb-4">
                                <h6 class="fw-600 mb-3">Hướng dẫn thanh toán</h6>
                                <div class="bg-light p-3 rounded">
                                    <ol class="text-start mb-0">
                                        <li>Mở ứng dụng MOMO trên điện thoại</li>
                                        <li>Chọn "Quét mã" hoặc "Thanh toán"</li>
                                        <li>Quét mã QR bên dưới hoặc nhập thông tin</li>
                                        <li>Xác nhận thanh toán</li>
                                        <li>Chờ thông báo xác nhận</li>
                                    </ol>
                                </div>
                            </div>

                            <!-- Demo QR Code -->
                            <div class="text-center mb-4">
                                <div class="bg-white border rounded p-3 d-inline-block">
                                    <div class="bg-light rounded p-3 mb-2" style="width: 200px; height: 200px; display: flex; align-items: center; justify-content: center;">
                                        <div class="text-center">
                                            <i class="fas fa-qrcode fa-4x text-muted mb-2"></i>
                                            <div class="small text-muted">Demo QR Code</div>
                                        </div>
                                    </div>
                                    <div class="small text-muted">Quét mã QR để thanh toán</div>
                                </div>
                            </div>

                            <!-- Demo Payment Form -->
                            <div class="bg-light p-3 rounded mb-4">
                                <h6 class="fw-600 mb-3">Thông tin thanh toán (Demo)</h6>
                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <strong>Partner Code:</strong> {{ $paymentData['partnerCode'] }}
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <strong>Order ID:</strong> {{ $paymentData['orderId'] }}
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <strong>Amount:</strong> {{ number_format($paymentData['amount'], 0, ',', '.') }} đ
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <strong>Request Type:</strong> {{ $paymentData['requestType'] }}
                                    </div>
                                </div>
                            </div>

                            <!-- Demo Buttons -->
                            <div class="d-grid gap-2">
                                <button type="button" class="btn btn-success btn-lg" onclick="simulatePayment('success')">
                                    <i class="fas fa-check me-2"></i>
                                    Thanh toán thành công (Demo)
                                </button>
                                <button type="button" class="btn btn-danger btn-lg" onclick="simulatePayment('failed')">
                                    <i class="fas fa-times me-2"></i>
                                    Thanh toán thất bại (Demo)
                                </button>
                                <a href="{{ route('home.cart') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>
                                    Quay lại giỏ hàng
                                </a>
                            </div>

                            <div class="text-center mt-3">
                                <small class="text-muted">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Đây là trang demo thanh toán MOMO. Trong thực tế, bạn sẽ được chuyển đến trang thanh toán của MOMO.
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end section -->

    <script>
        function simulatePayment(result) {
            const orderId = '{{ $order->code_order }}';
            const amount = {{ $order->final_amount }};
            
            // Hiển thị loading
            const btn = event.target;
            const originalText = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Đang xử lý...';
            btn.disabled = true;

            // Giả lập API call
            setTimeout(() => {
                if (result === 'success') {
                    // Giả lập thanh toán thành công
                    fetch("{{ route('momo.ipn') }}", {
                        method: "POST",
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            orderId: orderId,
                            resultCode: 0,
                            amount: amount
                        })
                    }).then(() => {
                        window.location.href = "{{ route('home.done') }}";
                    });
                } else {
                    // Giả lập thanh toán thất bại
                    fetch("{{ route('momo.ipn') }}", {
                        method: "POST",
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            orderId: orderId,
                            resultCode: 1006,
                            amount: amount
                        })
                    }).then(() => {
                        alert('Thanh toán thất bại! Vui lòng thử lại.');
                        btn.innerHTML = originalText;
                        btn.disabled = false;
                    });
                }
            }, 2000);
        }
    </script>
@endsection 