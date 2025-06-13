<div id="search-result-container">
<div class="col-xxl-10 col-lg-9 ps-5 md-ps-15px md-mb-60px">
    <div class="row align-items-center">
        <div class="col-md-6">
            @if(request('q'))
                <p class="text-muted fs-15 mb-0">
                    Tìm thấy 
                    <span class="fw-bold text-dark">{{ $products->total() }}</span> 
                    kết quả với từ khoá 
                    "<span class="fw-bold text-dark">{{ request('q') }}</span>"
                </p>
            @endif
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
    
                <label for="sort" class="fw-500 mb-0">Sắp xếp:</label>
                <select name="sort" id="sort" class="form-select form-select-sm w-auto border-0 bg-light" onchange="this.form.submit()">
                    <option value="">-- Chọn --</option>
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
</div>