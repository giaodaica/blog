@extends('dashboard.layouts.layout')

@section('main-content')

<div class="page-content">
    <div class="container-fluid">

        <!-- Tiêu đề trang -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Chi tiết danh mục</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Thương mại điện tử</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">Danh mục</a></li>
                            <li class="breadcrumb-item active">Chi tiết</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- Kết thúc tiêu đề -->

        <div class="row justify-content-left">
            <div class="col-lg-5">
                <div class="card">
                    <div class="card-body">

                        {{-- Ảnh danh mục --}}
                        <div class="mb-4">
                            <label class="form-label fw-semibold d-block text-start">
                                <i class="ri-image-line me-1 text-info"></i> Ảnh danh mục
                            </label>
                            <div class="text-start">
                                @if ($category->image)
                                    <img src="{{ asset($category->image) }}" alt="Ảnh danh mục" class="img-fluid rounded" style="max-height: 200px;">
                                @else
                                    <img src="https://via.placeholder.com/200x150?text=Không+có+ảnh" alt="Không có ảnh" class="img-fluid rounded">
                                @endif
                            </div>
                        </div>

                        {{-- Tên danh mục --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold d-block">
                                <i class="ri-price-tag-3-line me-1 text-primary"></i> Tên danh mục
                            </label>
                            <div class="text-muted fs-5">{{ $category->name }}</div>
                        </div>

                        {{-- Trạng thái --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold d-block">
                                <i class="ri-information-line me-1 text-warning"></i> Trạng thái
                            </label>
                            <div>
                                @if ($category->status == 1)
                                    <span class="badge bg-success text-uppercase"><i class="ri-checkbox-circle-line me-1"></i> Hiển thị</span>
                                @else
                                    <span class="badge bg-warning text-uppercase"><i class="ri-close-circle-line me-1"></i> Ẩn</span>
                                @endif
                            </div>
                        </div>

                        {{-- Nút quay lại --}}
                        <a href="{{ route('categories.index') }}" class="btn btn-secondary mt-3">
                            <i class="ri-arrow-left-line me-1 align-middle"></i> Quay lại
                        </a>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection
