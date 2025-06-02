@extends('dashboard.layouts.layout')

@section('main-content')
<div class="page-content">
    <div class="container-fluid">

        <!-- Tiêu đề -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Create Variant for Product: {{ $product->name }}</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="#">Ecommerce</a></li>
                            <li class="breadcrumb-item active">Create Variant</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form tạo biến thể -->
        <form id="createvariant-form" class="needs-validation" method="POST"
              action="{{ route('variants.store', $product->id) }}" novalidate>
            @csrf

            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">

                            <!-- Tên biến thể -->
                            <div class="mb-2">
                                <label>Tên biến thể</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- SKU -->
                            <div class="mb-2">
                                <label>SKU</label>
                                <input type="text" name="sku" class="form-control" value="{{ old('sku') }}" required>
                                @error('sku')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Giá -->
                            <div class="mb-2">
                                <label>Giá</label>
                                <input type="number" name="price" class="form-control" value="{{ old('price') }}" step="0.01" required>
                                @error('price')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Số lượng -->
                            <div class="mb-2">
                                <label>Số lượng</label>
                                <input type="number" name="quantity" class="form-control" value="{{ old('quantity') }}" required>
                                @error('quantity')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Kích cỡ -->
                            <div class="mb-2">
                                <label>Kích cỡ</label>
                                <select name="size" class="form-select">
                                    <option value="">-- Chọn kích cỡ --</option>
                                    @foreach (['S', 'M', 'L', 'XL', 'XXL'] as $size)
                                        <option value="{{ $size }}" {{ old('size') == $size ? 'selected' : '' }}>{{ $size }}</option>
                                    @endforeach
                                </select>
                                @error('size')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Màu sắc -->
                            <div class="mb-2">
                                <label>Màu sắc</label>
                                <select name="color" class="form-select">
                                    <option value="">-- Chọn màu sắc --</option>
                                    @foreach (['red' => 'Đỏ', 'blue' => 'Xanh dương', 'green' => 'Xanh lá', 'black' => 'Đen', 'white' => 'Trắng'] as $value => $label)
                                        <option value="{{ $value }}" {{ old('color') == $value ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                                @error('color')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Trạng thái -->
                            <div class="mb-2">
                                <label>Trạng thái</label>
                                <select name="status" class="form-select">
                                    <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>Hiện</option>
                                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Ẩn</option>
                                </select>
                                @error('status')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
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
