@extends('dashboard.layouts.layout')

@section('main-content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- Tiêu đề -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Edit Product Variant</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="#">Ecommerce</a></li>
                                <li class="breadcrumb-item active">Edit Product Variant</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form sửa biến thể sản phẩm -->
            <form id="editproduct-form" class="needs-validation" method="POST"
                action="{{ route('variants.update', $variant->id) }}" novalidate>
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-body" id="variants-container">

                                <div class="variant-item border p-3 mb-3 position-relative">
                                    <div class="mb-3">
                                        <label for="name-input" class="form-label">Tên biến thể</label>
                                        <input type="text" id="name-input" name="name"
                                            class="form-control @error('name') is-invalid @enderror"
                                            value="{{ old('name', $variant->name) }}" required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <!-- SKU -->
                                    <div class="mb-2">
                                        <label>SKU</label>
                                        <input type="text" name="sku" class="form-control"
                                            value="{{ old('sku', $variant->sku) }}" required>
                                    </div>

                                    <!-- Giá -->
                                    <div class="mb-2">
                                        <label>Giá</label>
                                        <input type="number" name="price" class="form-control"
                                            value="{{ old('price', $variant->price) }}" step="0.01" required>
                                    </div>

                                    <!-- Số lượng -->
                                    <div class="mb-2">
                                        <label>Số lượng</label>
                                        <input type="number" name="quantity" class="form-control"
                                            value="{{ old('quantity', $variant->quantity) }}" required>
                                    </div>

                                    <!-- Trạng thái -->
                                    <div class="mb-2">
                                        <label>Trạng thái</label>
                                        <select name="status" class="form-select">
                                            <option value="active"
                                                {{ old('status', $variant->status) == 'active' ? 'selected' : '' }}>Hiện
                                            </option>
                                            <option value="inactive"
                                                {{ old('status', $variant->status) == 'inactive' ? 'selected' : '' }}>Ẩn
                                            </option>
                                        </select>
                                    </div>

                                    <!-- Size -->
                                    <div class="mb-2">
                                        <label>Size</label>
                                        <select name="size" class="form-select">
                                            <option value="">-- Chọn size --</option>
                                            @foreach (['S', 'M', 'L', 'XL', 'XXL'] as $size)
                                                <option value="{{ $size }}"
                                                    {{ old('size', $variant->size) == $size ? 'selected' : '' }}>
                                                    {{ $size }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Color -->
                                    <div class="mb-2">
                                        <label>Màu sắc</label>
                                        <select name="color" class="form-select">
                                            <option value="">-- Chọn màu --</option>
                                            @foreach (['red', 'blue', 'green', 'black', 'white'] as $color)
                                                <option value="{{ $color }}"
                                                    {{ old('color', $variant->color) == $color ? 'selected' : '' }}>
                                                    {{ ucfirst($color) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <!-- Nút lưu -->
                <div class="d-flex justify-content-end mb-5">
                    <button type="submit" class="btn btn-primary">Lưu biến thể</button>
                </div>
            </form>
        </div>
    </div>
@endsection
