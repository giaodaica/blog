@extends('dashboard.layouts.layout')

@section('main-content')
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Product Details</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Ecommerce</a></li>
                            <li class="breadcrumb-item active">Product Details</li>
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
                        <div class="mt-0">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h4>{{ $product->name }}</h4>

                                    {{-- Hiển thị hình ảnh --}}
                                    @if ($product->image_url)
                                        <div class="my-3">
                                            <img src="{{ asset( $product->image_url) }}" alt="{{ $product->name }}" class="img-thumbnail" style="max-height: 250px;">
                                        </div>
                                    @else
                                        <p class="text-muted">No image available.</p>
                                    @endif

                                    <div class="hstack gap-3 flex-wrap">
                                        <div><a href="#" class="text-primary d-block">{{ $product->category->name ?? 'No Brand' }}</a></div>
                                        <div class="vr"></div>
                                        <div class="text-muted">Seller : <span class="text-body fw-medium">{{ $product->seller ?? 'Unknown' }}</span></div>
                                        <div class="vr"></div>
                                        <div class="text-muted">Published : <span class="text-body fw-medium">{{ $product->created_at ? $product->created_at->format('d M, Y') : 'N/A' }}</span></div>
                                    </div>
                                </div>
                                <div>
                                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-light"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                        <i class="ri-pencil-fill align-bottom"></i>
                                    </a>
                                </div>
                            </div>

                            <div class="d-flex flex-wrap gap-2 align-items-center mt-3">
                                <div class="text-muted fs-16">
                                    @for ($i = 0; $i < 5; $i++)
                                        <span class="mdi mdi-star text-warning"></span>
                                    @endfor
                                </div>
                                <div class="text-muted">( {{ number_format($product->reviews_count ?? 0) }} Customer Review )</div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-lg-3 col-sm-6">
                                    <div class="p-2 border border-dashed rounded">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm me-2">
                                                <div class="avatar-title rounded bg-transparent text-success fs-24">
                                                    <i class="ri-money-dollar-circle-fill"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <p class="text-muted mb-1">Price :</p>
                                                <h5 class="mb-0">${{ number_format($product->price ?? 0, 2) }}</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end col -->
                                <div class="col-lg-3 col-sm-6">
                                    <div class="p-2 border border-dashed rounded">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm me-2">
                                                <div class="avatar-title rounded bg-transparent text-success fs-24">
                                                    <i class="ri-file-copy-2-fill"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <p class="text-muted mb-1">No. of Orders :</p>
                                                <h5 class="mb-0">{{ number_format($product->orders_count ?? 0) }}</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end col -->
                                <div class="col-lg-3 col-sm-6">
                                    <div class="p-2 border border-dashed rounded">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm me-2">
                                                <div class="avatar-title rounded bg-transparent text-success fs-24">
                                                    <i class="ri-stack-fill"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <p class="text-muted mb-1">Available Stocks :</p>
                                                <h5 class="mb-0">{{ number_format($product->stock ?? 0) }}</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end col -->
                                <div class="col-lg-3 col-sm-6">
                                    <div class="p-2 border border-dashed rounded">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm me-2">
                                                <div class="avatar-title rounded bg-transparent text-success fs-24">
                                                    <i class="ri-inbox-archive-fill"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <p class="text-muted mb-1">Total Revenue :</p>
                                                <h5 class="mb-0">${{ number_format($product->revenue ?? 0, 2) }}</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end col -->
                            </div>

                            <div class="mt-4 text-muted">
                                <h5 class="fs-14">Description :</h5>
                                <p>{{ $product->description ?? 'No description available.' }}</p>
                            </div>

                            {{-- Bỏ bảng variants nếu chưa cần hiển thị --}}

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <script>document.write(new Date().getFullYear())</script> © Velzon.
            </div>
            <div class="col-sm-6">
                <div class="text-sm-end d-none d-sm-block">
                    Design & Develop by Themesbrand
                </div>
            </div>
        </div>
    </div>
</footer>
@endsection
