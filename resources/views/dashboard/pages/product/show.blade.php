@extends('dashboard.layouts.layout')

@section('main-content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Chi Tiết Sản Phẩm</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Quản lý sản phẩm</a></li>
                                <li class="breadcrumb-item active">Chi Tiết Sản Phẩm</li>
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
                                    <div class="d-flex flex-row w-100">
                                        {{-- Cột trái: Hình ảnh --}}
                                        <div class="me-4">
                                            @if ($product->image_url)
                                                <div class="my-3">
                                                    <img src="{{ asset($product->image_url) }}" alt="{{ $product->name }}"
                                                        class="img-thumbnail"
                                                        style="max-height: 250px; object-fit: contain; max-width: 250px;">
                                                </div>
                                            @else
                                                <p class="text-muted">Không có hình ảnh.</p>
                                            @endif
                                        </div>

                                        {{-- Cột phải: Thông tin và mô tả --}}
                                        <div class="flex-grow-1">
                                            <h4>{{ $product->name }}</h4>
                                            <div class="hstack gap-3 flex-wrap mb-3">
                                                <div><a href="#"
                                                        class="text-primary d-block">{{ $product->category->name ?? 'Chưa có danh mục' }}</a>
                                                </div>
                                                <div class="vr"></div>
                                                <div class="text-muted">Ngày tạo: <span
                                                        class="text-body fw-medium">{{ $product->created_at ? $product->created_at->format('d/m/Y') : 'N/A' }}</span>
                                                </div>
                                            </div>

                                            <h5>Mô tả sản phẩm:</h5>
                                            @if ($product->description)
                                                <div class="border p-3 rounded bg-light">
                                                    {!! $product->description !!}
                                                </div>
                                            @else
                                                <p class="text-muted">Chưa có mô tả cho sản phẩm này.</p>
                                            @endif
                                        </div>

                                        {{-- Nút chỉnh sửa --}}
                                        <div class="ms-3">
                                            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-light"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title="Chỉnh sửa">
                                                <i class="ri-pencil-fill align-bottom"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-4">
                                    <div class="col-lg-4 col-sm-6">
                                        <div class="p-2 border border-dashed rounded">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm me-2">
                                                    <div class="avatar-title rounded bg-transparent text-success fs-24">
                                                        <i class="ri-hashtag"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <p class="text-muted mb-1">Mã sản phẩm:</p>
                                                    <h5 class="mb-0">{{ $product->id }}</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end col -->
                                    <div class="col-lg-4 col-sm-6">
                                        <div class="p-2 border border-dashed rounded">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm me-2">
                                                    <div class="avatar-title rounded bg-transparent text-success fs-24">
                                                        <i class="ri-price-tag-3-fill"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <p class="text-muted mb-1">Slug (đường dẫn):</p>
                                                    <h5 class="mb-0">{{ $product->slug }}</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end col -->
                                    <div class="col-lg-4 col-sm-6">
                                        <div class="p-2 border border-dashed rounded">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm me-2">
                                                    <div class="avatar-title rounded bg-transparent text-success fs-24">
                                                        <i class="ri-calendar-todo-fill"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <p class="text-muted mb-1">Ngày cập nhật:</p>
                                                    <h5 class="mb-0">
                                                        {{ $product->updated_at ? $product->updated_at->format('d/m/Y') : 'N/A' }}
                                                    </h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end col -->
                                </div>



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
                    <script>
                        document.write(new Date().getFullYear())
                    </script> © Velzon.
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
