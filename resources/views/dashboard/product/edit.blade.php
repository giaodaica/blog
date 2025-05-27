@extends('dashboard.layouts.layout')

@section('main-content')
<div class="page-content">
    <div class="container-fluid">

        <!-- Page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Edit Product</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Ecommerce</a></li>
                            <li class="breadcrumb-item active">Edit Product</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>

        <!-- Form -->
        <form id="editproduct-form" autocomplete="off" class="needs-validation" novalidate method="POST"
            action="{{ route('products.update', $product->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">

                <!-- Left column: main info + variants -->
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">

                            {{-- Tên sản phẩm --}}
                            <div class="mb-3">
                                <label class="form-label" for="product-name-input">Tên sản phẩm</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="product-name-input" name="name"
                                    value="{{ old('name', $product->name) }}" placeholder="Nhập tên sản phẩm" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Mô tả sản phẩm --}}
                            <div class="mb-3">
                                <label for="product-dsc-input" class="form-label">Mô tả sản phẩm</label>
                                <textarea class="form-control @error('dsc') is-invalid @enderror" id="product-dsc-input"
                                    name="dsc" rows="6"
                                    placeholder="Nhập mô tả sản phẩm">{{ old('dsc', $product->dsc) }}</textarea>
                                @error('dsc')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Nút thêm biến thể --}}
                <button type="button" class="btn btn-sm btn-primary mb-3" id="add-variant-btn">Thêm biến
                                    thể</button>

                            {{-- Container chứa biến thể --}}
                            <div id="variants-container">
                                @php
                                    $oldVariants = old('variants', $product->variants->toArray() ?? []);
                                @endphp

                                @if (count($oldVariants) > 0)
                                    @foreach ($oldVariants as $i => $variant)
                                        <div class="variant-item border p-3 mb-3 position-relative">
                                            <button type="button"
                                                class="btn btn-danger btn-sm position-absolute top-0 end-0 remove-variant-btn"
                                                style="z-index:10;">Xóa</button>

                                            <div class="mb-2">
                                                <label>SKU</label>
                                                <input type="text" name="variants[{{ $i }}][sku]" class="form-control"
                                                    placeholder="Nhập SKU" value="{{ $variant['sku'] ?? '' }}" required>
                                            </div>
                                            <div class="mb-2">
                                                <label>Giá</label>
                                                <input type="number" name="variants[{{ $i }}][price]" class="form-control"
                                                    placeholder="Nhập giá" step="0.01"
                                                    value="{{ $variant['price'] ?? '' }}" required>
                                            </div>
                                            <div class="mb-2">
                                                <label>Số lượng</label>
                                                <input type="number" name="variants[{{ $i }}][quantity]" class="form-control"
                                                    placeholder="Nhập số lượng"
                                                    value="{{ $variant['quantity'] ?? '' }}" required>
                                            </div>

                                            <div class="mb-2">
                                                <label>Ảnh biến thể</label>
                                                <input type="file" name="variants[{{ $i }}][image]" class="form-control"
                                                    accept="image/*">
                                                @if(!empty($variant['image_url'] ?? ''))
                                                    <img src="{{ $variant['image_url'] }}" alt="Ảnh biến thể"
                                                        style="max-height: 80px; margin-top: 5px;">
                                                @endif
                                            </div>

                                            {{-- Thuộc tính biến thể --}}
                                            @foreach ($variantAttributes as $attribute)
                                                <div class="mb-2">
                                                    <label>{{ $attribute->name }}</label>
                                                    <select
                                                        name="variants[{{ $i }}][attributes][{{ $attribute->id }}]"
                                                        class="form-select" required>
                                                        <option value="">-- Chọn giá trị {{ $attribute->name }}
                                                            --</option>
                                                        @foreach ($attribute->values as $value)
                                                            <option value="{{ $value->id }}"
                                                                {{ isset($variant['attributes'][$attribute->id]) && $variant['attributes'][$attribute->id] == $value->id ? 'selected' : '' }}>
                                                                {{ $value->value }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            @endforeach

                                            <div class="mb-2">
                                                <label>Trạng thái</label>
                                                <select name="variants[{{ $i }}][status]" class="form-select">
                                                    <option value="1"
                                                        {{ isset($variant['status']) && $variant['status'] == 1 ? 'selected' : '' }}>
                                                        Hiện</option>
                                                    <option value="0"
                                                        {{ isset($variant['status']) && $variant['status'] == 0 ? 'selected' : '' }}>
                                                        Ẩn</option>
                                                </select>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    {{-- Nếu không có biến thể nào thì hiện 1 biến thể trống --}}
                                    <div class="variant-item border p-3 mb-3 position-relative">
                                        <button type="button"
                                            class="btn btn-danger btn-sm position-absolute top-0 end-0 remove-variant-btn"
                                            style="z-index:10;">Xóa</button>

                                        <div class="mb-2">
                                            <label>SKU</label>
                                            <input type="text" name="variants[0][sku]" class="form-control"
                                                placeholder="Nhập SKU" required>
                                        </div>
                                        <div class="mb-2">
                                            <label>Giá</label>
                                            <input type="number" name="variants[0][price]" class="form-control"
                                                placeholder="Nhập giá" step="0.01" required>
                                        </div>
                                        <div class="mb-2">
                                            <label>Số lượng</label>
                                            <input type="number" name="variants[0][quantity]" class="form-control"
                                                placeholder="Nhập số lượng" required>
                                        </div>

                                        <div class="mb-2">
                                            <label>Ảnh biến thể</label>
                                            <input type="file" name="variants[0][image]" class="form-control"
                                                accept="image/*">
                                        </div>

                                        {{-- Thuộc tính biến thể --}}
                                        @foreach ($variantAttributes as $attribute)
                                            <div class="mb-2">
                                                <label>{{ $attribute->name }}</label>
                                                <select name="variants[0][attributes][{{ $attribute->id }}]"
                                                    class="form-select" required>
                                                    <option value="">-- Chọn giá trị {{ $attribute->name }} --
                                                    </option>
                                                    @foreach ($attribute->values as $value)
                                                        <option value="{{ $value->id }}">{{ $value->value }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        @endforeach

                                        <div class="mb-2">
                                            <label>Trạng thái</label>
                                            <select name="variants[0][status]" class="form-select">
                                                <option value="1" selected>Hiện</option>
                                                <option value="0">Ẩn</option>
                                            </select>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            {{-- Slug --}}
                            <div class="mb-3">
                                <label for="product-slug-input" class="form-label">Slug</label>
                                <input type="text" class="form-control @error('slug') is-invalid @enderror"
                                    id="product-slug-input" name="slug" value="{{ old('slug', $product->slug) }}"
                                    placeholder="Nhập slug" required>
                                @error('slug')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Giảm giá --}}
                            <div class="mb-3">
                                <label class="form-label" for="product-discount-input">Giảm giá (%)</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="product-discount-addon">%</span>
                                    <input type="number" min="0" max="100"
                                        class="form-control @error('discount') is-invalid @enderror"
                                        id="product-discount-input" name="discount"
                                        value="{{ old('discount', $product->discount) }}" placeholder="Nhập giảm giá">
                                    @error('discount')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Ảnh đại diện --}}
                            <div class="mb-3">
                                <label for="product-main-image-input" class="form-label">Ảnh đại diện</label>
                                <input class="form-control @error('main_image') is-invalid @enderror"
                                    type="file" id="product-main-image-input" name="main_image" accept="image/*">
                                @error('main_image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                <div class="mt-2">
                                    <img id="main-image-preview"
                                        src="{{ old('main_image_url', $product->main_image_url ?? '') }}"
                                        alt="Ảnh đại diện"
                                        style="max-height: 150px; object-fit: contain;">
                                </div>
                            </div>

                            {{-- Thư viện ảnh (chưa hiển thị ảnh hiện có) --}}
                            <div class="mb-3">
                                <label for="product-gallery-input" class="form-label">Thư viện ảnh</label>
                                <input class="form-control @error('gallery.*') is-invalid @enderror" type="file"
                                    id="product-gallery-input" name="gallery[]" accept="image/*" multiple>
                                @error('gallery.*')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Right column: categories + meta + status -->
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">

                            {{-- Danh mục --}}
                            <div class="mb-3">
                                <label for="category-select" class="form-label">Danh mục</label>
                                <select class="form-select @error('category_id') is-invalid @enderror"
                                    id="category-select" name="category_id" required>
                                    <option value="">Chọn danh mục</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Meta title --}}
                            <div class="mb-3">
                                <label for="meta-title-input" class="form-label">Meta Title</label>
                                <input type="text" class="form-control @error('meta_title') is-invalid @enderror"
                                    id="meta-title-input" name="meta_title"
                                    value="{{ old('meta_title', $product->meta_title) }}" placeholder="Meta title">
                                @error('meta_title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Meta description --}}
                            <div class="mb-3">
                                <label for="meta-description-input" class="form-label">Meta Description</label>
                                <textarea class="form-control @error('meta_description') is-invalid @enderror"
                                    id="meta-description-input" name="meta_description" rows="3"
                                    placeholder="Meta description">{{ old('meta_description', $product->meta_description) }}</textarea>
                                @error('meta_description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Trạng thái --}}
                            <div class="mb-3">
                                <label for="status-select" class="form-label">Trạng thái</label>
                                <select class="form-select @error('status') is-invalid @enderror" id="status-select"
                                    name="status" required>
                                    <option value="1" {{ old('status', $product->status) == 1 ? 'selected' : '' }}>
                                        Hiện</option>
                                    <option value="0" {{ old('status', $product->status) == 0 ? 'selected' : '' }}>
                                        Ẩn</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>
                    </div>

                    {{-- Submit --}}
                    <div class="d-grid mt-3">
                        <button type="submit" class="btn btn-primary btn-lg">Cập nhật</button>
                    </div>
                </div>
            </div>
        </form>

    </div>
</div>

{{-- Script --}}
{{-- @section('scripts')
<script>
    let variantIndex = {{ count(old('variants', $product->variants ?? [])) }};

    // Tạo HTML mẫu biến thể bằng Blade, lưu thành biến JS string
    const variantTemplate = `
        <div class="variant-item border p-3 mb-3 position-relative">
            <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 remove-variant-btn" style="z-index:10;">Xóa</button>
            <div class="mb-2">
                <label>SKU</label>
                <input type="text" name="variants[__INDEX__][sku]" class="form-control" placeholder="Nhập SKU" required>
            </div>
            <div class="mb-2">
                <label>Giá</label>
                <input type="number" name="variants[__INDEX__][price]" class="form-control" placeholder="Nhập giá" step="0.01" required>
            </div>
            <div class="mb-2">
                <label>Số lượng</label>
                <input type="number" name="variants[__INDEX__][quantity]" class="form-control" placeholder="Nhập số lượng" required>
            </div>
            <div class="mb-2">
                <label>Ảnh biến thể</label>
                <input type="file" name="variants[__INDEX__][image]" class="form-control" accept="image/*">
            </div>
            @foreach ($variantAttributes as $attribute)
                <div class="mb-2">
                    <label>{{ $attribute->name }}</label>
                    <select name="variants[__INDEX__][attributes][{{ $attribute->id }}]" class="form-select" required>
                        <option value="">-- Chọn giá trị {{ $attribute->name }} --</option>
                        @foreach ($attribute->values as $value)
                            <option value="{{ $value->id }}">{{ $value->value }}</option>
                        @endforeach
                    </select>
                </div>
            @endforeach
            <div class="mb-2">
                <label>Trạng thái</label>
                <select name="variants[__INDEX__][status]" class="form-select">
                    <option value="1" selected>Hiện</option>
                    <option value="0">Ẩn</option>
                </select>
            </div>
        </div>
    `;

    // Khi ấn nút thêm, thay __INDEX__ bằng biến variantIndex rồi append
    $('#add-variant-btn').click(function() {
        const newVariantHTML = variantTemplate.replace(/__INDEX__/g, variantIndex);
        $('#variants-container').append(newVariantHTML);
        variantIndex++;
    });

    // Xóa biến thể
    $(document).on('click', '.remove-variant-btn', function() {
        $(this).closest('.variant-item').remove();
    });
</script>
@endsection --}}

@endsection
