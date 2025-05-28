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
