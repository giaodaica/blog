<nav class="navbar navbar-expand-lg header-light bg-white disable-fixed">
    <div class="container-fluid">

        <div class="col-auto col-xxl-3 col-lg-2 menu-logo">
            <button class="navbar-toggler float-end" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-label="Toggle navigation" aria-expanded="false">
                <span class="navbar-toggler-line"></span>
                <span class="navbar-toggler-line"></span>
                <span class="navbar-toggler-line"></span>
                <span class="navbar-toggler-line"></span>
            </button>

            <a class="navbar-brand" href="{{ route('home') }}">
                <img src="{{ asset('assets/images/logooutfitly.png') }}"
                    data-at2x="{{ asset('assets/images/logooutfitly.png') }}" alt="" class="default-logo">
                <img src="{{ asset('assets/images/logooutfitly.png') }}"
                    data-at2x="{{ asset('assets/images/logooutfitly.png') }}" alt="" class="alt-logo">
                <img src="{{ asset('assets/images/logooutfitly.png') }}"
                    data-at2x="{{ asset('assets/images/logooutfitly.png') }}" alt="" class="mobile-logo">
            </a>
        </div>
        <div class="col-auto col-xxl-6 col-lg-8 menu-order">
            <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
                <ul class="navbar-nav alt-font navbar-left justify-content-end">
                    <li class="nav-item">
                        <a href="{{ route('home') }}" class="nav-link no-wrap">Trang chủ</a>
                    </li>
                    <li class="nav-item dropdown submenu">
                        <a href="{{ route('home.shop') }}" class="nav-link no-wrap">Cửa Hàng</a>
                        <i class="fa-solid fa-angle-down dropdown-toggle" id="navbarDropdownMenuLink1" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false"></i>
                        <div class="dropdown-menu submenu-content" aria-labelledby="navbarDropdownMenuLink1">
                            <div class="d-lg-flex mega-menu m-auto flex-column">
                                <div
                                    class="row row-cols-1 row-cols-lg-5 row-cols-md-3 row-cols-sm-3 mb-50px md-mb-25px xs-mb-15px">
                                    <div class="col">
                                        <ul>
                                            <li class="sub-title">Đàn ông</li>
                                            <li><a href="#">Quần jeans</a></li>
                                            <li><a href="#">Quần dài</a></li>
                                            <li><a href="#">Đồ bơi</a></li>
                                            <li><a href="#">Áo sơ mi thường ngày</a></li>
                                            <li><a href="#">Áo khoác chống mưa</a></li>
                                            <li><a href="#">Đồ mặc nhà</a></li>
                                        </ul>
                                    </div>
                                    <div class="col">
                                        <ul>
                                            <li class="sub-title">Phụ nữ</li>
                                            <li><a href="#">Khăn dupatta</a></li>
                                            <li><a href="#">Quần legging</a></li>
                                            <li><a href="#">Trang phục truyền thống</a></li>
                                            <li><a href="#">Áo kurta & bộ đồ</a></li>
                                            <li><a href="#">Trang phục phương Tây</a></li>
                                            <li><a href="#">Vải may váy</a></li>
                                        </ul>
                                    </div>
                                    <div class="col">
                                        <ul>
                                            <li class="sub-title">Trẻ em</li>
                                            <li><a href="#">Váy</a></li>
                                            <li><a href="#">Bộ jumpsuit</a></li>
                                            <li><a href="#">Quần thể thao</a></li>
                                            <li><a href="#">Trang phục truyền thống</a></li>
                                            <li><a href="#">Gói giá trị</a></li>
                                            <li><a href="#">Đồ mặc nhà</a></li>
                                        </ul>
                                    </div>
                                    <div class="col">
                                        <ul>
                                            <li class="sub-title">Phân loại</li>
                                            <li><a href="#">Áo</a></li>
                                            <li><a href="#">Váy</a></li>
                                            <li><a href="#">Quần short</a></li>
                                            <li><a href="#">Đồ bơi</a></li>
                                            <li><a href="#">Quần jeans</a></li>
                                            <li><a href="#">Áo khoác</a></li>
                                        </ul>
                                    </div>
                                    <div class="col">
                                        <ul>
                                            <li class="sub-title">Phụ kiện</li>
                                            <li><a href="#">Giày</a></li>
                                            <li><a href="#">Khăn quàng</a></li>
                                            <li><a href="#">Đồng hồ</a></li>
                                            <li><a href="#">Vòng tay</a></li>
                                            <li><a href="#">Ba lô</a></li>
                                            <li><a href="#">Kính râm</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="row row-cols-1 row-cols-sm-2">
                                    <div class="col">
                                        <form action="{{ url('accept_voucher/' . $vouchers[1]->id) }}" method="post">
                                            @csrf
                                            <button style="border:none; background:none; padding:0;">
                                                <img src="{{ asset($vouchers[1]->image ?? 'assets/images/shop/demo-fashion-store-menu-banner-01.jpg') }}"
                                                    alt="">
                                            </button>
                                        </form>
                                    </div>
                                    <div class="col">
                                        <form action="{{ url('accept_voucher/' . $vouchers[2]->id) }}" method="post">
                                            @csrf
                                            <button style="border:none; background:none; padding:0;">
                                                <img src="{{ asset($vouchers[2]->image ?? 'assets/images/shop/demo-fashion-store-menu-banner-01.jpg') }}"
                                                    alt="">
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a href="demo-fashion-store-contact.html" class="nav-link">Liên Hệ</a>
                    </li>
                </ul>

            </div>
            {{-- search --}}
            <div class="header-search-icon">
                <input type="text" name="search" id="search" class="rounded-pill px-3 py-2"
                    placeholder="Tìm kiếm..." autocomplete="off">
                <i class="fa fa-search ms-2"></i>
                <span id="clearInput"
                    style="position: absolute; right: 40px; top: 50%; transform: translateY(-50%); cursor: pointer; display: none;">
                    <i class="fa fa-times text-muted"></i>
                </span>
                <div class="search-suggestions" style="display: none;">
                    <div class="search-history mb-3">
                        <ul class="history-list list-unstyled mb-2">
                            <!-- Lịch sử tìm kiếm sẽ được thêm vào đây -->
                        </ul>
                        <button class="btn-clear-history w-100 text-center"
                            style="background: none; border: none; color: #007bff; font-size: 14px; cursor: pointer; display: non; te;">Xóa
                            tất cả</button>
                    </div>
                    <div class="autocomplete-results bg-white border rounded shadow mt-2 position-absolute w-100"
                        id="autocomplete-results" style="z-index: 999; display: none;">
                        <!-- Sản phẩm gợi ý sẽ được thêm bằng JS -->
                    </div>

                    <div class="trending-searches mb-3">
                        <h6 class="mb-2 fw-bold text-dark" style="font-size: 16px;">Xu hướng tìm kiếm</h6>
                        <div class="d-flex flex-wrap gap-2 trending-list">
                            <!-- Xu hướng tìm kiếm sẽ được thêm vào đây -->
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- Cart --}}
        <div class="col-auto col-xxl-3 col-lg-2 text-end">
            <div class="header-icon">

                <div class="widget-text icon alt-font">
                    @if (Auth::check())
                        <a href="{{ Route('home.info') }}"><i
                                class="feather icon-feather-user d-inline-block me-5px"></i><span
                                class="d-none d-xxl-inline-block">{{ Auth::user()->name }}</span></a>
                    @else
                        <a href="{{ route('login') }}"><i
                                class="feather icon-feather-user d-inline-block me-5px"></i><span
                                class="d-none d-xxl-inline-block">Đăng nhập</span></a>
                    @endif
                </div>
                <div class="header-cart-icon icon">
                    <div class="header-cart dropdown">
                        <a href="javascript:void(0);"><i class="feather icon-feather-shopping-bag"></i><span
                                class="cart-count alt-font text-white bg-dark-gray">2</span></a>
                        <ul class="cart-item-list">
                            <li class="cart-item align-items-center">
                                <a href="javascript:void(0);" class="alt-font close">×</a>
                                <div class="product-image">
                                    <a href="demo-fashion-store-single-product.html"><img
                                            src="{{ asset('assets/images/shop/demo-fashion-store-product-01.jpg') }}"
                                            class="cart-thumb" alt=""></a>
                                </div>
                                <div class="product-detail fw-600">
                                    <a href="demo-fashion-store-single-product.html">Ribbed tank</a>
                                    <span class="item-ammount fw-400">1 x $23.00</span>
                                </div>
                            </li>
                            <li class="cart-item align-items-center">
                                <a href="javascript:void(0);" class="alt-font close">×</a>
                                <div class="product-image">
                                    <a href="demo-fashion-store-single-product.html"><img
                                            src="{{ asset('assets/images/shop/demo-fashion-store-product-01.jpg') }}"
                                            class="cart-thumb" alt=""></a>
                                </div>
                                <div class="product-detail fw-600">
                                    <a href="demo-fashion-store-single-product.html">Pleated dress</a>
                                    <span class="item-ammount fw-400">2 x $15.00</span>
                                </div>
                            </li>
                            <li class="cart-total">
                                <div class="fs-18 alt-font mb-15px"><span
                                        class="w-50 fw-500 text-start">Subtotal:</span><span
                                        class="w-50 text-end fw-700">$199.99</span></div>
                                <a href="{{ url('cart') }}"
                                    class="btn btn-large btn-transparent-light-gray border-color-extra-medium-gray">View
                                    cart</a>
                                <a href="demo-fashion-store-checkout.html"
                                    class="btn btn-large btn-dark-gray btn-box-shadow">Checkout</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-auto col-xxl-3 col-lg-2 d-flex align-items-center">

            </div>
        </div>

    </div>
</nav>
