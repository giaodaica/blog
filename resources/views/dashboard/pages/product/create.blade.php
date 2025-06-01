@extends('dashboard.layouts.layout')

@section('main-content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- Page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Create Product</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript:void(0);">Ecommerce</a></li>
                                <li class="breadcrumb-item active">Create Product</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Form -->
            <form id="createproduct-form" autocomplete="off" class="needs-validation" novalidate method="POST"
                action="{{ route('products.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="row">

                    <!-- Left column: main info + variants -->
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-body">

                                {{-- Tên sản phẩm --}}
                                <div class="mb-3">
                                    <label class="form-label" for="product-name-input">Tên sản phẩm</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="product-name-input" name="name" value="{{ old('name') }}"
                                        placeholder="Nhập tên sản phẩm" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Mô tả sản phẩm --}}
                                <div class="mb-3">
                                    <label for="product-dsc-input" class="form-label">Mô tả sản phẩm</label>
                                    <textarea class="form-control @error('dsc') is-invalid @enderror" id="product-dsc-input" name="dsc" rows="6"
                                        placeholder="Nhập mô tả sản phẩm">{{ old('dsc') }}</textarea>
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
                                        $oldVariants = old('variants', []);
                                    @endphp

                                    @if (count($oldVariants) > 0)
                                        @foreach ($oldVariants as $i => $variant)
                                            <div class="variant-item border p-3 mb-3 position-relative">
                                                <button type="button"
                                                    class="btn btn-danger btn-sm position-absolute top-0 end-0 remove-variant-btn"
                                                    style="z-index:10;">Xóa</button>

                                                <div class="mb-2">
                                                    <label>SKU</label>
                                                    <input type="text" name="variants[{{ $i }}][sku]"
                                                        class="form-control" placeholder="Nhập SKU"
                                                        value="{{ $variant['sku'] ?? '' }}" required>
                                                </div>
                                                <div class="mb-2">
                                                    <label>Giá</label>
                                                    <input type="number" name="variants[{{ $i }}][price]"
                                                        class="form-control" placeholder="Nhập giá" step="0.01"
                                                        value="{{ $variant['price'] ?? '' }}" required>
                                                </div>
                                                <div class="mb-2">
                                                    <label>Số lượng</label>
                                                    <input type="number" name="variants[{{ $i }}][quantity]"
                                                        class="form-control" placeholder="Nhập số lượng"
                                                        value="{{ $variant['quantity'] ?? '' }}" required>
                                                </div>

                                                <div class="mb-2">
                                                    <label>Ảnh biến thể</label>
                                                    <input type="file" name="variants[{{ $i }}][image]"
                                                        class="form-control" accept="image/*">
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
                                                    <select name="variants[{{ $i }}][status]"
                                                        class="form-select">
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
                                                            <option value="{{ $value->id }}">{{ $value->value }}
                                                            </option>
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
                                        id="product-slug-input" name="slug" value="{{ old('slug') }}"
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
                                            id="product-discount-input" name="discount" value="{{ old('discount') }}"
                                            placeholder="Nhập phần trăm giảm giá" aria-label="Giảm giá"
                                            aria-describedby="product-discount-addon">
                                        @error('discount')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Ảnh đại diện --}}
                                <div class="mb-4">
                                    <h5 class="fs-14 mb-1">Ảnh đại diện</h5>
                                    <p class="text-muted">Thêm ảnh đại diện cho sản phẩm.</p>
                                    <div class="text-center">
                                        <div class="position-relative d-inline-block">
                                            <label for="product-image-input" class="mb-0" data-bs-toggle="tooltip"
                                                data-bs-placement="right" title="Chọn ảnh">
                                                <div class="avatar-xs">
                                                    <div
                                                        class="avatar-title bg-light border rounded-circle text-muted cursor-pointer">
                                                        <i class="ri-image-fill"></i>
                                                    </div>
                                                </div>
                                            </label>
                                            <input class="form-control d-none @error('main_image') is-invalid @enderror"
                                                id="product-image-input" name="main_image" type="file"
                                                accept="image/png, image/gif, image/jpeg">
                                            @error('main_image')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                            <div class="avatar-lg">
                                                <div class="avatar-title bg-light rounded">
                                                    <img src="{{ old('main_image_url') ?? '' }}" id="product-img"
                                                        class="avatar-md h-auto" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Thư viện ảnh sản phẩm --}}
                                <div>
                                    <h5 class="fs-14 mb-1">Thư viện ảnh sản phẩm</h5>
                                    <p class="text-muted">Thêm ảnh cho thư viện sản phẩm.</p>

                                    <div class="dropzone">
                                        <div class="fallback">
                                            <input name="gallery_images[]" type="file" multiple="multiple">
                                        </div>
                                        <div class="dz-message needsclick">
                                            <div class="mb-3">
                                                <i class="display-4 text-muted ri-upload-cloud-2-fill"></i>
                                            </div>
                                            <h5>Kéo thả hoặc nhấn để tải ảnh lên.</h5>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- Right column: categories, meta, status -->
                    <div class="col-lg-4">
                        {{-- Danh mục sản phẩm --}}
                        <div class="card mb-3">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Danh mục sản phẩm</h5>
                            </div>
                            <div class="card-body">
                                <p class="text-muted mb-2">
                                    <a href="#" class="float-end text-decoration-underline">Thêm mới</a>
                                    Chọn danh mục sản phẩm
                                </p>
                                <select class="form-select @error('category_id') is-invalid @enderror"
                                    id="choices-category-input" name="category_id" data-choices data-choices-search-false>
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
                        </div>

                        {{-- Meta dữ liệu --}}
                        <div class="card mb-3">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Meta dữ liệu</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="meta_title" class="form-label">Tiêu đề Meta</label>
                                    <input type="text" class="form-control @error('meta_title') is-invalid @enderror"
                                        id="meta_title" name="meta_title" value="{{ old('meta_title') }}"
                                        placeholder="Nhập tiêu đề Meta">
                                    @error('meta_title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="meta_keyword" class="form-label">Từ khóa Meta</label>
                                    <input type="text" class="form-control @error('meta_keyword') is-invalid @enderror"
                                        id="meta_keyword" name="meta_keyword" value="{{ old('meta_keyword') }}"
                                        placeholder="Nhập từ khóa Meta">
                                    @error('meta_keyword')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div>
                                    <label for="meta_dsc" class="form-label">Mô tả Meta</label>
                                    <textarea class="form-control @error('meta_dsc') is-invalid @enderror" id="meta_dsc" name="meta_dsc"
                                        placeholder="Nhập mô tả Meta" rows="3">{{ old('meta_dsc') }}</textarea>
                                    @error('meta_dsc')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Trạng thái xuất bản --}}
                        <div class="card mb-3">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Cài đặt xuất bản</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="choices-publish-status-input" class="form-label">Trạng thái</label>

                                    <select name="status" id="choices-publish-status-input"
                                        class="form-select w-100 @error('status') is-invalid @enderror" data-choices
                                        data-choices-search-false>
                                        <option value="" disabled {{ old('status') === null ? 'selected' : '' }}>
                                            -- Chọn trạng thái --
                                        </option>
                                        <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Ẩn</option>
                                        <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Hiện</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="d-flex justify-content-end mb-5">
                    <button type="submit" class="btn btn-primary">Lưu sản phẩm</button>
                </div>

            </form>
        </div>
    </div>

  <script>
    let variantIndex = {{ old('variants') ? count(old('variants')) : 1 }};

    document.getElementById('add-variant-btn').addEventListener('click', () => {
        const container = document.getElementById('variants-container');

        // Lấy variantAttributes dưới dạng JSON từ biến PHP, bạn cần xuất trong blade
        const variantAttributes = @json($variantAttributes);

        let attributesHtml = '';
        variantAttributes.forEach(attribute => {
            let optionsHtml = `<option value="">-- Chọn giá trị ${attribute.name} --</option>`;
            attribute.values.forEach(value => {
                optionsHtml += `<option value="${value.id}">${value.value}</option>`;
            });

            attributesHtml += `
                <div class="mb-2">
                    <label>${attribute.name}</label>
                    <select name="variants[${variantIndex}][attributes][${attribute.id}]" class="form-select" required>
                        ${optionsHtml}
                    </select>
                </div>
            `;
        });

        const variantHtml = `
            <div class="variant-item border p-3 mb-3 position-relative">
                <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 remove-variant-btn" style="z-index:10;">Xóa</button>

                <div class="mb-2">
                    <label>SKU</label>
                    <input type="text" name="variants[${variantIndex}][sku]" class="form-control" placeholder="Nhập SKU" required>
                </div>
                <div class="mb-2">
                    <label>Giá</label>
                    <input type="number" name="variants[${variantIndex}][price]" class="form-control" placeholder="Nhập giá" step="0.01" required>
                </div>
                <div class="mb-2">
                    <label>Số lượng</label>
                    <input type="number" name="variants[${variantIndex}][quantity]" class="form-control" placeholder="Nhập số lượng" required>
                </div>

                <div class="mb-2">
                    <label>Ảnh biến thể</label>
                    <input type="file" name="variants[${variantIndex}][image]" class="form-control" accept="image/*">
                </div>

                ${attributesHtml}

                <div class="mb-2">
                    <label>Trạng thái</label>
                    <select name="variants[${variantIndex}][status]" class="form-select">
                        <option value="1" selected>Hiện</option>
                        <option value="0">Ẩn</option>
                    </select>
                </div>
            </div>
        `;

        container.insertAdjacentHTML('beforeend', variantHtml);
        variantIndex++;

        // Gán lại event xóa
        container.querySelectorAll('.remove-variant-btn').forEach(btn => {
            btn.onclick = function() {
                this.closest('.variant-item').remove();
            }
        });
    });

    // Xử lý preview ảnh đại diện
    const mainImageInput = document.getElementById('product-image-input');
    const mainImagePreview = document.getElementById('product-img');

    mainImageInput.addEventListener('change', e => {
        if (e.target.files && e.target.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                mainImagePreview.src = e.target.result;
            };
            reader.readAsDataURL(e.target.files[0]);
        }
    });
</script>

@endsection
