@extends('dashboard.layouts.layout')

@section('main-content')
    <div class="page-content container-fluid">
        <h4>Chi tiết người dùng</h4>
        <table class="table table-bordered">
            <tr>
                <th>Họ tên</th>
                <td>{{ $user->name }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{ $user->email }}</td>
            </tr>
            <tr>
                <th>Điện thoại</th>
                <td>{{ $user->default_phone ?? '-' }}</td>
            </tr>
            <tr>
                <th>Địa chỉ</th>
                <td>{{ $user->default_address ?? '-' }}</td>
            </tr>
            <tr>
                <th>Vai trò</th>
                <td class="role">
                    @if ($user->role === 'admin')
                        Quản trị
                    @else
                        Khách hàng
                    @endif
                </td>
            </tr>
            @if ($user->role !== 'admin')
                <tr>
                    <th>Hạng</th>
                    <td>{{ ucfirst($user->rank) }}</td>
                </tr>
                <tr>
                    <th>Điểm</th>
                    <td>{{ $user->point }}</td>
                </tr>
                <tr>
                    <th>Đã chi tiêu</th>
                    <td>{{ number_format($user->total_spent, 0, ',', '.') }} VNĐ</td>
                </tr>
            @endif
        </table>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">Quay lại danh sách</a>
    </div>
@endsection
