@extends('dashboard.layouts.layout')

@section('main-content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- Page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Thêm sản phẩm</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript:void(0);">Ecommerce</a></li>
                                <li class="breadcrumb-item active">Thêm sản phẩm</li>
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

                    <!-- Left column: main info -->
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

                                {{-- Ảnh đại diện --}}
                                <div class="mb-3">
                                    <label for="product-image-input" class="form-label">Ảnh đại diện</label>
                                    <input type="file" class="form-control @error('image_url') is-invalid @enderror"
                                        id="product-image-input" name="image_url" accept="image/*" required>
                                    @error('image_url')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <img id="product-img" src="#" alt="Preview Image" class="mt-2"
                                        style="max-height: 150px; display:none;">
                                </div>
                                <div class="card mb-3">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Danh mục sản phẩm</h5>
                                    </div>
                                    <div class="card-body">
                                        
                                        <select class="form-select @error('category_id') is-invalid @enderror"
                                            id="choices-category-input" name="category_id" data-choices
                                            data-choices-search-false>
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


                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-start mb-5">
                        <button type="submit" class="btn btn-primary">Lưu sản phẩm</button>
                    </div>
                </div>



            </form>
        </div>
    </div>

    <script>
        // Xử lý preview ảnh đại diện
        const mainImageInput = document.getElementById('product-image-input');
        const mainImagePreview = document.getElementById('product-img');

        mainImageInput.addEventListener('change', e => {
            if (e.target.files && e.target.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    mainImagePreview.src = e.target.result;
                    mainImagePreview.style.display = 'block';
                };
                reader.readAsDataURL(e.target.files[0]);
            }
        });
    </script>
@endsection
