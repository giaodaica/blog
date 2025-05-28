@extends('dashboard.layouts.layout')

@section('main-content')
<div class="page-content">
    <div class="container-fluid">

        <!-- Tiêu đề -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Create Product</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="#">Ecommerce</a></li>
                            <li class="breadcrumb-item active">Create Product</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form tạo sản phẩm -->
        <form id="createproduct-form" class="needs-validation" method="POST"
              action="{{ route('variants.store', $product->id) }}" enctype="multipart/form-data" novalidate>
            @csrf

            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <div id="variants-container">
                                @php
                                    $oldVariants = old('variants', []);
                                    $variantCount = count($oldVariants) > 0 ? count($oldVariants) : 1;
                                @endphp

                                @for ($i = 0; $i < $variantCount; $i++)
                                    @php
                                        $variant = $oldVariants[$i] ?? null;
                                    @endphp

                                    <div class="variant-item border p-3 mb-3 position-relative">
                                        @if ($variantCount > 1 || $i > 0)
                                            <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 remove-variant-btn">Xóa</button>
                                        @endif

                                        <!-- SKU -->
                                        <div class="mb-2">
                                            <label>SKU</label>
                                            <input type="text" name="variants[{{ $i }}][sku]" class="form-control" value="{{ $variant['sku'] ?? '' }}" required>
                                        </div>

                                        <!-- Giá -->
                                        <div class="mb-2">
                                            <label>Giá</label>
                                            <input type="number" name="variants[{{ $i }}][price]" class="form-control" value="{{ $variant['price'] ?? '' }}" step="0.01" required>
                                        </div>

                                        <!-- Số lượng -->
                                        <div class="mb-2">
                                            <label>Số lượng</label>
                                            <input type="number" name="variants[{{ $i }}][quantity]" class="form-control" value="{{ $variant['quantity'] ?? '' }}" required>
                                        </div>

                                        <!-- Ảnh -->
                                        <div class="mb-2">
                                            <label>Ảnh biến thể</label>
                                            <input type="file" name="variants[{{ $i }}][image]" class="form-control" accept="image/*">
                                        </div>

                                        <!-- Thuộc tính -->
                                        {{-- @isset($variantAttributes)
                                            @foreach ($variantAttributes as $attribute)
                                                <div class="mb-2">
                                                    <label>{{ $attribute->name }}</label>
                                                    <select name="variants[{{ $i }}][attributes][{{ $attribute->id }}]" class="form-select" required>
                                                        <option value="">-- Chọn giá trị {{ $attribute->name }} --</option>
                                                        @foreach ($attribute->values as $value)
                                                            <option value="{{ $value->id }}"
                                                                @if(isset($variant['attributes'][$attribute->id]) && $variant['attributes'][$attribute->id] == $value->id) selected @endif>
                                                                {{ $value->value }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            @endforeach
                                        @endisset --}}

                                        <!-- Trạng thái -->
                                        <div class="mb-2">
                                            <label>Trạng thái</label>
                                            <select name="variants[{{ $i }}][status]" class="form-select">
                                                <option value="1" {{ ($variant['status'] ?? 1) == 1 ? 'selected' : '' }}>Hiện</option>
                                                <option value="0" {{ ($variant['status'] ?? 1) == 0 ? 'selected' : '' }}>Ẩn</option>
                                            </select>
                                        </div>
                                    </div>
                                @endfor
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Nút lưu -->
            <div class="d-flex justify-content-end mb-5">
                <button type="submit" class="btn btn-primary">Lưu sản phẩm</button>
            </div>
        </form>
    </div>
</div>
@endsection
