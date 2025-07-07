@extends('dashboard.layouts.layout')

@section('main-content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">Chỉnh sửa người dùng</h5>
                        </div>
                        <form action="{{ route('users.update', $user->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="card-body">
                                {{-- Hiển thị lỗi chung --}}
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <strong>Đã có lỗi xảy ra:</strong>
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                {{-- Họ tên --}}
                                <div class="mb-3">
                                    <label for="user-name" class="form-label">Họ tên</label>
                                    <input type="text" id="user-name" name="name"
                                           class="form-control @error('name') is-invalid @enderror"
                                           value="{{ old('name', $user->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Email --}}
                                <div class="mb-3">
                                    <label for="user-email" class="form-label">Email</label>
                                    <input type="email" id="user-email" name="email"
                                           class="form-control @error('email') is-invalid @enderror"
                                           value="{{ old('email', $user->email) }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Số điện thoại --}}
                                <div class="mb-3">
                                    <label for="user-phone" class="form-label">Số điện thoại</label>
                                    <input type="text" id="user-phone" name="default_phone"
                                           class="form-control @error('default_phone') is-invalid @enderror"
                                           value="{{ old('default_phone', $user->default_phone) }}">
                                    @error('default_phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Địa chỉ --}}
                                <div class="mb-3">
                                    <label for="user-address" class="form-label">Địa chỉ</label>
                                    <input type="text" id="user-address" name="default_address"
                                           class="form-control @error('default_address') is-invalid @enderror"
                                           value="{{ old('default_address', $user->default_address) }}">
                                    @error('default_address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Hidden fields --}}
                                <input type="hidden" name="role" value="{{ $user->role }}">
                                <input type="hidden" name="rank" value="">
                                <input type="hidden" name="point" value="">
                                <input type="hidden" name="total_spent" value="">
                            </div>

                            <div class="card-footer text-end">
                                <a href="{{ route('users.index') }}" class="btn btn-secondary">Quay lại</a>
                                <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
