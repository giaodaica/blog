@extends('dashboard.layouts.layout')

@section('main-content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- Tiêu đề trang -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Danh mục</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript:void(0);">Thương mại điện tử</a></li>
                                <li class="breadcrumb-item active">Danh mục</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Kết thúc tiêu đề -->
     @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="row">
                <div class="col-lg-12">
                    <div class="card" id="categoryList">
                        <div class="card-header border-0">
                            <div class="row align-items-center gy-3">
                                <div class="col-sm"></div>
                                <div class="col-sm-auto">
                                    <div class="d-flex gap-1 flex-wrap">
                                        <a href="{{ route('categories.create') }}" class="btn btn-success"
                                            id="addCategory-btn">
                                            <i class="ri-add-line align-bottom me-1"></i> Thêm danh mục
                                        </a>
                                       
                                        {{-- Nút xóa nhiều chưa có logic --}}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-body pt-0">
                            <div class="table-responsive table-card mb-1">
                                <table class="table table-nowrap align-middle" id="categoryTable">
                                    <thead class="text-muted table-light">
                                        <tr class="text-uppercase">
                                            <th scope="col" style="width: 25px;">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="checkAll"
                                                        value="option">
                                                </div>
                                            </th>
                                            <th class="sort" data-sort="id">Mã</th>
                                            <th class="sort" data-sort="name">Tên danh mục</th>
                                            <th class="sort" data-sort="image">Ảnh</th>
                                            <th class="sort" data-sort="status">Trạng thái</th>
                                            <th class="sort" data-sort="action">Hành động</th>
                                        </tr>
                                    </thead>

                                    <tbody class="list form-check-all">
                                        @foreach ($categories as $category)
                                            <tr>
                                                <th scope="row">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="checkAll"
                                                            value="{{ $category->id }}">
                                                    </div>
                                                </th>
                                                <td class="id">
                                                    <a href="{{ route('categories.show', $category->id) }}"
                                                        class="fw-medium link-primary">CAT{{ $category->id }}</a>
                                                </td>
                                                <td class="name">{{ $category->name }}</td>
                                                <td class="image">
                                                    @if ($category->image)
                                                        <img src="{{ asset($category->image) }}" alt="{{ $category->name }}"
                                                            style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                                                    @else
                                                        <span class="text-muted">Không có ảnh</span>
                                                    @endif
                                                </td>
                                                <td class="status">
                                                    @if ($category->status == 1)
                                                        <span class="badge bg-success text-uppercase">Hoạt động</span>
                                                    @else
                                                        <span class="badge bg-warning text-uppercase">Không hoạt động</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <ul class="list-inline hstack gap-2 mb-0">
                                                        <li class="list-inline-item" data-bs-toggle="tooltip"
                                                            data-bs-trigger="hover" data-bs-placement="top" title="Xem">
                                                            <a href="{{ route('categories.show', $category->id) }}"
                                                                class="text-primary d-inline-block">
                                                                <i class="ri-eye-fill fs-16"></i>
                                                            </a>
                                                        </li>
                                                        <li class="list-inline-item edit" data-bs-toggle="tooltip"
                                                            data-bs-trigger="hover" data-bs-placement="top"
                                                            title="Chỉnh sửa">
                                                            <a href="{{ route('categories.edit', $category->id) }}"
                                                                class="text-primary d-inline-block">
                                                                <i class="ri-pencil-fill fs-16"></i>
                                                            </a>
                                                        </li>
                                                        <li class="list-inline-item" data-bs-toggle="tooltip"
                                                            data-bs-trigger="hover" data-bs-placement="top" title="Xóa">
                                                            <form action="{{ route('categories.destroy', $category->id) }}"
                                                                method="POST" class="delete-form">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    class="btn btn-link p-0 text-danger d-inline-block remove-item-btn"
                                                                    style="border:none; background:none;" >
                                                                    <i class="ri-delete-bin-5-fill fs-16"></i>
                                                                </button>
                                                            </form>
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                @if ($categories->isEmpty())
                                    <div class="noresult text-center">
                                        <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop"
                                            colors="primary:#405189,secondary:#0ab39c"
                                            style="width:75px;height:75px"></lord-icon>
                                        <h5 class="mt-2">Rất tiếc! Không tìm thấy kết quả</h5>
                                        <p class="text-muted">Chúng tôi đã tìm nhưng không thấy danh mục nào phù hợp.</p>
                                    </div>
                                @endif
                            </div>

                            <!-- Phân trang -->
                            <div class="d-flex justify-content-end">
                                <div class="pagination-wrap hstack gap-2">
                                    {{ $categories->links() }}
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <footer class="footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <script>
                        document.write(new Date().getFullYear())
                    </script> © Velzon.
                </div>
                <div class="col-sm-6">
                    <div class="text-sm-end d-none d-sm-block">
                        Thiết kế & phát triển bởi Themesbrand
                    </div>
                </div>
            </div>
        </div>
    </footer>
@endsection
@section('js-content')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteForms = document.querySelectorAll('.delete-form');

            deleteForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault(); // Chặn submit mặc định

                    Swal.fire({
                        title: 'Bạn có chắc chắn?',
                        text: "Hành động này sẽ không thể hoàn tác!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Xóa',
                        cancelButtonText: 'Hủy'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit(); // Chấp nhận xóa
                        }
                    });
                });
            });
        });
    </script>
@endsection
