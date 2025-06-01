@extends('layouts.layout')

@section('content')
<!-- start section -->
<section class="top-space-margin half-section bg-gradient-very-light-gray">
    <div class="container">
        <div class="row align-items-center justify-content-center"
            data-anime='{ "el": "childs", "translateY": [-15, 0], "opacity": [0,1], "duration": 300, "delay": 0, "staggervalue": 200, "easing": "easeOutQuad" }'>
            <div class="col-12 col-xl-8 col-lg-10 text-center position-relative page-title-extra-large">
            </div>
            <div class="col-12 breadcrumb breadcrumb-style-01 d-flex justify-content-center">
                <ul>
                    <li><a href="/">Trang chủ</a></li>
                    <li>Xác minh email</li>
                </ul>
            </div>
        </div>
    </div>
</section>
<!-- end section -->

<!-- start section -->
<section class="pt-0">
    <div class="container">
        <div class="row g-0 justify-content-center">
            <div class="col-lg-6 col-md-10 p-6 box-shadow-extra-large border-radius-6px"
                data-anime='{ "translateY": [0, 0], "opacity": [0,1], "duration": 600, "delay":150, "staggervalue": 150, "easing": "easeOutQuad" }'>

                <h2 class="fs-26 xs-fs-24 alt-font fw-600 text-dark-gray mb-20px">Xác minh địa chỉ email</h2>

                @if (session('resent'))
                    <div class="alert alert-success" role="alert">
                        Liên kết xác minh mới đã được gửi đến email của bạn.
                    </div>
                @endif

                <p>Trước khi tiếp tục, vui lòng kiểm tra email để xác minh tài khoản.</p>
                <p>Nếu bạn không nhận được email, bạn có thể yêu cầu gửi lại:</p>

                <form class="mt-3" method="POST" action="{{ route('verification.resend') }}">
                    @csrf
                    <button type="submit" class="btn btn-dark-gray btn-medium btn-round-edge">Gửi lại email xác minh</button>
                </form>
            </div>
        </div>
    </div>
</section>
<!-- end section -->
@endsection
