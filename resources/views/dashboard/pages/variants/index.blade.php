@extends('dashboard.layouts.layout')

@section('main-content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Products</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Ecommerce</a></li>
                                <li class="breadcrumb-item active">Products</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
               
                <!-- end col -->

                <div class="col-xl-12 col-lg-8">
                    <div>
                        <div class="card">
                            <div class="card-header border-0">
                                <div class="row g-4">
                                    <div class="col-sm-auto">
                                        <div>
                                            <a href="{{ route('products.index') }}" class="btn btn-info"
                                                id="addproduct-btn"> Quản lý sản phẩm</a>
                                        </div>
                                    </div>
                                    <div class="col-sm">
                                        <div class="d-flex justify-content-sm-end">
                                            <div class="search-box ms-2">
                                                <input type="text" class="form-control" id="searchProductList"
                                                    placeholder="Search Products...">
                                                <i class="ri-search-line search-icon"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-header">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <ul class="nav nav-tabs-custom card-header-tabs border-bottom-0" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active fw-semibold" data-bs-toggle="tab"
                                                    href="#productnav-all" role="tab">
                                                    All <span
                                                        class="badge bg-danger-subtle text-danger align-middle rounded-pill ms-1">12</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link fw-semibold" data-bs-toggle="tab"
                                                    href="#productnav-published" role="tab">
                                                    Published <span
                                                        class="badge bg-danger-subtle text-danger align-middle rounded-pill ms-1">5</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link fw-semibold" data-bs-toggle="tab"
                                                    href="#productnav-draft" role="tab">
                                                    Draft
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-auto">
                                        <div id="selection-element">
                                            <div class="my-n1 d-flex align-items-center text-muted">
                                                Select <div id="select-content" class="text-body fw-semibold px-1"></div>
                                                Result <button type="button" class="btn btn-link link-danger p-0 ms-3"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#removeItemModal">Remove</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end card header -->

                            <div class="card-body">

                                <!-- Bảng biến thể sản phẩm -->
                                <table class="table align-middle table-nowrap mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Tên biến thể</th>
                                            <th>Ảnh</th>
                                            <th>Giá nhập</th>
                                            <th>Giá niêm yết</th>
                                            <th>Giá bán</th>
                                            <th>Kho</th>
                                            <th>Tên sản phẩm</th>
                                            <th>Size</th>
                                            <th>Màu sắc</th>
                                            <th>Hành động</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($variants as $index => $variant)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td class="fw-semibold">{{ $variant->name }}</td>
                                                <td>
                                                    <div class="avatar-sm bg-light rounded p-1 mb-3">
                                                        <img src="{{ $variant->variant_image_url ? asset($variant->variant_image_url) : asset('storage/no-image.png') }}"
                                                            alt="{{ $variant->name }}" class="img-fluid d-block rounded"
                                                            width="50" height="50" >
                                                    </div>
                                                </td>
                                                <td>{{ number_format($variant->import_price, 0, ',', '.') }} đ</td>
                                                <td>{{ number_format($variant->listed_price, 0, ',', '.') }} đ</td>
                                                <td>{{ number_format($variant->sale_price, 0, ',', '.') }} đ</td>
                                                <td>{{ $variant->stock }}</td>
                                                <td>{{ $variant->product->name ?? 'Chưa có' }}</td>
                                                <td>{{ $variant->size->size_name ?? '-' }}</td>
                                                <td>{{ $variant->color->color_name ?? '-' }}</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-soft-secondary btn-sm" type="button"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="ri-more-fill"></i>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end">
                                                            <li>
                                                                <a class="dropdown-item"
                                                                    href="{{ route('variants.show', $variant->id) }}">
                                                                    <i
                                                                        class="ri-eye-fill align-bottom me-2 text-muted"></i>
                                                                    Xem
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item"
                                                                    href="{{ route('variants.edit', $variant->id) }}">
                                                                    <i
                                                                        class="ri-pencil-fill align-bottom me-2 text-muted"></i>
                                                                    Sửa
                                                                </a>
                                                            </li>
                                                            <li class="dropdown-divider"></li>
                                                            <li>
                                                                <form
                                                                    action="{{ route('variants.destroy', $variant->id) }}"
                                                                    method="POST"
                                                                    onsubmit="return confirm('Bạn có chắc muốn xóa biến thể này?');">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit"
                                                                        class="dropdown-item text-danger">
                                                                        <i
                                                                            class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>
                                                                        Xóa
                                                                    </button>
                                                                </form>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>


                            </div>

                            <!-- end card body -->
                        </div>
                        <!-- end card -->
                    </div>
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->

        </div>
        <!-- container-fluid -->
    </div>
    <!-- End Page-content -->

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
