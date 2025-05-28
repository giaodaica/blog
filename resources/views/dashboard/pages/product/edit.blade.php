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

                <!-- Left column: main info -->
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
                                <textarea class="form-control @error('meta_dsc') is-invalid @enderror"
                                    id="meta-description-input" name="meta_dsc" rows="3"
                                    placeholder="Meta description">{{ old('meta_dsc', $product->meta_dsc) }}</textarea>
                                @error('meta_dsc')
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
@endsection
