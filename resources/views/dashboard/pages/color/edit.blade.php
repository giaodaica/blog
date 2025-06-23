@extends('dashboard.layouts.layout')

@section('main-content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- Tiêu đề trang -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Chỉnh sửa màu</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="#">Ecommerce</a></li>
                                <li class="breadcrumb-item active">Chỉnh sửa màu</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Kết thúc tiêu đề -->

            <form action="{{ route('colors.update', $color->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-body">
                                {{-- Tên màu --}}
                                <div class="mb-3">
                                    <label for="color_name" class="form-label">Tên màu</label>
                                    <input type="text" id="color_name" name="color_name"
                                        class="form-control @error('color_name') is-invalid @enderror"
                                        value="{{ old('color_name', $color->color_name) }}" required>
                                    @error('color_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div>
                                    <label for="colorPicker" class="form-label">Chọn mã màu</label>
                                    <input type="color" name="color_code" class="form-control form-control-color w-25"
                                        id="colorPicker" value="{{$color->color_code}}">
                                </div>


                                <a href="{{ route('colors.index') }}" class="btn btn-secondary mt-3 w-100">Quay lại</a>
                                <button type="submit" class="btn btn-primary mt-2 w-100">Cập nhật</button>
                            </div>
                        </div>
                    </div>


                </div>
            </form>
        </div>
    </div>
@endsection
