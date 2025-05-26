@extends('dashboard.layouts.layout')

@section('main-content')
<div class="page-content">
    <div class="container-fluid">
        <!-- Tiêu đề trang -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Chỉnh sửa danh mục</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="#">Ecommerce</a></li>
                            <li class="breadcrumb-item active">Chỉnh sửa danh mục</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- Kết thúc tiêu đề -->

        <form action="{{ route('categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            {{-- Tên danh mục --}}
                            <div class="mb-3">
                                <label for="name" class="form-label">Tên danh mục</label>
                                <input type="text" id="name" name="name" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       value="{{ old('name', $category->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Trạng thái --}}
                            <div class="mb-3">
                                <label for="status" class="form-label">Trạng thái</label>
                                <select id="status" name="status" 
                                        class="form-select @error('status') is-invalid @enderror" required>
                                    <option value="0" {{ (old('status', $category->status) == 0) ? 'selected' : '' }}>Không hoạt động</option>
                                    <option value="1" {{ (old('status', $category->status) == 1) ? 'selected' : '' }}>Hoạt động</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Ảnh mới --}}
                            <div class="mb-3">
                                <label for="image" class="form-label">Thay đổi ảnh</label>
                                <input type="file" id="image" name="image" class="form-control @error('image') is-invalid @enderror">
                                <small class="text-muted">Nếu không muốn thay đổi ảnh, bạn có thể bỏ qua</small>
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <!-- Ảnh danh mục hiện tại -->
                    <div class="card">
                        <div class="card-body text-center">
                            <label class="form-label">Ảnh danh mục hiện tại</label>
                            <div>
                                @if ($category->image)
                                    <img src="{{ asset($category->image) }}" alt="{{ $category->name }}" class="img-fluid rounded" style="max-height: 150px; object-fit: cover;">
                                @else
                                    <img src="https://via.placeholder.com/150?text=No+Image" alt="Không có ảnh" class="img-fluid rounded">
                                @endif
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('categories.index') }}" class="btn btn-secondary mt-3 w-100">Quay lại</a>
                    <button type="submit" class="btn btn-primary mt-2 w-100">Cập nhật</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
