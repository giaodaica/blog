@extends('dashboard.layouts.layout')

@section('main-content')
    <h2>Tạo vai trò</h2>
    <form method="POST" action="{{ route('roles.store') }}">
        @csrf
        <label>Tên vai trò:</label>
        <input type="text" name="name"><br><br>

        <label>Quyền:</label><br>
        @foreach ($permissions as $perm)
            <input type="checkbox" name="permissions[]" value="{{ $perm->name }}"> {{ $perm->name }} <br>
        @endforeach

        <br><button type="submit">Lưu</button>
    </form>
@endsection
