@extends('dashboard.layouts.layout')

@section('main-content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Chi tiết biến thể</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('variants.index') }}">Biến thể</a></li>
                                <li class="breadcrumb-item active">Chi tiết biến thể</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">

                            <div class="row gx-lg-5">
                                <div class="col-xl-4 col-md-8 mx-auto">
                                    <div class="product-img-slider sticky-side-div">
                                        <div class="swiper product-thumbnail-slider p-2 rounded bg-light">
                                            @if ($variant->variant_image_url)
                                                <div class="swiper-slide">
                                                    <img src="{{ asset($variant->variant_image_url) }}"
                                                        alt="{{ $variant->name }}" class="img-fluid d-block" />
                                                </div>
                                            @else
                                                <div class="swiper-slide">
                                                    <img src="{{ asset('storage/no-image.png') }}" alt="Không có hình"
                                                        class="img-fluid d-block" />
                                                </div>
                                            @endif
                                        
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-8">
                                    <div class="mt-xl-0 mt-5">
                                        <h4>{{ $variant->name }}</h4>
                                        <p><strong>Sản phẩm cha:</strong> {{ $variant->product->name ?? 'N/A' }}</p>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="d-flex align-items-center gap-2">
                                                    <p class="mb-0"><strong>Màu sắc:</strong>
                                                        {{ $variant->color->color_name ?? 'N/A' }}</p>
                                                    @if (!empty($variant->color->color_code))
                                                        <div class="border"
                                                            style="width: 25px; height: 25px; background-color: {{ $variant->color->color_code }};">
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                            <div class="col-md-4">
                                                <p><strong>Size:</strong> {{ $variant->size->size_name ?? 'N/A' }}</p>
                                            </div>
                                            <div class="col-md-4">
                                                <p><strong>Trạng thái:</strong>
                                                    @if ($variant->is_show)
                                                        <span class="badge bg-success">Hiển thị</span>
                                                    @else
                                                        <span class="badge bg-danger">Ẩn</span>
                                                    @endif
                                                </p>
                                            </div>
                                        </div>

                                        <hr>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <p><strong>Giá nhập:</strong>
                                                    {{ number_format($variant->import_price, 0, ',', '.') }} VNĐ</p>
                                            </div>
                                            <div class="col-md-4">
                                                <p><strong>Giá bán niêm yết:</strong>
                                                    {{ number_format($variant->listed_price, 0, ',', '.') }} VNĐ</p>
                                            </div>
                                            <div class="col-md-4">
                                                <p><strong>Giá bán khuyến mãi:</strong>
                                                    {{ number_format($variant->sale_price, 0, ',', '.') }} VNĐ</p>
                                            </div>
                                        </div>

                                        <div class="mt-3">
                                            <p><strong>Kho hàng:</strong> {{ $variant->stock }}</p>
                                        </div>

                                        <hr>



                                        <a href="{{ route('variants.edit', $variant->id) }}"
                                            class="btn btn-primary mt-3">Chỉnh sửa biến thể</a>
                                        <a href="{{ route('variants.index') }}" class="btn btn-secondary mt-3">Quay lại
                                            danh sách</a>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
