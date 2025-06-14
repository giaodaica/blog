@extends('dashboard.layouts.layout')

@section('main-content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- Page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Thêm mới sản phẩm</h4>
                    </div>
                </div>
            </div>

            <!-- Form -->
            <form id="createproduct-form" autocomplete="off" class="needs-validation" novalidate method="POST"
                action="{{ route('products.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="row">

                    <!-- Left column: Product Info -->
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-body">

                                <!-- Tên sản phẩm -->
                                <div class="mb-3">
                                    <label class="form-label">Tên sản phẩm</label>
                                    <input type="text" class="form-control" name="name"
                                        placeholder="Nhập tên sản phẩm" required>
                                </div>

                                <!-- Thương hiệu -->
                                <div class="mb-3">
                                    <label class="form-label">Thương hiệu</label>
                                    <input type="text" class="form-control" name="brand"
                                        placeholder="Nhập thương hiệu">
                                </div>

                                <!-- Mô tả -->
                                <div class="mb-3">
                                    <label class="form-label">Mô tả</label>
                                    <textarea class="form-control" name="description" rows="4"></textarea>
                                </div>

                                <!-- Danh mục -->
                                <div class="mb-3">
                                    <label class="form-label">Danh mục sản phẩm</label>
                                    <select class="form-select" name="category_id" required>
                                        <option value="">-- Chọn danh mục --</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Ảnh đại diện -->
                                <div class="mb-3">
                                    <label class="form-label">Hình ảnh</label>
                                    <input type="file" class="form-control" name="image_url" accept="image/*">
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- Biến thể -->
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Sản phẩm biến thể</h5>
                            </div>
                            <div class="card-body">

                                <div id="variant-container">
                                    <div class="row variant-item mb-3">
                                        <!-- Size -->
                                        <div class="col-lg-2">
                                            <select class="form-select" name="variants[0][size_id]" required>
                                                <option value="">Size</option>
                                                @foreach ($sizes as $size)
                                                    <option value="{{ $size->id }}">{{ $size->size_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Color -->
                                        <div class="col-lg-2">
                                            <select class="form-select" name="variants[0][color_id]" required>
                                                <option value="">Color</option>
                                                @foreach ($colors as $color)
                                                    <option value="{{ $color->id }}">{{ $color->color_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Giá nhập -->
                                        <div class="col-lg-2">
                                            <input type="number" class="form-control" name="variants[0][import_price]"
                                                placeholder="Giá nhập" min="0" required>
                                        </div>

                                        <!-- Giá niêm yết -->
                                        <div class="col-lg-2">
                                            <input type="number" class="form-control" name="variants[0][listed_price]"
                                                placeholder="Giá niêm yết" min="0" required>
                                        </div>

                                        <!-- Giá khuyến mãi -->
                                        <div class="col-lg-2">
                                            <input type="number" class="form-control" name="variants[0][sale_price]"
                                                placeholder="Giá khuyến mãi" min="0">
                                        </div>

                                        <!-- Số lượng -->
                                        <div class="col-lg-2">
                                            <input type="number" class="form-control" name="variants[0][stock]"
                                                placeholder="Số lượng" min="0" required>
                                        </div>

                                        <!-- Ảnh biến thể -->
                                        <div class="col-lg-2 mt-2">
                                           <input type="file" class="form-control" name="variants[0][variant_image]" accept="image/*">
                                        </div>
                                    </div>

                                </div>

                                <!-- Nút thêm biến thể -->
                                <div class="text-center">
                                    <button type="button" id="add-variant" class="btn btn-success btn-sm">+ Thêm biến
                                        thể</button>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- Nút submit -->
                    <div class="d-flex justify-content-start mb-5">
                        <button type="submit" class="btn btn-primary">THÊM MỚI</button>
                        <a href="{{ route('products.index') }}" class="btn btn-danger ms-2">QUAY LẠI</a>
                    </div>

                </div>
            </form>
        </div>
    </div>
@endsection

@section('js-content')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        let index = 1;

        $('#add-variant').on('click', function() {
            let variantHtml = `
    <div class="row variant-item mb-3">
        <div class="col-lg-2">
            <select class="form-select" name="variants[${index}][size_id]" required>
                <option value="">Size</option>
                @foreach ($sizes as $size)
                    <option value="{{ $size->id }}">{{ $size->size_name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-lg-2">
            <select class="form-select" name="variants[${index}][color_id]" required>
                <option value="">Color</option>
                @foreach ($colors as $color)
                    <option value="{{ $color->id }}">{{ $color->color_name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-lg-2">
            <input type="number" class="form-control" name="variants[${index}][import_price]" placeholder="Giá nhập" min="0" required>
        </div>
        <div class="col-lg-2">
            <input type="number" class="form-control" name="variants[${index}][listed_price]" placeholder="Giá niêm yết" min="0" required>
        </div>
        <div class="col-lg-2">
            <input type="number" class="form-control" name="variants[${index}][sale_price]" placeholder="Giá khuyến mãi" min="0">
        </div>
        <div class="col-lg-2">
            <input type="number" class="form-control" name="variants[${index}][stock]" placeholder="Số lượng" min="0" required>
        </div>
        <div class="col-lg-2 mt-2">
            <input type="file" class="form-control" name="variants[${index}][variant_image]" accept="image/*">
        </div>
    </div>
`;

            $('#variant-container').append(variantHtml);
            index++;
        });
    </script>
@endsection
