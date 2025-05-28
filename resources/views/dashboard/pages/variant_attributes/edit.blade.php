@extends('dashboard.layouts.layout')

@section('main-content')
<div class="page-content">
    <div class="container-fluid">

        <!-- Tiêu đề -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Chỉnh sửa thuộc tính biến thể</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="#">Sản phẩm</a></li>
                            <li class="breadcrumb-item active">Sửa thuộc tính</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form sửa thuộc tính -->
        <form method="POST" action="{{ route('variant-attributes.update', $attribute->id) }}" class="needs-validation" novalidate>
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">

                            <!-- Tên thuộc tính -->
                            <div class="mb-3">
                                <label for="name" class="form-label">Tên thuộc tính</label>
                                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $attribute->name) }}" required>
                            </div>

                            <!-- Ghi chú nếu cần -->
                            {{-- <div class="mb-3">
                                <label for="note">Ghi chú (nếu có)</label>
                                <textarea name="note" class="form-control" rows="3">{{ old('note', $attribute->note) }}</textarea>
                            </div> --}}

                        </div>
                    </div>
                </div>
            </div>

            <!-- Nút lưu -->
            <div class="d-flex justify-content-end mb-5">
                <button type="submit" class="btn btn-primary">Cập nhật thuộc tính</button>
            </div>
        </form>
    </div>
</div>
@endsection
