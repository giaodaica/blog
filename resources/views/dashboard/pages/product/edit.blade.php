@extends('dashboard.layouts.layout')

@section('main-content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- Page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Chỉnh sửa sản phẩm</h4>
                    </div>
                </div>
            </div>

            <!-- Form -->
            <form method="POST" action="{{ route('products.update', $product->id) }}" enctype="multipart/form-data"
                class="needs-validation" novalidate>
                @csrf
                @method('PUT')

                <div class="row">

                    <!-- Left column: Product Info -->
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">

                                <!-- Tên sản phẩm -->
                                <div class="mb-3">
                                    <label class="form-label">Tên sản phẩm</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="product-name" name="name" placeholder="Nhập tên sản phẩm"
                                        value="{{ old('name', $product->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Slug -->
                                <div class="mb-3">
                                    <label class="form-label">Slug</label>
                                    <input type="text" class="form-control @error('slug') is-invalid @enderror"
                                        id="product-slug" name="slug" placeholder="Slug sẽ được tự động tạo"
                                        value="{{ old('slug', $product->slug) }}" readonly required>
                                    @error('slug')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Mô tả -->
                                <div class="mb-3">
                                    <label class="form-label">Mô tả sản phẩm</label>
                                    <textarea id="description-editor" class="form-control @error('description') is-invalid @enderror" name="description"
                                        rows="3" placeholder="Nhập mô tả sản phẩm">{{ old('description', $product->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Danh mục -->
                                <div class="mb-3">
                                    <label class="form-label">Danh mục sản phẩm</label>
                                    <select class="form-select @error('category_id') is-invalid @enderror"
                                        name="category_id" required>
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

                                <!-- Ảnh hiện tại -->
                                <div id="product-image-preview" class="mb-3">
                                    @if ($product->image_url)
                                        <img src="{{ asset($product->image_url) }}" alt="{{ $product->name }}"
                                            class="img-thumbnail" style="max-height: 300px;">
                                    @endif
                                </div>

                                <!-- Tải ảnh mới -->
                                <div class="mb-3">
                                    <label class="form-label">Ảnh sản phẩm mới (nếu muốn thay)</label>
                                    <div class="input-group">
                                        <input type="file" class="form-control" id="product-image" name="image_url">
                                        <label class="input-group-text" for="product-image">Thêm ảnh</label>
                                    </div>
                                    @error('image_url')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Nút submit -->
                                <div class="d-flex justify-content-start mb-5">
                                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                                    <a href="{{ route('products.index') }}" class="btn btn-danger ms-2">Quay lại</a>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
@endsection

@section('js-content')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/35.3.2/classic/ckeditor.js"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#description-editor'))
            .catch(error => {
                console.error(error);
            });

        function removeVietnameseTones(str) {
            str = str.normalize('NFD').replace(/[\u0300-\u036f]/g, '');
            str = str.replace(/đ/g, 'd').replace(/Đ/g, 'D');
            return str;
        }

        // Tự động tạo slug khi nhập tên sản phẩm
        $(document).on('input', 'input[name="name"]', function() {
            let name = $(this).val();
            let slug = removeVietnameseTones(name).toLowerCase()
                .trim()
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/[\s-]+/g, '-')
                .replace(/^-+|-+$/g, '');

            $('input[name="slug"]').val(slug);
        });

        $(document).on('change', '#product-image', function() {
            let reader = new FileReader();
            reader.onload = function(e) {
                $('#product-image-preview').html(
                    `<img src="${e.target.result}" alt="Preview" class="img-thumbnail" style="max-height: 300px;">`
                    );
            }
            reader.readAsDataURL(this.files[0]);
        });
    </script>
@endsection
