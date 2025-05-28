@extends('dashboard.layouts.layout')

@section('main-content')
    <div class="page-content">
        <div class="container-fluid">

            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Chỉnh sửa giá trị thuộc tính cho biến thể</h5>
                </div>
                <form action="{{ route('product_variant_attribute_values.update', $item->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <p class="text-muted">Use <code>js-example-basic-single</code> class to show Select2.</p>
                        <div class="row g-4">

                            <!-- Biến thể sản phẩm -->
                            <div class="col-lg-4">
                                <h6 class="fw-semibold">Biến thể sản phẩm</h6>
                                <select class="js-example-basic-single form-control" name="variant_id" required>
                                    <option value="">-- Chọn biến thể --</option>
                                    @foreach ($variants as $variant)
                                        <option value="{{ $variant->id }}"
                                            {{ $variant->id == $item->variant_id ? 'selected' : '' }}>
                                            {{ $variant->sku ?? 'Biến thể #' . $variant->id }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Thuộc tính -->
                            <div class="col-lg-4">
                                <h6 class="fw-semibold">Thuộc tính</h6>
                                <select class="form-control js-example-basic-multiple" id="attribute-selector"
                                    name="attribute_id" multiple required>
                                    @foreach ($attributes as $attribute)
                                        <option value="{{ $attribute->id }}"
                                            {{ in_array($attribute->id, is_array($item->attribute_id) ? $item->attribute_id : [$item->attribute_id]) ? 'selected' : '' }}>
                                            {{ $attribute->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Giá trị thuộc tính -->
                            <div class="col-lg-4">
                                <h6 class="fw-semibold">Giá trị thuộc tính</h6>
                                <select class="js-example-basic-single form-control" name="value_id" required>
                                    <option value="">-- Chọn giá trị --</option>
                                    @foreach ($values as $value)
                                        <option value="{{ $value->id }}"
                                            {{ $value->id == $item->value_id ? 'selected' : '' }}>
                                            {{ $value->value }}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                    </div>

                    <div class="card-footer text-end">
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
@endsection
