@extends('dashboard.layouts.layout')

@section('main-content')
<div class="page-content">
    <div class="container-fluid">
        {{-- Tiêu đề và breadcrumb --}}
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Quản lý người dùng</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Bảng điều khiển</a></li>
                            <li class="breadcrumb-item active">Người dùng</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        {{-- Danh sách người dùng --}}
        <div class="row">
            <div class="col-lg-12">
                <div class="card" id="userList">
                    <div class="card-header border-0">
                        <div class="row g-4 align-items-center">
                            <div class="col-sm-3">
                                <div class="search-box">
                                    <input type="text" class="form-control search" placeholder="Tìm kiếm...">
                                    <i class="ri-search-line search-icon"></i>
                                </div>
                            </div>
                            <div class="col-sm-auto ms-auto">
                                <div class="hstack gap-2">
                                    <button class="btn btn-soft-danger" id="remove-actions"><i class="ri-delete-bin-2-line"></i></button>
                                    <button type="button" class="btn btn-success add-btn" data-bs-toggle="modal" data-bs-target="#showModal"><i class="ri-add-line align-bottom me-1"></i> Thêm người dùng</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Bảng danh sách --}}
                    <div class="card-body">
                        <div class="table-responsive table-card">
                            <table class="table align-middle" id="userTable">
                                <thead class="table-light">
                                    <tr>
                                        <th>Họ tên</th>
                                        <th>Email</th>
                                        <th>Điện thoại</th>
                                        <th>Địa chỉ</th>
                                        <th>Vai trò</th>
                                        <th>Hạng</th>
                                        <th>Điểm</th>
                                        <th>Đã chi tiêu</th>
                                        <th>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody class="list">
                                    @foreach ($users as $user)
                                        <tr>
                                            <td class="name">{{ $user->name }}</td>
                                            <td class="email">{{ $user->email }}</td>
                                            <td class="phone">{{ $user->default_phone ?? '-' }}</td>
                                            <td class="address">{{ $user->default_address ?? '-' }}</td>
                                            <td class="role">{{ $user->role }}</td>
                                            <td class="rank">{{ ucfirst($user->rank) }}</td>
                                            <td class="point">{{ $user->point }}</td>
                                            <td class="total_spent">{{ number_format($user->total_spent, 0, ',', '.') }} VNĐ</td>
                                            <td>
                                                <a href="{{ route('users.edit', $user->id) }}" class="text-info">Sửa</a> |
                                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline-block">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="btn btn-link text-danger p-0 m-0" onclick="return confirm('Bạn có chắc chắn muốn xoá?')">Xoá</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{-- Modal Thêm người dùng --}}
                        <div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header bg-light p-3">
                                        <h5 class="modal-title" id="exampleModalLabel">Thêm người dùng</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                                    </div>
                                    <form class="user-form" method="POST" action="{{ route('users.store') }}">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="row g-3">
                                                <div class="col-lg-12">
                                                    <label for="user-name" class="form-label">Họ tên</label>
                                                    <input type="text" id="user-name" name="name" class="form-control" required>
                                                </div>
                                                <div class="col-lg-12">
                                                    <label for="user-email" class="form-label">Email</label>
                                                    <input type="email" id="user-email" name="email" class="form-control" required>
                                                </div>
                                                <div class="col-lg-6">
                                                    <label for="user-password" class="form-label">Mật khẩu</label>
                                                    <input type="password" id="user-password" name="password" class="form-control" required>
                                                </div>
                                                <div class="col-lg-6">
                                                    <label for="user-password_confirmation" class="form-label">Xác nhận mật khẩu</label>
                                                    <input type="password" id="user-password_confirmation" name="password_confirmation" class="form-control" required>
                                                </div>
                                                <div class="col-lg-6">
                                                    <label for="user-phone" class="form-label">Số điện thoại</label>
                                                    <input type="text" id="user-phone" name="default_phone" class="form-control">
                                                </div>
                                                <div class="col-lg-6">
                                                    <label for="user-address" class="form-label">Địa chỉ</label>
                                                    <input type="text" id="user-address" name="default_address" class="form-control">
                                                </div>
                                                <div class="col-lg-6">
                                                    <label for="user-role" class="form-label">Vai trò</label>
                                                    <select id="user-role" name="role" class="form-control">
                                                        <option value="guest">Khách</option>
                                                        <option value="admin">Quản trị</option>
                                                    </select>
                                                </div>
                                                <div class="col-lg-6">
                                                    <label for="user-rank" class="form-label">Hạng</label>
                                                    <select id="user-rank" name="rank" class="form-control">
                                                        <option value="newbie">Newbie</option>
                                                        <option value="silver">Silver</option>
                                                        <option value="gold">Gold</option>
                                                        <option value="diamond">Diamond</option>
                                                    </select>
                                                </div>
                                                <div class="col-lg-6">
                                                    <label for="user-point" class="form-label">Điểm</label>
                                                    <input type="number" id="user-point" name="point" class="form-control">
                                                </div>
                                                <div class="col-lg-6">
                                                    <label for="user-total" class="form-label">Tổng chi tiêu</label>
                                                    <input type="number" step="0.01" id="user-total" name="total_spent" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Đóng</button>
                                            <button type="submit" class="btn btn-success">Lưu</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        {{-- Phân trang --}}
                        <div class="mt-3">
                            {{ $users->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js-content')
<!-- JS tuỳ chỉnh nếu cần -->
@endsection
