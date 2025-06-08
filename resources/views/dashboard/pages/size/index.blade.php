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

            <div class="row">
                <div class="col-lg-12">
                    <div class="card" id="categoryList">
                        <div class="card-header border-0">
                            <div class="row align-items-center gy-3">
                                <div class="col-sm"></div>
                                <div class="col-sm-auto">
                                    <div class="d-flex gap-1 flex-wrap">
                                        <a href="{{ route('sizes.create') }}" class="btn btn-success" id="addCategory-btn">
                                            <i class="ri-add-line align-bottom me-1"></i> Thêm kích thước
                                        </a>
                                        <button type="button" class="btn btn-info">
                                            <i class="ri-file-download-line align-bottom me-1"></i> Nhập dữ liệu
                                        </button>
                                        {{-- Nút xóa nhiều chưa có logic --}}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-body pt-0">
                            <div class="table-responsive table-card mb-1">
                                <table class="table table-nowrap align-middle" id="sizeTable">
                                    <thead class="text-muted table-light">
                                        <tr class="text-uppercase">
                                            <th scope="col" style="width: 25px;">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="checkAll"
                                                        value="option">
                                                </div>
                                            </th>
                                            <th class="sort" data-sort="id">Mã</th>
                                            <th class="sort" data-sort="size_name">Tên size</th>
                                            <th class="sort" data-sort="created_at">Ngày tạo</th>
                                            <th class="sort" data-sort="action">Hành động</th>
                                        </tr>
                                    </thead>

                                    <tbody class="list form-check-all">
                                        @forelse ($sizes as $size)
                                            <tr>
                                                <th scope="row">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="checkAll"
                                                            value="{{ $size->id }}">
                                                    </div>
                                                </th>
                                                <td class="id">
                                                    <a href="{{ route('sizes.show', $size->id) }}"
                                                        class="fw-medium link-primary">SIZE{{ $size->id }}</a>
                                                </td>
                                                <td class="size_name">{{ $size->size_name }}</td>
                                                <td class="created_at">{{ $size->created_at->format('d/m/Y') }}</td>
                                                <td>
                                                    <ul class="list-inline hstack gap-2 mb-0">
                                                        <li class="list-inline-item edit" data-bs-toggle="tooltip"
                                                            data-bs-trigger="hover" data-bs-placement="top"
                                                            title="Chỉnh sửa">
                                                            <a href="{{ route('sizes.edit', $size->id) }}"
                                                                class="text-primary d-inline-block">
                                                                <i class="ri-pencil-fill fs-16"></i>
                                                            </a>
                                                        </li>
                                                        <li class="list-inline-item" data-bs-toggle="tooltip"
                                                            data-bs-trigger="hover" data-bs-placement="top" title="Xóa">
                                                            <form action="{{ route('sizes.destroy', $size->id) }}"
                                                                method="POST"
                                                                onsubmit="return confirm('Bạn có chắc muốn xóa size này?');"
                                                                style="display:inline;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    class="btn btn-link p-0 text-danger d-inline-block remove-item-btn"
                                                                    style="border:none; background:none;">
                                                                    <i class="ri-delete-bin-5-fill fs-16"></i>
                                                                </button>
                                                            </form>
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center">
                                                    <div class="noresult text-center py-3">
                                                        <lord-icon src="https://cdn.lordicon.com/msoeawqm.json"
                                                            trigger="loop" colors="primary:#405189,secondary:#0ab39c"
                                                            style="width:75px;height:75px"></lord-icon>
                                                        <h5 class="mt-2">Rất tiếc! Không tìm thấy kết quả</h5>
                                                        <p class="text-muted">Chúng tôi đã tìm nhưng không thấy size nào phù
                                                            hợp.</p>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <!-- Phân trang -->
                            <div class="d-flex justify-content-end">
                                <div class="pagination-wrap hstack gap-2">
                                    {{ $sizes->links() }}
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
