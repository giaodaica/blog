<!doctype html>
<html class="no-js" lang="en">
@include('card.head')
    <body data-mobile-nav-style="classic">
        <!-- start header -->

        <!-- end header -->
        <!-- start section -->
        <section class="cover-background full-screen ipad-top-space-margin md-h-550px" style="background-image: url({{asset('assets/images/404-bg.jpg')}});">
            <div class="container h-100">
                <div class="row align-items-center justify-content-center h-100">
                    <div class="col-12 col-xl-6 col-lg-7 col-md-9 text-center" data-anime='{ "el": "childs", "translateY": [50, 0], "opacity": [0,1], "duration": 600, "delay": 0, "staggervalue": 300, "easing": "easeOutQuad" }'>
                        <h1 class="fs-170 sm-fs-150 text-dark-gray fw-700 ls-minus-6px">🎉</h1>
                        <h4 class="text-dark-gray fw-600 sm-fs-22 mb-10px ls-minus-1px">Đặt hàng thành công!</h4>
                        
                        @if(session('success'))
                            <div class="alert alert-success mb-30px">
                                <i class="fas fa-check-circle me-2"></i>
                                {{ session('success') }}
                            </div>
                        @endif

                        <div class="bg-white p-4 rounded shadow-sm mb-30px">
                            <h5 class="text-dark-gray fw-600 mb-3">Thông tin đơn hàng</h5>
                            <div class="text-start">
                                <p class="mb-2"><strong>Mã đơn hàng:</strong> 
                                    @if(session('success'))
                                        @php
                                            $message = session('success');
                                            if(preg_match('/Mã đơn hàng: (ORD\d+)/', $message, $matches)) {
                                                echo '<span class="badge bg-primary fs-14">' . $matches[1] . '</span>';
                                            }
                                        @endphp
                                    @endif
                                </p>
                                <p class="mb-2"><strong>Trạng thái:</strong> <span class="badge bg-warning">Chờ xác nhận</span></p>
                                <p class="mb-2"><strong>Phương thức thanh toán:</strong> 
                                    @if(session('payment_method') == 'COD')
                                        <span class="badge bg-info">Thanh toán khi nhận hàng</span>
                                    @else
                                        <span class="badge bg-success">Thanh toán qua QR</span>
                                    @endif
                                </p>
                            </div>
                        </div>

                        <p class="mb-30px lh-28 sm-mb-30px">
                            Chúng tôi sẽ gửi email xác nhận đơn hàng đến địa chỉ email của bạn. 
                            Bạn có thể theo dõi trạng thái đơn hàng trong tài khoản cá nhân.
                        </p>
                        
                        <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center">
                            <a href="{{route('home')}}" class="btn btn-large left-icon btn-rounded btn-dark-gray btn-box-shadow text-transform-none">
                                <i class="fa-solid fa-arrow-left"></i>Trở về trang chủ
                            </a>
                            <a href="{{route('home.info')}}" class="btn btn-large left-icon btn-rounded btn-outline-dark-gray text-transform-none">
                                <i class="fa-solid fa-user"></i>Xem đơn hàng
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- end section -->
        <!-- start footer -->

        <!-- end footer -->
        <!-- javascript libraries -->
       @include('card.js')
    </body>
</html>
