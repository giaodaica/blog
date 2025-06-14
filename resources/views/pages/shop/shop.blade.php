@extends('layouts.layout')
@section('content')
    <section class="top-space-margin half-section bg-gradient-very-light-gray">
        <div class="container">
            <div class="row align-items-center justify-content-center"
                data-anime='{ "el": "childs", "translateY": [-15, 0], "opacity": [0,1], "duration": 300, "delay": 0, "staggervalue": 100, "easing": "easeOutQuad" }'>
                <div class="col-12 col-xl-8 col-lg-10 text-center position-relative page-title-extra-large">
                    <h1 class="alt-font fw-600 text-dark-gray mb-10px">Shop</h1>
                </div>
                <div class="col-12 breadcrumb breadcrumb-style-01 d-flex justify-content-center">
                    <ul>
                        <li><a href="demo-fashion-store.html">Home</a></li>
                        <li>Shop</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!-- end section -->
    <!-- start section -->
    <section class="pt-0 ps-6 pe-6 lg-ps-2 lg-pe-2 sm-ps-0 sm-pe-0">
        <div class="container-fluid">
            <div class="row flex-row-reverse">
                <div class="col-xxl-10 col-lg-9 ps-5 md-ps-15px md-mb-60px">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div id="search-summary" class="text-muted fs-15 mb-0"></div>

                        
                        </div>
                    
                        <div class="col-md-6 text-md-end">
                            <form action="{{ route('home.shop') }}" method="GET" class="d-flex justify-content-md-end align-items-center gap-2">
                                {{-- Preserve all existing filters --}}
                                @foreach(request()->except('sort') as $key => $value)
                                    @if(is_array($value))
                                        @foreach($value as $v)
                                            <input type="hidden" name="{{ $key }}[]" value="{{ $v }}">
                                        @endforeach
                                    @else
                                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                                    @endif
                                @endforeach
                    
                                
                                <select name="sort" id="sort" class="form-select form-select-sm w-auto border-0 bg-light">
                                    <option value="">Sắp xếp</option>
                                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Mới nhất</option>
                                    <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Giá tăng dần</option>
                                    <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Giá giảm dần</option>
                                </select>
                            </form>
                        </div>
                    </div>
                    
                    @if($products->isEmpty())
                        <div class="text-center py-5">
                            <h6 class="alt-font fw-500 text-dark-gray mb-3">Rất tiếc, chúng tôi không tìm thấy sản phẩm nào phù hợp.</h6>
                           
                        </div>
                    @else
                   
                    
                        <ul class="shop-modern shop-wrapper grid-loading grid grid-5col lg-grid-4col md-grid-3col sm-grid-2col xs-grid-1col gutter-extra-large text-center">
                            <li class="grid-sizer"></li>
                            @if (!request('q'))
                            @foreach ($products as $product)
                                <!-- start shop item -->
                                <li class="grid-item">
                                    <div class="shop-box mb-10px">
                                        <div class="shop-image mb-20px">
                                            <a href="{{ route('home.show', $product->id) }}">
                                                <img src="{{ asset('assets/images/shop/demo-fashion-store-product-01.jpg') }}" alt="{{ $product->name }}">
                                                <div class="shop-overlay bg-gradient-gray-light-dark-transparent"></div>
                                            </a>
                                        </div>
                                        <div class="shop-footer text-start">
                                            <a href="{{ route('home.show', $product->id) }}" class="alt-font text-dark-gray fs-19 fw-500">{{ $product->name }}</a>
                                            <div class="price lh-22 fs-16">
                                                @php
                                                    $variant = $product->variants->first();
                                                    $rating = $product->rating ?? 0;
                                                    $reviewCount = $product->review_count ?? 0;
                                                @endphp
                                                @if ($variant && $variant->sale_price < $variant->listed_price)
                                                    <div class="product-price">
                                                        {{ number_format($variant->sale_price) }} ₫
                                                        <span class="product-old-price">{{ number_format($variant->listed_price) }} ₫</span>
                                                    </div>
                                                @elseif($variant)
                                                    <span>{{ number_format($variant->listed_price) }}₫</span>
                                                @endif
                                            </div>
                                            <div class="rating">
                                                <span class="text-warning">★★★★★</span> {{ number_format($rating, 1) }}
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <!-- end shop item -->
                            @endforeach
                            @endif
                        </ul>
                        
                        <div class="w-100 d-flex mt-4 justify-content-center md-mt-30px">
                            <ul class="pagination pagination-style-01 fs-13 fw-500 mb-0">
                                <!-- Nút Previous -->
                                <li class="page-item {{ $products->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $products->previousPageUrl() }}" {{ $products->onFirstPage() ? 'aria-disabled="true"' : '' }}>
                                        <i class="feather icon-feather-arrow-left fs-18 d-xs-none"></i>
                                    </a>
                                </li>
                        
                                <!-- Các trang -->
                                @for ($i = 1; $i <= $products->lastPage(); $i++)
                                    <li class="page-item {{ $products->currentPage() == $i ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $products->url($i) }}">{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</a>
                                    </li>
                                @endfor
                        
                                <!-- Nút Next -->
                                <li class="page-item {{ $products->hasMorePages() ? '' : 'disabled' }}">
                                    <a class="page-link" href="{{ $products->nextPageUrl() }}" {{ $products->hasMorePages() ? '' : 'aria-disabled="true"' }}>
                                        <i class="feather icon-feather-arrow-right fs-18 d-xs-none"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    @endif
                </div>
                <div class="col-xxl-2 col-lg-3 shop-sidebar"
                    data-anime='{ "el": "childs", "translateY": [-15, 0], "opacity": [0,1], "duration": 300, "delay": 0, "staggervalue": 300, "easing": "easeOutQuad" }'>
                    <form action="{{ route('home.shop') }}" method="GET" id="filterForm">
                        <div class="mb-30px">
                            <div class="d-flex align-items-center mb-10px">
                                <span class="alt-font fw-500 fs-19 text-dark-gray d-block">Danh Mục</span>
                                <i class="fa-solid fa-chevron-down ms-auto toggle-filter" style="cursor: pointer;"></i>
                            </div>
                            <ul class="shop-filter category-filter fs-16">
                                @php
                                    $totalCategories = count($categories);
                                    $initialShow = 4;
                                @endphp
                                @foreach ($categories as $index => $category)
                                    @php
                                        $selected = is_array(request('categories')) && in_array($category->id, request('categories'));
                                    @endphp
                                    <li class="{{ $index >= $initialShow ? 'hidden-category' : '' }}">
                                        <label class="checkbox-container">
                                            <input type="checkbox" name="categories[]" value="{{ $category->id }}"
                                                {{ $selected ? 'checked' : '' }}>
                                            <span class="custom-checkbox {{ $selected ? 'checked' : '' }}"></span>
                                            {{ $category->name }}
                                        </label>
                                        <span class="item-qty">{{ $category->products_count }}</span>
                                    </li>
                                @endforeach
                                @if($totalCategories > $initialShow)
                                    <li class="show-more-categories">
                                        <button type="button" class="btn btn-link p-0 text-decoration-none">Xem thêm</button>
                                    </li>
                                    <li class="collapse-categories" style="display: none;">
                                        <button type="button" class="btn btn-link p-0 text-decoration-none">Thu gọn</button>
                                    </li>
                                @endif
                            </ul>

                        </div>
                        <div class="mb-30px">
                            <div class="d-flex align-items-center mb-10px">
                                <span class="alt-font fw-500 fs-19 text-dark-gray d-block">Mức Giá</span>
                                <i class="fa-solid fa-chevron-down ms-auto toggle-filter" style="cursor: pointer;"></i>
                            </div>
                        
                            {{-- Bộ lọc radio sẵn có --}}
                            <ul class="shop-filter price-filter fs-16">
                                @php
                                    $priceRanges = [
                                        '' => 'Tất cả',
                                        '0-100000' => 'Dưới 100k',
                                        '100000-300000' => '100K - 300k',
                                        '300000-500000' => '300k - 500k',
                                        '500000-1000000' => '500k - 1 triệu',
                                        '1000000-999999999' => 'Trên 1 triệu',
                                    ];
                                    $selectedPriceRange = request('price_range', ''); // Default to empty string
                                @endphp
                                @foreach ($priceRanges as $range => $label)
                                    <li>
                                        <label class="checkbox-container">
                                            <input type="radio" 
                                                   name="price_range" 
                                                   value="{{ $range }}"
                                                   {{ $selectedPriceRange === $range ? 'checked' : '' }}>
                                            <span class="custom-checkbox {{ $selectedPriceRange === $range ? 'checked' : '' }}"></span>
                                            {{ $label }}
                                        </label>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="mb-30px">
                            <div class="d-flex align-items-center mb-10px">
                                <span class="alt-font fw-500 fs-19 text-dark-gray d-block">Màu Sắc</span>
                                <i class="fa-solid fa-chevron-down ms-auto toggle-filter" style="cursor: pointer;"></i>
                            </div>
                            <ul class="shop-filter color-filter fs-16">
                                @foreach ($colors as $color)
                                    @php
                                        $selected =
                                            is_array(request('colors')) && in_array($color->id, request('colors'));
                                    @endphp
                                    <li>
                                        <label class="checkbox-container">
                                            <input type="checkbox" name="colors[]" value="{{ $color->id }}"
                                                {{ $selected ? 'checked' : '' }}>
                                            <span class="custom-checkbox {{ $selected ? 'checked' : '' }}"></span>
                                            {{ $color->color_name }}
                                        </label>
                                        <span class="item-qty">{{ $color->product_variants_count }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="mb-30px">
                            <div class="d-flex align-items-center mb-10px">
                                <span class="alt-font fw-500 fs-19 text-dark-gray d-block">Kích Cỡ</span>
                                <i class="fa-solid fa-chevron-down ms-auto toggle-filter" style="cursor: pointer;"></i>
                            </div>
                            <ul class="shop-filter size-filter fs-16">
                                @foreach ($sizes as $size)
                                    @php
                                        $selected = is_array(request('sizes')) && in_array($size->id, request('sizes'));
                                    @endphp
                                    <li>
                                        <label class="checkbox-container">
                                            <input type="checkbox" name="sizes[]" value="{{ $size->id }}"
                                                {{ $selected ? 'checked' : '' }}>
                                            <span class="custom-checkbox {{ $selected ? 'checked' : '' }}"></span>
                                            {{ $size->size_name }}
                                        </label>
                                        <span class="item-qty">{{ $size->product_variants_count }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                       
                        
                        <div class="mb-30px">
                            <div class="d-flex align-items-center mb-20px">
                                <span class="alt-font fw-500 fs-19 text-dark-gray">New arrivals</span>
                                <div class="d-flex ms-auto">
                                    <!-- start slider navigation -->
                                    <div
                                        class="slider-one-slide-prev-1 icon-very-small swiper-button-prev slider-navigation-style-08 me-5px">
                                        <i class="fa-solid fa-arrow-left text-dark-gray"></i></div>
                                    <div
                                        class="slider-one-slide-next-1 icon-very-small swiper-button-next slider-navigation-style-08 ms-5px">
                                        <i class="fa-solid fa-arrow-right text-dark-gray"></i></div>
                                    <!-- end slider navigation -->
                                </div>
                            </div>
                            <div class="swiper slider-one-slide"
                                data-slider-options='{ "slidesPerView": 1, "loop": true, "autoplay": { "delay": 5000, "disableOnInteraction": false }, "navigation": { "nextEl": ".slider-one-slide-next-1", "prevEl": ".slider-one-slide-prev-1" }, "keyboard": { "enabled": true, "onlyInViewport": true }, "effect": "slide" }'>
                                <div class="swiper-wrapper">
                                    <!-- start text slider item -->
                                    <div class="swiper-slide">
                                        <div class="shop-filter new-arribals">
                                            <div class="d-flex align-items-center mb-20px">
                                                <figure class="mb-0">
                                                    <a href="demo-fashion-store-single-product.html">
                                                        <img class="border-radius-4px w-80px"
                                                            src="https://placehold.co/600x765" alt="">
                                                    </a>
                                                </figure>
                                                <div class="col ps-25px">
                                                    <a href="demo-fashion-store-single-product.html"
                                                        class="text-dark-gray alt-font fw-500 d-inline-block lh-normal">Textured
                                                        sweater</a>
                                                    <div class="fs-15 lh-normal"><del class="me-5px">$30.00</del>$23.00
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center mb-20px">
                                                <figure class="mb-0">
                                                    <a href="demo-fashion-store-single-product.html">
                                                        <img class="border-radius-4px w-80px"
                                                            src="https://placehold.co/600x765" alt="">
                                                    </a>
                                                </figure>
                                                <div class="col ps-25px">
                                                    <a href="demo-fashion-store-single-product.html"
                                                        class="text-dark-gray alt-font fw-500 d-inline-block lh-normal">Traveller
                                                        shirt</a>
                                                    <div class="fs-15 lh-normal"><del class="me-5px">$50.00</del>$43.00
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <figure class="mb-0">
                                                    <a href="demo-fashion-store-single-product.html">
                                                        <img class="border-radius-4px w-80px"
                                                            src="https://placehold.co/600x765" alt="">
                                                    </a>
                                                </figure>
                                                <div class="col ps-25px">
                                                    <a href="demo-fashion-store-single-product.html"
                                                        class="text-dark-gray alt-font fw-500 d-inline-block lh-normal">Crewneck
                                                        tshirt</a>
                                                    <div class="fs-15 lh-normal"><del class="me-5px">$20.00</del>$15.00
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end text slider item -->
                                    <!-- start text slider item -->
                                    <div class="swiper-slide">
                                        <div class="shop-filter new-arribals">
                                            <div class="d-flex align-items-center mb-20px">
                                                <figure class="mb-0">
                                                    <a href="demo-fashion-store-single-product.html">
                                                        <img class="border-radius-4px w-80px"
                                                            src="https://placehold.co/600x765" alt="">
                                                    </a>
                                                </figure>
                                                <div class="col ps-25px">
                                                    <a href="demo-fashion-store-single-product.html"
                                                        class="text-dark-gray alt-font fw-500 d-inline-block lh-normal">Skinny
                                                        trousers</a>
                                                    <div class="fs-15 lh-normal"><del class="me-5px">$15.00</del>$10.00
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center mb-20px">
                                                <figure class="mb-0">
                                                    <a href="demo-fashion-store-single-product.html">
                                                        <img class="border-radius-4px w-80px"
                                                            src="https://placehold.co/600x765" alt="">
                                                    </a>
                                                </figure>
                                                <div class="col ps-25px">
                                                    <a href="demo-fashion-store-single-product.html"
                                                        class="text-dark-gray alt-font fw-500 d-inline-block lh-normal">Sleeve
                                                        sweater</a>
                                                    <div class="fs-15 lh-normal"><del class="me-5px">$35.00</del>$30.00
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <figure class="mb-0">
                                                    <a href="demo-fashion-store-single-product.html">
                                                        <img class="border-radius-4px w-80px"
                                                            src="https://placehold.co/600x765" alt="">
                                                    </a>
                                                </figure>
                                                <div class="col ps-25px">
                                                    <a href="demo-fashion-store-single-product.html"
                                                        class="text-dark-gray alt-font fw-500 d-inline-block lh-normal">Pocket
                                                        white</a>
                                                    <div class="fs-15 lh-normal"><del class="me-5px">$20.00</del>$15.00
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end text slider item -->
                                </div>
                                <!-- start slider navigation -->
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('styles')
    <link href="{{ asset('assets/css/shop.css') }}" rel="stylesheet">
    
@endpush

@push('scripts')
    <script src="{{ asset('assets/js/shop/shop.js') }}"></script>
    <script src="{{ asset('assets/js/shop/sort.js') }}"></script>
@endpush
