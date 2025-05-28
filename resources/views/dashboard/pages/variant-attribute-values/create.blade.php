@extends('dashboard.layouts.layout')

@section('main-content')
<div class="page-content">
    <div class="container-fluid">

        <!-- Tiêu đề -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Tạo giá trị thuộc tính biến thể</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="#">Ecommerce</a></li>
                            <li class="breadcrumb-item active">Tạo giá trị thuộc tính</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form tạo giá trị thuộc tính -->
        <form id="create-attribute-value-form" class="needs-validation" method="POST"
              action="{{ route('variant-attributes-values.store') }}" novalidate>
            @csrf

            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <!-- Chọn thuộc tính cha -->
                            <div class="mb-3">
                                <label for="attribute_id" class="form-label">Thuộc tính</label>
                                <select id="attribute_id" name="attribute_id" class="form-select" required>
                                    <option value="">-- Chọn thuộc tính --</option>
                                    @foreach ($attributes as $attribute)
                                        <option value="{{ $attribute->id }}" {{ old('attribute_id') == $attribute->id ? 'selected' : '' }}>
                                            {{ $attribute->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('attribute_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Giá trị thuộc tính -->
                            <div class="mb-3">
                                <label for="value" class="form-label">Giá trị</label>
                                <input type="text" id="value" name="value" class="form-control" value="{{ old('value') }}" required>
                                @error('value')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Nút lưu -->
            <div class="d-flex justify-content-end mb-5">
                <button type="submit" class="btn btn-primary">Lưu giá trị thuộc tính</button>
            </div>
        </form>
    </div>
</div>
@endsection
