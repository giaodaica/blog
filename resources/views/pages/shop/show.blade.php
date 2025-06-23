@php
    $totalReviews = $reviews->count();
    $averageRating = $totalReviews > 0 ? $reviews->avg('rating') : 0;
    $ratingCounts = $reviews->groupBy('rating')->map->count();

    $ratingPercentages = [];
    for ($i = 5; $i >= 1; $i--) {
        $count = $ratingCounts->get($i, 0);
        $ratingPercentages[$i] = $totalReviews > 0 ? ($count / $totalReviews) * 100 : 0;
    }
@endphp
@extends('layouts.layout')
@section('content')
        <!-- start section -->
        <section class="top-space-margin bg-gradient-very-light-gray pt-20px pb-20px ps-45px pe-45px sm-ps-15px sm-pe-15px">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-12 breadcrumb breadcrumb-style-01 fs-14">
                        <ul>
                            <li><a href="{{route('home')}}">Trang chủ</a></li>
                            <li><a href="{{route('home.shop')}}">Cửa Hàng</a></li>
                            <li>{{ $product->name }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        <!-- end section -->
        <!-- start section -->
        <section class="pt-60px pb-0 md-pt-30px">
            <div class="container">
                <div class="row">
                    <div class="col-lg-7 pe-50px md-pe-15px md-mb-40px">
                        <div class="row overflow-hidden position-relative">
                            <div class="col-12 col-lg-10 position-relative order-lg-2 product-image ps-30px md-ps-15px">
                                <div class="swiper product-image-slider" data-slider-options='{ "spaceBetween": 10, "loop": true, "autoplay": { "delay": 2000, "disableOnInteraction": false }, "watchOverflow": true, "navigation": { "nextEl": ".slider-product-next", "prevEl": ".slider-product-prev" }, "thumbs": { "swiper": { "el": ".product-image-thumb", "slidesPerView": "auto", "spaceBetween": 15, "direction": "vertical", "navigation": { "nextEl": ".swiper-thumb-next", "prevEl": ".swiper-thumb-prev" } } } }' data-thumb-slider-md-direction="horizontal">
                                    <div class="swiper-wrapper">
                                        <!-- start slider item -->
                                        @foreach ($variants as $item)

                                        <div class="swiper-slide gallery-box">
                                            <a href="{{asset( $item->variant_image_url) }}" data-group="lightbox-gallery" title="Relaxed corduroy shirt">
                                                <img class="w-100" src="{{asset( $item->variant_image_url) }}" alt="">
                                            </a>
                                        </div>
                                        @endforeach
                                        <!-- end slider item -->

                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-2 order-lg-1 position-relative single-product-thumb">
                                <div class="swiper-container product-image-thumb slider-vertical">
                                    <div class="swiper-wrapper">
                                        @foreach ($images as $item)
                                        <div class="swiper-slide"><img class="w-100" src="{{asset( $item) }}" alt=""></div>

                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-5 product-info">

                        <h5 class="alt-font text-dark-gray fw-500 mb-5px product-name-truncate">{{ $product->name }}</h5>
                            <div class="d-block d-sm-flex align-items-center mb-15px">
                                <div class="me-10px xs-me-0">
                                    <a href="#tab" class="section-link ls-minus-1px icon-small">
                                        <i class="bi bi-star-fill text-golden-yellow"></i>
                                        <i class="bi bi-star-fill text-golden-yellow"></i>
                                        <i class="bi bi-star-fill text-golden-yellow"></i>
                                        <i class="bi bi-star-fill text-golden-yellow"></i>
                                        <i class="bi bi-star-fill text-golden-yellow"></i>
                                    </a>
                                </div>
                                <a href="#tab" class="me-25px text-dark-gray fw-500 section-link xs-me-0">165 Reviews</a>

                            </div>
                            <div class="product-price mb-10px">
                                <span class="text-red fs-28 xs-fs-24 fw-700 ls-minus-1px">
                                    @if($variants->first())
                                    {{ number_format($variants->first()->sale_price) }}đ
                                        <del class="text-medium-gray me-10px fw-400">{{ number_format($variants->first()->listed_price) }}đ</del>
                                    @endif
                                </span>
                            </div>

                            <div class="d-flex align-items-center mb-20px">
                                <label class="text-dark-gray alt-font me-15px fw-500">Color</label>
                                <ul class="shop-color mb-0">
                                    @foreach($colors as $color)
                                            <li>
                                                <input class="d-none" type="radio" id="color-{{ $color->id }}" name="color">
                                                <label class="" for="color-{{ $color->id }}"><span style="background-color: {{ $color->color_code ?? '#000' }}" ></span></label>
                                            </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="d-flex align-items-center mb-35px">
                                <label class="text-dark-gray me-15px fw-500">Size</label>
                                <ul class="shop-size mb-0">
                                    @foreach($sizes as $size)
                                            <li>
                                                <input class="d-none" type="radio" id="size-{{ $size->id }}" name="size">
                                                <label for="size-{{ $size->id }}"><span>{{ $size->size_name }}</span></label>
                                            </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="d-flex align-items-center flex-column flex-sm-row mb-20px position-relative">
                                <div class="quantity me-15px xs-mb-15px order-1">
                                    <button type="button" class="qty-minus">-</button>
                                    <input class="qty-text" type="text" id="1" value="1" aria-label="submit" />
                                    <button type="button" class="qty-plus">+</button>
                                </div>
                                <a href="{{route('home.cart')}}" class="btn btn-cart btn-extra-large btn-switch-text btn-box-shadow btn-none-transform btn-dark-gray left-icon btn-round-edge border-0 me-15px xs-me-0 order-3 order-sm-2">
                                    <span>
                                        <span><i class="feather icon-feather-shopping-bag"></i></span>
                                        <span class="btn-double-text ls-0px" data-text="Thêm vào giỏ">Thêm vào giỏ</span>
                                    </span>
                                </a>

                            </div>
                            <div class="row mb-20px">
                                <div class="col-auto icon-with-text-style-08">
                                    <div class="feature-box feature-box-left-icon-middle d-inline-flex align-middle">
                                        <div class="feature-box-icon me-10px">
                                            <i class="feather icon-feather-repeat align-middle text-dark-gray"></i>
                                        </div>
                                        <div class="feature-box-content">
                                            <a href="#" class="alt-font fw-500 text-dark-gray d-block">Compare</a>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="mb-20px h-1px w-100 bg-extra-medium-gray d-block"></div>
                            <div class="row mb-15px">
                                <div class="col-12 icon-with-text-style-08">
                                    <div class="feature-box feature-box-left-icon d-inline-flex align-middle">
                                        <div class="feature-box-icon me-10px">
                                            <i class="feather icon-feather-truck top-8px position-relative align-middle text-dark-gray"></i>
                                        </div>
                                        <div class="feature-box-content">
                                            <span><span class="alt-font text-dark-gray fw-500">Estimated delivery:</span> March 03 - March 07</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 icon-with-text-style-08 mb-10px">
                                    <div class="feature-box feature-box-left-icon d-inline-flex align-middle">
                                        <div class="feature-box-icon me-10px">
                                            <i class="feather icon-feather-archive top-8px position-relative align-middle text-dark-gray"></i>
                                        </div>
                                        <div class="feature-box-content">
                                            <span><span class="alt-font text-dark-gray fw-500">Free shipping & returns:</span> On all orders over $50</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <div class="w-100 d-block"><span class="text-dark-gray alt-font fw-500">Danh mục:</span> <a href="{{ route('home.shop', ['categories[]' => $product->category->id]) }}">{{ $product->category->name }}</a></div>

                            </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- end section -->
        <!-- start section -->
        <section id="tab" class="pt-4 sm-pt-40px">
            <div class="container">
                <div class="row">
                    <div class="col-12 tab-style-04">
                        <ul class="nav nav-tabs border-0 justify-content-center alt-font fs-19">
                            <li class="nav-item"><a data-bs-toggle="tab" href="#tab_five1" class="nav-link active">Mô tả<span class="tab-border bg-dark-gray"></span></a></li>

                            <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#tab_five3">Vận chuyển và trả lại<span class="tab-border bg-dark-gray"></span></a></li>
                            <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#tab_five4" data-tab="review-tab">Đánh giá ({{ $totalReviews }})<span class="tab-border bg-dark-gray"></span></a></li>
                        </ul>
                        <div class="mb-5 h-1px w-100 bg-extra-medium-gray sm-mt-10px xs-mb-8"></div>
                        <div class="tab-content">
                            <!-- start tab content -->
                            <div class="tab-pane fade in active show" id="tab_five1">
                                <div class="row align-items-center justify-content-center">
                                        <p class="w-90">{!! $product->description !!}</p>
                                </div>
                            </div>
                            <!-- end tab content -->
                            <!-- start tab content -->
                            <div class="tab-pane fade in" id="tab_five3">
                                <div class="row">
                                    <div class="col-12 col-md-6 last-paragraph-no-margin sm-mb-30px">
                                        <div class="alt-font fs-22 text-dark-gray mb-15px fw-500">Shipping information</div>
                                        <p class="mb-0"><span class="fw-500 text-dark-gray">Standard:</span> Arrives in 5-8 business days</p>
                                        <p><span class="fw-500 text-dark-gray">Express:</span> Arrives in 2-3 business days</p>
                                        <p class="w-80 md-w-100">These shipping rates are not applicable for orders shipped outside of the US. Some oversized items may require an additional shipping charge. Free Shipping applies only to merchandise taxes and gift cards do not count toward the free shipping total.</p>
                                    </div>
                                    <div class="col-12 col-md-6 last-paragraph-no-margin">
                                        <div class="alt-font fs-22 text-dark-gray mb-15px fw-500">Return information</div>
                                        <p class="w-80 md-w-100">Orders placed between 10/1/2023 and 12/23/2023 can be returned by 2/27/2023.</p>
                                        <p class="w-80 md-w-100">Return or exchange any unused or defective merchandise by mail or at one of our US or Canada store locations. Returns made within 30 days of the order delivery date will be issued a full refund to the original form of payment.</p>
                                    </div>
                                </div>
                            </div>
                            <!-- end tab content -->
                            <!-- start tab review -->
                            <div class="tab-pane fade in" id="tab_five4">
                                <div class="row align-items-center mb-6 sm-mb-10">
                                    <div class="col-lg-4 col-md-12 col-sm-7 md-mb-30px text-center text-lg-start">
                                        <h5 class="alt-font text-dark-gray fw-500 mb-0 w-85 lg-w-100">Chúng tôi luôn nỗ lực để mang đến trải nghiệm tốt nhất cho khách hàng.</h5>
                                    </div>
                                    <div class="col-lg-2 col-md-4 col-sm-5 text-center sm-mb-20px p-0 md-ps-15px md-pe-15px">
                                        <div class="border-radius-4px bg-very-light-gray p-30px xl-p-20px">
                                            <h2 class="mb-5px alt-font text-dark-gray fw-600">{{ number_format($averageRating, 1) }}</h2>
                                            <span class="text-golden-yellow icon-small d-block ls-minus-1px mb-5px">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <i class="bi {{ $i <= $averageRating ? 'bi-star-fill' : 'bi-star' }}"></i>
                                                @endfor
                                            </span>
                                            <span class="ps-15px pe-15px pt-10px pb-10px lh-normal bg-dark-gray text-white fs-12 fw-600 text-uppercase border-radius-4px d-inline-block text-center">{{ $totalReviews }} Reviews</span>
                                        </div>
                                    </div>
                                    <div class="col-9 col-lg-4 col-md-5 col-sm-8 progress-bar-style-02">
                                        <div class="ps-20px md-ps-0">
                                            <div class="text-dark-gray mb-15px fw-600">Đánh giá trung bình của khách hàng</div>
                                            <!-- start progress bar item -->
                                            @for ($i = 5; $i >= 1; $i--)
                                            <div class="progress mb-20px border-radius-6px">
                                                <div class="progress-bar bg-green m-0" role="progressbar" aria-valuenow="{{ $ratingPercentages[$i] }}" aria-valuemin="0" aria-valuemax="100" aria-label="rating"></div>
                                            </div>
                                            @endfor
                                            <!-- end progress bar item -->
                                        </div>
                                    </div>
                                    <div class="col-3 col-lg-2 col-md-3 col-sm-4 mt-45px">
                                        @for ($i = 5; $i >= 1; $i--)
                                        <div class="mb-15px lh-0 xs-lh-normal xs-mb-10px">
                                            <span class="text-golden-yellow fs-15 ls-minus-1px d-none d-sm-inline-block">
                                                @for ($j = 1; $j <= 5; $j++)
                                                    <i class="bi {{ $j <= $i ? 'bi-star-fill' : 'bi-star' }}"></i>
                                                @endfor
                                            </span>
                                            <span class="fs-13 text-dark-gray fw-600 ms-10px xs-ms-0">{{ round($ratingPercentages[$i]) }}%</span>
                                        </div>
                                        @endfor
                                    </div>
                                </div>
                                <div class="row g-0 mb-4 md-mb-35px" id="review-list-container">
                                    @if($reviews->count() > 0)
                                        @foreach ($reviews as $index => $review)
                                        <div class="col-12 border-bottom border-color-extra-medium-gray pb-40px mb-40px xs-pb-30px xs-mb-30px review-item" data-index="{{ $index }}">
                                            <div class="d-block d-md-flex w-100 align-items-center">
                                                <div class="w-300px md-w-250px sm-w-100 sm-mb-10px text-center">
                                                    <img src="{{ asset('assets/images/avt.jpg') }}" class="rounded-circle w-70px mb-10px" alt="">
                                                    <span class="text-dark-gray fw-600 d-block">{{ $review->user->name }}</span>
                                                    <div class="fs-14 lh-18">{{ $review->created_at->format('d/m/Y') }}</div>
                                                </div>
                                                <div class="w-100 last-paragraph-no-margin sm-ps-0 position-relative text-center text-md-start">
                                                    <span class="text-golden-yellow ls-minus-1px mb-5px sm-me-10px sm-mb-0 d-inline-block d-md-block">
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            @if ($i <= $review->rating)
                                                                <i class="bi bi-star-fill"></i>
                                                            @else
                                                                <i class="bi bi-star"></i>
                                                            @endif
                                                        @endfor
                                                    </span>
                                                    <p class="w-85 sm-w-100 sm-mt-15px">{{ $review->content }}</p>
                                                    @if($review->admin_reply)
                                                        <div class="bg-light p-3 mt-2 border rounded">
                                                            <strong class="text-primary">Admin trả lời:</strong>
                                                            <div>{{ $review->admin_reply }}</div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    @else
                                        <div class="col-12 text-center">
                                            <p>Chưa có đánh giá nào cho sản phẩm này.</p>
                                        </div>
                                    @endif

                                    @if($reviews->count() > 0)
                                    <div class="col-12 last-paragraph-no-margin text-center">
                                        <a href="#" class="btn btn-link btn-hover-animation-switch btn-extra-large text-dark-gray">
                                            <span>
                                                <span class="btn-text">Hiển thị thêm đánh giá</span>
                                                <span class="btn-icon"><i class="fa-solid fa-chevron-down"></i></span>
                                                <span class="btn-icon"><i class="fa-solid fa-chevron-down"></i></span>
                                            </span>
                                        </a>
                                    </div>
                                    @endif
                                </div>
                                <div class="row justify-content-center">
                                    <div class="col-12">
                                        <div class="p-7 lg-p-5 sm-p-7 bg-very-light-gray">
                                            @auth
                                            <div class="row justify-content-center mb-30px sm-mb-10px">
                                                <div class="col-md-9 text-center">
                                                    <h4 class="alt-font text-dark-gray fw-500 mb-15px">Thêm bình luận</h4>
                                                </div>
                                            </div>
                                            <form action="{{ route('reviews.store') }}#comments" method="post" class="row contact-form-style-02">
                                               @csrf
                                               <input type="hidden" name="product_id" value="{{$product->id}}">
                                                <div class="col-lg-2 mb-20px">
                                                    <label class="form-label">Đánh giá*</label>
                                                    <div class="d-block md-mt-0">
                                                        <div class="rating-stars icon-small">
                                                            <input class="d-none" type="radio" id="star5" name="rating" value="5" required/>
                                                            <label for="star5" title="5 sao"><i class="bi bi-star-fill"></i></label>
                                                            <input class="d-none" type="radio" id="star4" name="rating" value="4" />
                                                            <label for="star4" title="4 sao"><i class="bi bi-star-fill"></i></label>
                                                            <input class="d-none" type="radio" id="star3" name="rating" value="3" />
                                                            <label for="star3" title="3 sao"><i class="bi bi-star-fill"></i></label>
                                                            <input class="d-none" type="radio" id="star2" name="rating" value="2" />
                                                            <label for="star2" title="2 sao"><i class="bi bi-star-fill"></i></label>
                                                            <input class="d-none" type="radio" id="star1" name="rating" value="1" />
                                                            <label for="star1" title="1 sao"><i class="bi bi-star-fill"></i></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 mb-20px">
                                                    <label class="form-label mb-15px">Đánh giá của bạn</label>
                                                    <textarea class="border-radius-4px form-control" cols="40" rows="4" name="content" placeholder="Tin nhắn của bạn"></textarea>
                                                </div>

                                                <div class="">
                                                    <input type="hidden" name="redirect" value="">
                                                    <button class="btn btn-dark-gray btn-small btn-box-shadow btn-round-edge submit" type="submit">Gửi đánh giá</button>
                                                </div>
                                                <div id="review-success-message" class="alert alert-success mt-3 d-none"></div>
                                                <div class="col-12"><div class="form-results mt-20px d-none"></div></div>
                                            </form>
                                            @else
                                            <div class="alert alert-info text-center">
                                                <p>Vui lòng <a class="text-warning"
                                                        href="{{ route('login') }}?redirect={{ urlencode(url()->current() . '#comments') }} ">đăng
                                                        nhập</a> để viết bình luận.</p>
                                            </div>
                                        @endguest
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end tab content -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- end section -->
        <!-- start section -->
        <section class="pt-0">
            <div class="container">
                <div class="row mb-5">
                    <div class="col-12 text-center">
                        <h2 class="alt-font text-dark-gray mb-0 ls-minus-2px">Related <span class="text-highlight fw-600">products<span class="bg-base-color h-5px bottom-2px"></span></span></h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <ul class="shop-modern shop-wrapper grid grid-4col md-grid-3col sm-grid-2col xs-grid-1col gutter-extra-large text-center">
                            <li class="grid-sizer"></li>
                            <!-- start shop item -->
                            <li class="grid-item">
                                <div class="shop-box mb-10px">
                                    <div class="shop-image mb-20px">
                                        <a href="demo-fashion-store-single-product.html">
                                            <img src="https://placehold.co/600x765" alt="">
                                            <span class="lable new">New</span>
                                            <div class="shop-overlay bg-gradient-gray-light-dark-transparent"></div>
                                        </a>
                                        <div class="shop-buttons-wrap">
                                            <a href="demo-fashion-store-single-product.html" class="alt-font btn btn-small btn-box-shadow btn-white btn-round-edge left-icon add-to-cart">
                                                <i class="feather icon-feather-shopping-bag"></i><span class="quick-view-text button-text">Thêm vào giỏ</span>
                                            </a>
                                        </div>
                                        <div class="shop-hover d-flex justify-content-center">
                                            <ul>
                                                <li>
                                                    <a href="#" class="w-40px h-40px bg-white text-dark-gray d-flex align-items-center justify-content-center rounded-circle ms-5px me-5px" data-bs-toggle="tooltip" data-bs-placement="left" title="Add to wishlist"><i class="feather icon-feather-heart fs-16"></i></a>
                                                </li>
                                                <li>
                                                    <a href="#" class="w-40px h-40px bg-white text-dark-gray d-flex align-items-center justify-content-center rounded-circle ms-5px me-5px" data-bs-toggle="tooltip" data-bs-placement="left" title="Quick shop"><i class="feather icon-feather-eye fs-16"></i></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="shop-footer text-center">
                                        <a href="demo-fashion-store-single-product.html" class="alt-font text-dark-gray fs-19 fw-500">Textured sweater</a>
                                        <div class="price lh-22 fs-16"><del>$200.00</del>$189.00</div>
                                    </div>
                                </div>
                            </li>
                            <!-- end shop item -->
                            <!-- start shop item -->
                            <li class="grid-item">
                                <div class="shop-box mb-10px">
                                    <div class="shop-image mb-20px">
                                        <a href="demo-fashion-store-single-product.html">
                                            <img src="https://placehold.co/600x765" alt="">
                                            <div class="shop-overlay bg-gradient-gray-light-dark-transparent"></div>
                                        </a>
                                        <div class="shop-buttons-wrap">
                                            <a href="demo-fashion-store-single-product.html" class="alt-font btn btn-small btn-box-shadow btn-white btn-round-edge left-icon add-to-cart">
                                                <i class="feather icon-feather-shopping-bag"></i><span class="quick-view-text button-text">Add to cart</span>
                                            </a>
                                        </div>
                                        <div class="shop-hover d-flex justify-content-center">
                                            <ul>
                                                <li>
                                                    <a href="#" class="w-40px h-40px bg-white text-dark-gray d-flex align-items-center justify-content-center rounded-circle ms-5px me-5px" data-bs-toggle="tooltip" data-bs-placement="left" title="Add to wishlist"><i class="feather icon-feather-heart fs-16"></i></a>
                                                </li>
                                                <li>
                                                    <a href="#" class="w-40px h-40px bg-white text-dark-gray d-flex align-items-center justify-content-center rounded-circle ms-5px me-5px" data-bs-toggle="tooltip" data-bs-placement="left" title="Quick shop"><i class="feather icon-feather-eye fs-16"></i></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="shop-footer text-center">
                                        <a href="demo-fashion-store-single-product.html" class="alt-font text-dark-gray fs-19 fw-500">Traveller shirt</a>
                                        <div class="price lh-22 fs-16"><del>$350.00</del>$289.00</div>
                                    </div>
                                </div>
                            </li>
                            <!-- end shop item -->
                            <!-- start shop item -->
                            <li class="grid-item">
                                <div class="shop-box mb-10px">
                                    <div class="shop-image mb-20px">
                                        <a href="demo-fashion-store-single-product.html">
                                            <img src="https://placehold.co/600x765" alt="">
                                            <div class="shop-overlay bg-gradient-gray-light-dark-transparent"></div>
                                        </a>
                                        <div class="shop-buttons-wrap">
                                            <a href="demo-fashion-store-single-product.html" class="alt-font btn btn-small btn-box-shadow btn-white btn-round-edge left-icon add-to-cart">
                                                <i class="feather icon-feather-shopping-bag"></i><span class="quick-view-text button-text">Add to cart</span>
                                            </a>
                                        </div>
                                        <div class="shop-hover d-flex justify-content-center">
                                            <ul>
                                                <li>
                                                    <a href="#" class="w-40px h-40px bg-white text-dark-gray d-flex align-items-center justify-content-center rounded-circle ms-5px me-5px" data-bs-toggle="tooltip" data-bs-placement="left" title="Add to wishlist"><i class="feather icon-feather-heart fs-16"></i></a>
                                                </li>
                                                <li>
                                                    <a href="#" class="w-40px h-40px bg-white text-dark-gray d-flex align-items-center justify-content-center rounded-circle ms-5px me-5px" data-bs-toggle="tooltip" data-bs-placement="left" title="Quick shop"><i class="feather icon-feather-eye fs-16"></i></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="shop-footer text-center">
                                        <a href="demo-fashion-store-single-product.html" class="alt-font text-dark-gray fs-19 fw-500">Crewneck sweatshirt</a>
                                        <div class="price lh-22 fs-16"><del>$220.00</del>$199.00</div>
                                    </div>
                                </div>
                            </li>
                            <!-- end shop item -->
                            <!-- start shop item -->
                            <li class="grid-item">
                                <div class="shop-box mb-10px">
                                    <div class="shop-image mb-20px">
                                        <a href="demo-fashion-store-single-product.html">
                                            <img src="https://placehold.co/600x765" alt="">
                                            <div class="shop-overlay bg-gradient-gray-light-dark-transparent"></div>
                                        </a>
                                        <div class="shop-buttons-wrap">
                                            <a href="demo-fashion-store-single-product.html" class="alt-font btn btn-small btn-box-shadow btn-white btn-round-edge left-icon add-to-cart">
                                                <i class="feather icon-feather-shopping-bag"></i><span class="quick-view-text button-text">Add to cart</span>
                                            </a>
                                        </div>
                                        <div class="shop-hover d-flex justify-content-center">
                                            <ul>
                                                <li>
                                                    <a href="#" class="w-40px h-40px bg-white text-dark-gray d-flex align-items-center justify-content-center rounded-circle ms-5px me-5px" data-bs-toggle="tooltip" data-bs-placement="left" title="Add to wishlist"><i class="feather icon-feather-heart fs-16"></i></a>
                                                </li>
                                                <li>
                                                    <a href="#" class="w-40px h-40px bg-white text-dark-gray d-flex align-items-center justify-content-center rounded-circle ms-5px me-5px" data-bs-toggle="tooltip" data-bs-placement="left" title="Quick shop"><i class="feather icon-feather-eye fs-16"></i></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="shop-footer text-center">
                                        <a href="demo-fashion-store-single-product.html" class="alt-font text-dark-gray fs-19 fw-500">Skinny trousers</a>
                                        <div class="price lh-22 fs-16"><del>$300.00</del>$259.00</div>
                                    </div>
                                </div>
                            </li>
                            <!-- end shop item -->
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        <!-- end section -->
        <style>
            .rating-stars {
                display: inline-flex;
                direction: rtl;
                justify-content: flex-end;
            }
            .rating-stars label {
                cursor: pointer;
            }
            .rating-stars i {
                color: #e4e4e4;
                transition: color 0.2s;
            }
            .rating-stars input:checked ~ label i,
            .rating-stars label:hover i,
            .rating-stars label:hover ~ label i {
                color: #ffb60f; /* text-golden-yellow */
            }
        </style>

@endsection

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Nếu có hash trên URL, active tab tương ứng
        if(window.location.hash) {
            let hash = window.location.hash;
            let tabLink = document.querySelector('a[href="' + hash + '"]');
            if(tabLink) {
                let tab = new bootstrap.Tab(tabLink);
                tab.show();
            }
        }

        // Khi click vào tab, cập nhật hash trên URL
        document.querySelectorAll('.nav-tabs .nav-link').forEach(function(tabLink) {
            tabLink.addEventListener('shown.bs.tab', function (e) {
                history.replaceState(null, null, e.target.getAttribute('href'));
            });
        });

        // Ẩn các review-item từ số 4 trở đi
        let reviews = document.querySelectorAll('.review-item');
        let showMoreBtn = document.querySelector('.btn-text');
        let showMoreBtnA = showMoreBtn ? showMoreBtn.closest('a') : null;
        let expanded = false;

        function collapseReviews() {
            reviews.forEach((item, idx) => {
                item.style.display = (idx > 2) ? 'none' : '';
            });
            if(showMoreBtn) showMoreBtn.textContent = 'Hiển thị thêm đánh giá';
            expanded = false;
        }
        function expandReviews() {
            reviews.forEach(item => item.style.display = '');
            if(showMoreBtn) showMoreBtn.textContent = 'Thu gọn đánh giá';
            expanded = true;
        }

        if (reviews.length > 3) {
            collapseReviews();
            if(showMoreBtnA) showMoreBtnA.style.display = '';
        } else if(showMoreBtnA) {
            showMoreBtnA.style.display = 'none';
        }

        if (showMoreBtnA) {
            showMoreBtnA.addEventListener('click', function(e) {
                e.preventDefault();
                if (!expanded) {
                    expandReviews();
                } else {
                    collapseReviews();
                    // Scroll về vị trí review-list-container nếu cần
                    document.getElementById('review-list-container').scrollIntoView({behavior: 'smooth'});
                }
            });
        }
    });
</script>
