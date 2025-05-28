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
              action="{{ route('variants.update', ['productId' => $variant->product_id, 'variantId' => $variant->id]) }}" enctype="multipart/form-data" novalidate>
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body" id="variants-container">

                            <div class="variant-item border p-3 mb-3 position-relative">
                                <!-- SKU -->
                                <div class="mb-2">
                                    <label>SKU</label>
                                    <input type="text" name="sku" class="form-control" value="{{ old('sku', $variant->sku) }}" required>
                                </div>

                                <!-- Giá -->
                                <div class="mb-2">
                                    <label>Giá</label>
                                    <input type="number" name="price" class="form-control" value="{{ old('price', $variant->price) }}" step="0.01" required>
                                </div>

                                <!-- Số lượng -->
                                <div class="mb-2">
                                    <label>Số lượng</label>
                                    <input type="number" name="quantity" class="form-control" value="{{ old('quantity', $variant->quantity) }}" required>
                                </div>

                                <!-- Ảnh -->
                                <div class="mb-2">
                                    <label>Ảnh biến thể</label>
                                    <input type="file" name="image" class="form-control" accept="image/*">
                                    @if ($variant->image)
                                        <img src="{{ asset($variant->image) }}" alt="Ảnh biến thể" style="max-width: 150px; margin-top: 10px;">
                                    @endif
                                </div>

                                <!-- Thuộc tính -->
                                {{-- Nếu cần show thuộc tính, bạn có thể giải mở phần comment ở đây để hiển thị --}}

                                <!-- Trạng thái -->
                                <div class="mb-2">
                                    <label>Trạng thái</label>
                                    <select name="status" class="form-select">
                                        <option value="1" {{ old('status', $variant->status) == 1 ? 'selected' : '' }}>Hiện</option>
                                        <option value="0" {{ old('status', $variant->status) == 0 ? 'selected' : '' }}>Ẩn</option>
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
