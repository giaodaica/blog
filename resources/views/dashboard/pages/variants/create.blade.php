@extends('dashboard.layouts.layout')

@section('main-content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Tạo biến thể sản phẩm</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="#">Sản phẩm</a></li>
                                <li class="breadcrumb-item active">Biến thể</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <form action="{{ route('variants.store', ['productId' => $product->id]) }}" method="POST"
                enctype="multipart/form-data">
                @csrf

                <!-- Hiển thị lỗi chung -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="row g-4">
                    <!-- Sản phẩm đang chọn -->
                    <div class="col-lg-12">
                        <h6 class="fw-semibold">Sản phẩm</h6>
                        <input type="text" class="form-control" value="{{ $product->name }}" disabled>
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                    </div>

                    <!-- Multi select Size -->
                    <div class="col-lg-6">
                        <h6 class="fw-semibold">Chọn Size</h6>
                        <select class="js-example-basic-multiple form-select" name="size_ids[]" multiple>
                            @foreach ($sizes as $size)
                                <option value="{{ $size->id }}"
                                    {{ collect(old('size_ids'))->contains($size->id) ? 'selected' : '' }}>
                                    {{ $size->size_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('size_ids')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Multi select Color -->
                    <div class="col-lg-6">
                        <h6 class="fw-semibold">Chọn Màu</h6>
                        <select class="js-example-basic-multiple form-select" name="color_ids[]" multiple>
                            @foreach ($colors as $color)
                                <option value="{{ $color->id }}"
                                    {{ collect(old('color_ids'))->contains($color->id) ? 'selected' : '' }}>
                                    {{ $color->color_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('color_ids')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Các trường áp dụng chung cho mỗi biến thể -->
                    <div class="col-lg-4">
                        <h6 class="fw-semibold">Giá nhập</h6>
                        <input type="number" name="import_price" class="form-control" min="0"
                            value="{{ old('import_price') }}">
                        @error('import_price')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-lg-4">
                        <h6 class="fw-semibold">Giá niêm yết</h6>
                        <input type="number" name="listed_price" class="form-control" min="0"
                            value="{{ old('listed_price') }}">
                        @error('listed_price')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-lg-4">
                        <h6 class="fw-semibold">Giá bán</h6>
                        <input type="number" name="sale_price" class="form-control" min="0"
                            value="{{ old('sale_price') }}">
                        @error('sale_price')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-lg-4">
                        <h6 class="fw-semibold">Số lượng kho</h6>
                        <input type="number" name="stock" class="form-control" min="0"
                            value="{{ old('stock') }}">
                        @error('stock')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-lg-12">
                        <h6 class="fw-semibold">Ảnh biến thể theo Màu</h6>

                        @foreach ($colors as $color)
                            <div class="mb-3">
                                <label for="variant_images_{{ $color->id }}">
                                    Ảnh cho màu: {{ $color->color_name }}
                                </label>
                                <input type="file" name="variant_images[{{ $color->id }}]" class="form-control"
                                    accept="image/*" id="variant_images_{{ $color->id }}">
                                @error('variant_images.' . $color->id)
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        @endforeach
                    </div>


                    <div class="col-lg-12 mt-3">
                        <p class="text-muted fst-italic">(*) Mỗi tổ hợp màu + size sẽ tạo ra một biến thể tự động với tên
                            dạng: <strong>Tên sản phẩm + Màu + Size</strong></p>
                        <button type="submit" class="btn btn-primary">Tạo các biến thể</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
@endsection

@section('js-content')
    <script src="{{ asset('admin/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('admin/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('admin/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('admin/libs/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('admin/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>
    <script src="{{ asset('admin/js/plugins.js') }}"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('admin/js/pages/select2.init.js') }}"></script>
    <script src="{{ asset('admin/js/app.js') }}"></script>
@endsection
