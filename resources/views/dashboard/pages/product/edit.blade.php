@extends('dashboard.layouts.layout')

@section('main-content')
<div class="page-content">
    <div class="container-fluid">

        <!-- Page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Chỉnh sửa sản phẩm</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="#">Ecommerce</a></li>
                            <li class="breadcrumb-item active">Chỉnh sửa sản phẩm</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form -->
        <form method="POST" action="{{ route('products.update', $product->id) }}" enctype="multipart/form-data" class="needs-validation" novalidate>
            @csrf
            @method('PUT')

            <div class="row">

                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">

                            {{-- Tên sản phẩm --}}
                            <div class="mb-3">
                                <label class="form-label">Tên sản phẩm</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name', $product->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Slug --}}
                            <div class="mb-3">
                                <label class="form-label">Slug</label>
                                <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror"
                                    value="{{ old('slug', $product->slug) }}" required>
                                @error('slug')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Hình ảnh hiện tại --}}
                            @if ($product->image_url)
                                <div class="mb-3">
                                    <label class="form-label">Hình ảnh hiện tại:</label>
                                    <div>
                                        <img src="{{ asset($product->image_url) }}" alt="{{ $product->name }}" class="img-thumbnail" style="max-height: 300px;">
                                    </div>
                                </div>
                            @endif

                            {{-- Upload ảnh mới --}}
                            <div class="mb-3">
                                <label class="form-label">Tải ảnh mới (nếu muốn thay)</label>
                                <input type="file" name="image_url" class="form-control @error('image_url') is-invalid @enderror">
                                @error('image_url')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">

                            {{-- Danh mục --}}
                            <div class="mb-3">
                                <label class="form-label">Danh mục</label>
                                <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                                    <option value="">-- Chọn danh mục --</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Submit --}}
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Cập nhật sản phẩm</button>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </form>

    </div>
</div>
@endsection
