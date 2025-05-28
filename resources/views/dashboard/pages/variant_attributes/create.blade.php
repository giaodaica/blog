@extends('dashboard.layouts.layout')

@section('main-content')
<div class="page-content">
    <div class="container-fluid">

        <!-- Tiêu đề -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Tạo thuộc tính biến thể</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="#">Ecommerce</a></li>
                            <li class="breadcrumb-item active">Tạo thuộc tính</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form tạo thuộc tính -->
        <form id="create-attribute-form" class="needs-validation" method="POST"
              action="{{ route('variant-attributes.store') }}" novalidate>
            @csrf

            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <!-- Tên thuộc tính -->
                            <div class="mb-3">
                                <label for="attribute-name" class="form-label">Tên thuộc tính</label>
                                <input type="text" id="attribute-name" name="name" class="form-control" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Nếu muốn nhập giá trị thuộc tính trực tiếp (tuỳ chọn) --}}
                            {{-- <div class="mb-3">
                                <label for="attribute-values" class="form-label">Giá trị (cách nhau bởi dấu phẩy)</label>
                                <input type="text" id="attribute-values" name="values" class="form-control" placeholder="Ví dụ: Đỏ, Xanh, Vàng">
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Nút lưu -->
            <div class="d-flex justify-content-end mb-5">
                <button type="submit" class="btn btn-primary">Lưu thuộc tính</button>
            </div>
        </form>
    </div>
</div>
@endsection
