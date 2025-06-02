@extends('dashboard.layouts.layout')

@section('main-content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- Tiêu đề -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Thêm ảnh cho biến thể: {{ $variant->sku ?? 'Chưa có SKU' }}</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="#">Ecommerce</a></li>
                                <li class="breadcrumb-item active">Create Image</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form thêm ảnh cho biến thể -->
            <form id="createimage-form" method="POST" action="{{ route('image_product_variants.store', $variant->id) }}"
                enctype="multipart/form-data" novalidate>
                @csrf

                <div class="row">
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-body">

                                <label for="images" class="form-label">Thư viện ảnh (có thể chọn nhiều ảnh)</label>
                                <input type="file" name="images[]" id="images"
                                    class="form-control @error('images') is-invalid @enderror" accept="image/*" multiple>
                                @error('images')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror


                            </div>
                        </div>
                    </div>
                </div>

                <!-- Nút lưu -->
                <div class="d-flex justify-content-end mb-5">
                    <button type="submit" class="btn btn-primary">Lưu ảnh</button>
                </div>
            </form>
        </div>
    </div>
@endsection
