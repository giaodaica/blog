@extends('dashboard.layouts.layout')

@section('main-content')
    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <h4 class="mb-4">Chi tiết Giá trị Thuộc tính Biến thể</h4>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8">

                    {{-- Thông tin Biến thể sản phẩm --}}
                    <div class="card mb-3">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Thông tin Biến thể sản phẩm</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered mb-0">
                                <tbody>
                                    <tr>
                                        <th>ID</th>
                                        <td>{{ $item->variant->id ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>SKU</th>
                                        <td>{{ $item->variant->sku ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Giá</th>
                                        <td>{{ $item->variant->price ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Số lượng</th>
                                        <td>{{ $item->variant->quantity ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Trạng thái</th>
                                        <td>{{ $item->variant->status ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Ảnh</th>
                                        <td>
                                            @if (!empty($item->variant->image))
                                                <img src="{{ asset($item->variant->image) }}"
                                                    alt="Ảnh biến thể" style="max-width: 150px; height: auto;">
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- Thông tin Thuộc tính --}}
                    <div class="card mb-3">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Thông tin Thuộc tính</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered mb-0">
                                <tbody>
                                    <tr>
                                        <th>ID</th>
                                        <td>{{ $item->attribute->id ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Tên Thuộc tính</th>
                                        <td>{{ $item->attribute->name ?? 'N/A' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- Thông tin Giá trị Thuộc tính --}}
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Thông tin Giá trị Thuộc tính</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered mb-0">
                                <tbody>
                                    <tr>
                                        <th>ID</th>
                                        <td>{{ $item->value->id ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Giá trị</th>
                                        <td>{{ $item->value->value ?? 'N/A' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <a href="{{ route('product_variant_attribute_values.index') }}" class="btn btn-secondary mt-3">Quay
                        lại</a>
                </div>
            </div>

        </div>
    </div>
@endsection
