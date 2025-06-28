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
                        <label class="form-label">Địn sản phẩm</label>
                        <select class="form-select @error('product_id') is-invalid @enderror" name="product_id" required>
                            <option value="">-- Chọn sản phẩm --</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}"
                                    {{ old('product_id') == $product->id ? 'selected' : '' }}>
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
                                        <div class="col-lg-2 d-flex align-items-center">
                                            <select class="form-select color-select" name="variants[0][color_id]" required>
                                                <option value="" data-color="">Color</option>
                                                @foreach ($colors as $color)
                                                    <option value="{{ $color->id }}" data-color="{{ $color->color_code }}">
                                                        {{ $color->color_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="color-preview ms-2" style="width: 20px; height: 20px; border: 1px solid #ccc;"></div>
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

                                        <!-- Giá bán -->
                                        <div class="col-lg-2">
                                            <input type="number" class="form-control" name="variants[0][sale_price]"
                                                placeholder="Giá bán" min="0">
                                        </div>

                                        <!-- Số lượng -->
                                        <div class="col-lg-2">
                                            <input type="number" class="form-control" name="variants[0][stock]"
                                                placeholder="Số lượng" min="0" required>
                                        </div>

                                        <!-- Ảnh biến thể -->
                                        <div class="col-lg-2 mt-2">
                                            <input type="file" class="form-control variant-image-input"
                                                name="variants[0][variant_image]" accept="image/*">
                                            <img src="" class="img-preview mt-2"
                                                style="max-height: 100px; display: none;">
                                        </div>

                                        <div class="text-start">
                                            <button type="button"
                                                class="btn btn-danger btn-sm remove-variant mt-2">Xóa</button>
                                        </div>
                                    </div>
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
                        <button type="submit" class="btn btn-primary">THÊM MỘI</button>
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
            <div class="col-lg-2 d-flex align-items-center">
                <select class="form-select color-select" name="variants[${index}][color_id]" required>
                    <option value="" data-color="">Color</option>
                    @foreach ($colors as $color)
                        <option value="{{ $color->id }}" data-color="{{ $color->color_code }}">
                            {{ $color->color_name }}
                        </option>
                    @endforeach
                </select>
                <div class="color-preview ms-2" style="width: 20px; height: 20px; border: 1px solid #ccc;"></div>
            </div>
            <div class="col-lg-2">
                <input type="number" class="form-control" name="variants[${index}][import_price]" placeholder="Giá nhập" min="0" required>
            </div>
            <div class="col-lg-2">
                <input type="number" class="form-control" name="variants[${index}][listed_price]" placeholder="Giá niêm yết" min="0" required>
            </div>
            <div class="col-lg-2">
                <input type="number" class="form-control" name="variants[${index}][sale_price]" placeholder="Giá bán" min="0">
            </div>
            <div class="col-lg-2">
                <input type="number" class="form-control" name="variants[${index}][stock]" placeholder="Số lượng" min="0" required>
            </div>
            <div class="col-lg-2 mt-2">
                <input type="file" class="form-control variant-image-input" name="variants[${index}][variant_image]" accept="image/*">
                <img src="" class="img-preview mt-2" style="max-height: 100px; display: none;">
            </div>
            <div class="text-start">
                <button type="button" class="btn btn-danger btn-sm remove-variant mt-2">Xóa</button>
            </div>
        </div>
        `;

        $('#variant-container').append(variantHtml);
        index++;
    });

    $(document).on('click', '.remove-variant', function() {
        $(this).closest('.variant-item').remove();
    });

    $(document).on('change', '.variant-image-input', function(event) {
        let input = event.target;
        let preview = $(input).siblings('.img-preview')[0];

        if (input.files && input.files[0]) {
            let reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(input.files[0]);
        }
    });

    // Color preview logic
    $(document).on('change', '.color-select', function() {
        let selectedOption = $(this).find('option:selected');
        let colorCode = selectedOption.data('color');
        let previewBox = $(this).closest('.d-flex').find('.color-preview');

        if (colorCode) {
            previewBox.css('background-color', colorCode);
        } else {
            previewBox.css('background-color', 'transparent');
        }
    });
</script>
@endsection
