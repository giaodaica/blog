@extends('dashboard.layouts.layout')

@section('main-content')
    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Thêm biến thể sản phẩm</h4>
                    </div>
                </div>
            </div>

            <form id="createvariant-form" autocomplete="off" class="needs-validation" novalidate method="POST"
                action="{{ route('variants.store') }}" enctype="multipart/form-data">
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

                    <!-- Chọn sản phẩm -->
                    <div class="col-lg-12 mb-3">
                        <label class="form-label">Chọn sản phẩm</label>
                        <select class="form-select @error('product_id') is-invalid @enderror" name="product_id" required>
                            <option value="">-- Chọn sản phẩm --</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                    {{ $product->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('product_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Biến thể -->
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Sản phẩm biến thể</h5>
                            </div>
                            <div class="card-body">

                                <div id="variant-container">
                                    @if (old('variants'))
                                        @foreach (old('variants') as $index => $oldVariant)
                                            <div class="row variant-item mb-3">
                                                <!-- Size -->
                                                <div class="col-lg-2">
                                                    <select class="form-select @error('variants.' . $index . '.size_id') is-invalid @enderror" name="variants[{{ $index }}][size_id]" required>
                                                        <option value="">Size</option>
                                                        @foreach ($sizes as $size)
                                                            <option value="{{ $size->id }}" {{ old('variants.' . $index . '.size_id') == $size->id ? 'selected' : '' }}>
                                                                {{ $size->size_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('variants.' . $index . '.size_id')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <!-- Color -->
                                                <div class="col-lg-2">
                                                    <select class="form-select @error('variants.' . $index . '.color_id') is-invalid @enderror" name="variants[{{ $index }}][color_id]" required>
                                                        <option value="">Color</option>
                                                        @foreach ($colors as $color)
                                                            <option value="{{ $color->id }}" {{ old('variants.' . $index . '.color_id') == $color->id ? 'selected' : '' }}>
                                                                {{ $color->color_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('variants.' . $index . '.color_id')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <!-- Giá nhập -->
                                                <div class="col-lg-2">
                                                    <input type="number" class="form-control @error('variants.' . $index . '.import_price') is-invalid @enderror" name="variants[{{ $index }}][import_price]" placeholder="Giá nhập" min="0" value="{{ old('variants.' . $index . '.import_price') }}" required>
                                                    @error('variants.' . $index . '.import_price')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <!-- Giá niêm yết -->
                                                <div class="col-lg-2">
                                                    <input type="number" class="form-control @error('variants.' . $index . '.listed_price') is-invalid @enderror" name="variants[{{ $index }}][listed_price]" placeholder="Giá niêm yết" min="0" value="{{ old('variants.' . $index . '.listed_price') }}" required>
                                                    @error('variants.' . $index . '.listed_price')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <!-- Giá khuyến mãi -->
                                                <div class="col-lg-2">
                                                    <input type="number" class="form-control @error('variants.' . $index . '.sale_price') is-invalid @enderror" name="variants[{{ $index }}][sale_price]" placeholder="Giá khuyến mãi" min="0" value="{{ old('variants.' . $index . '.sale_price') }}">
                                                    @error('variants.' . $index . '.sale_price')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <!-- Số lượng -->
                                                <div class="col-lg-2">
                                                    <input type="number" class="form-control @error('variants.' . $index . '.stock') is-invalid @enderror" name="variants[{{ $index }}][stock]" placeholder="Số lượng" min="0" value="{{ old('variants.' . $index . '.stock') }}" required>
                                                    @error('variants.' . $index . '.stock')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <!-- Ảnh biến thể -->
                                                <div class="col-lg-2 mt-2">
                                                    <input type="file" class="form-control @error('variants.' . $index . '.variant_image') is-invalid @enderror" name="variants[{{ $index }}][variant_image]" accept="image/*">
                                                    @error('variants.' . $index . '.variant_image')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
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
                                                <input type="number" class="form-control" name="variants[0][import_price]" placeholder="Giá nhập" min="0" required>
                                            </div>

                                            <!-- Giá niêm yết -->
                                            <div class="col-lg-2">
                                                <input type="number" class="form-control" name="variants[0][listed_price]" placeholder="Giá niêm yết" min="0" required>
                                            </div>

                                            <!-- Giá khuyến mãi -->
                                            <div class="col-lg-2">
                                                <input type="number" class="form-control" name="variants[0][sale_price]" placeholder="Giá khuyến mãi" min="0">
                                            </div>

                                            <!-- Số lượng -->
                                            <div class="col-lg-2">
                                                <input type="number" class="form-control" name="variants[0][stock]" placeholder="Số lượng" min="0" required>
                                            </div>

                                            <!-- Ảnh biến thể -->
                                            <div class="col-lg-2 mt-2">
                                                <input type="file" class="form-control" name="variants[0][variant_image]" accept="image/*">
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <p class="text-muted fst-italic">(*) Mỗi tổ hợp màu + size sẽ tạo ra một biến thể tự động với tên: <strong>Tên sản phẩm + Màu + Size</strong></p>
                                <div class="text-center">
                                    <button type="button" id="add-variant" class="btn btn-success btn-sm">+ Thêm biến thể</button>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- Nút submit -->
                    <div class="d-flex justify-content-start mb-5">
                        <button type="submit" class="btn btn-primary">THÊM MỚI</button>
                        <a href="{{ route('variants.index') }}" class="btn btn-danger ms-2">QUAY LẠI</a>
                    </div>

                </div>
            </form>
        </div>
    </div>
@endsection

@section('js-content')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        let index = {{ old('variants') ? count(old('variants')) : 1 }};

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
