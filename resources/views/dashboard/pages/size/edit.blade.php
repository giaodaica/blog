@extends('dashboard.layouts.layout')

@section('main-content')
<div class="page-content">
    <div class="container-fluid">
        <!-- Tiêu đề trang -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Chỉnh sửa size</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('sizes.index') }}">Size</a></li>
                            <li class="breadcrumb-item active">Chỉnh sửa size</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- Kết thúc tiêu đề -->

        <form action="{{ route('sizes.update', $size->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            {{-- Tên size --}}
                            <div class="mb-3">
                                <label for="size_name" class="form-label">Tên size</label>
                                <input type="text" id="size_name" name="size_name" 
                                       class="form-control @error('size_name') is-invalid @enderror" 
                                       value="{{ old('size_name', $size->size_name) }}" required>
                                @error('size_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <a href="{{ route('sizes.index') }}" class="btn btn-secondary mt-3 w-100">Quay lại</a>
                    <button type="submit" class="btn btn-primary mt-2 w-100">Cập nhật</button>

                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
