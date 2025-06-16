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

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="row">

                    <!-- Left column: Product Info -->
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">

                                <!-- Tên sản phẩm -->
                                <div class="mb-3">
                                    <label class="form-label">Tên sản phẩm</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        name="name" placeholder="Nhập tên sản phẩm" value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Thương hiệu -->
                                <div class="mb-3">
                                    <label class="form-label">Slug</label>
                                    <input type="text" class="form-control @error('brand') is-invalid @enderror"
                                        name="brand" placeholder="Nhập thương hiệu" value="{{ old('brand') }}">
                                    @error('brand')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Mô tả -->
                                <div class="mb-3">
                                    <label class="form-label">Mô tả</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="4">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Danh mục -->
                                <div class="mb-3">
                                    <label class="form-label">Danh mục sản phẩm</label>
                                    <select class="form-select @error('category_id') is-invalid @enderror"
                                        name="category_id" required>
                                        <option value="">-- Chọn danh mục --</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Ảnh đại diện -->
                                <div class="mb-3">
                                    <label class="form-label">Hình ảnh</label>
                                    <input type="file" class="form-control @error('image_url') is-invalid @enderror"
                                        name="image_url" accept="image/*">
                                    @error('image_url')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
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
                                        <select class="form-select @error('variants.0.size_id') is-invalid @enderror"
                                            name="variants[0][size_id]" required>
                                            <option value="">Size</option>
                                            @foreach ($sizes as $size)
                                                <option value="{{ $size->id }}"
                                                    {{ old('variants.0.size_id') == $size->id ? 'selected' : '' }}>
                                                    {{ $size->size_name }}
                                                </option>
                                            @endforeach
                                        </select>

                                        <!-- Color -->
                                        <select class="form-select @error('variants.0.color_id') is-invalid @enderror"
                                            name="variants[0][color_id]" required>
                                            <option value="">Color</option>
                                            @foreach ($colors as $color)
                                                <option value="{{ $color->id }}"
                                                    {{ old('variants.0.color_id') == $color->id ? 'selected' : '' }}>
                                                    {{ $color->color_name }}
                                                </option>
                                            @endforeach
                                        </select>

                                        <!-- Giá nhập -->
                                        <div class="col-lg-2">
                                            <input type="number"
                                                class="form-control @error('variants.0.import_price') is-invalid @enderror"
                                                name="variants[0][import_price]"
                                                value="{{ old('variants.0.import_price') }}" placeholder="Giá nhập"
                                                required>
                                            @error('variants.0.import_price')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Giá niêm yết -->
                                        <div class="col-lg-2">
                                            <input type="number"
                                                class="form-control @error('variants.0.listed_price') is-invalid @enderror"
                                                name="variants[0][listed_price]" placeholder="Giá niêm yết" min="0"
                                                required>
                                            @error('variants.0.listed_price')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Giá khuyến mãi -->
                                        <div class="col-lg-2">
                                            <input type="number"
                                                class="form-control @error('variants.0.sale_price') is-invalid @enderror"
                                                name="variants[0][sale_price]" placeholder="Giá khuyến mãi" min="0">
                                            @error('variants.0.sale_price')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Số lượng -->
                                        <div class="col-lg-2">
                                            <input type="number"
                                                class="form-control @error('variants.0.stock') is-invalid @enderror"
                                                name="variants[0][stock]" placeholder="Số lượng" min="0" required>
                                            @error('variants.0.stock')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Ảnh biến thể -->
                                        <div class="col-lg-2 mt-2">
                                            <input type="file"
                                                class="form-control @error('variants.0.variant_image') is-invalid @enderror"
                                                name="variants[0][variant_image]" accept="image/*">
                                            @error('variants.0.variant_image')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                </div>
                                <p class="text-muted fst-italic">(*) Mỗi tổ hợp màu + size sẽ tạo ra một biến thể tự động
                                    với tên
                                    dạng: <strong>Tên sản phẩm + Màu + Size</strong></p>
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
