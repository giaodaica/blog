@extends('layouts.layout')
@section('content')
    <!-- start section -->
    <section class="top-space-margin half-section bg-gradient-very-light-gray">
        <div class="container">
            <div class="row align-items-center justify-content-center" data-anime='{ "el": "childs", "translateY": [-15, 0], "opacity": [0,1], "duration": 300, "delay": 0, "staggervalue": 200, "easing": "easeOutQuad" }'>
                <div class="col-12 col-xl-8 col-lg-10 text-center position-relative page-title-extra-large">
                    <h1 class="alt-font fw-600 text-dark-gray mb-10px">Quản lý địa chỉ giao hàng</h1>
                </div>
                <div class="col-12 breadcrumb breadcrumb-style-01 d-flex justify-content-center">
                    <ul>
                        <li><a href="{{ route('home') }}">Trang chủ</a></li>
                        <li>Địa chỉ giao hàng</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!-- end section -->

    <!-- start section -->
    <section class="pt-0">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Danh sách địa chỉ -->
                    <div class="mb-5">
                        <h3 class="alt-font fw-600 text-dark-gray mb-4">Địa chỉ của bạn</h3>
                        
                        @if($addresses->count() > 0)
                            <div class="row">
                                @foreach($addresses as $address)
                                    <div class="col-md-6 mb-4">
                                        <div class="card border h-100">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between align-items-start mb-3">
                                                    <h6 class="card-title mb-0 fw-600">{{ $address->name }}</h6>
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                            <i class="fas fa-ellipsis-v"></i>
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li><a class="dropdown-item" href="#" onclick="editAddress({{ $address->id }}, '{{ $address->name }}', '{{ $address->address }}', '{{ $address->phone }}')">
                                                                <i class="fas fa-edit me-2"></i>Sửa
                                                            </a></li>
                                                            <li><hr class="dropdown-divider"></li>
                                                            <li><a class="dropdown-item text-danger" href="#" onclick="deleteAddress({{ $address->id }})">
                                                                <i class="fas fa-trash me-2"></i>Xóa
                                                            </a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <p class="card-text mb-2">
                                                    <i class="fas fa-map-marker-alt me-2 text-muted"></i>
                                                    {{ $address->address }}
                                                </p>
                                                <p class="card-text mb-0">
                                                    <i class="fas fa-phone me-2 text-muted"></i>
                                                    {{ $address->phone }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-map-marker-alt fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">Bạn chưa có địa chỉ giao hàng nào</h5>
                                <p class="text-muted">Thêm địa chỉ để có thể đặt hàng dễ dàng hơn</p>
                            </div>
                        @endif
                    </div>

                    <!-- Form thêm/sửa địa chỉ -->
                    <div class="card border">
                        <div class="card-header bg-light">
                            <h5 class="mb-0 fw-600" id="formTitle">Thêm địa chỉ mới</h5>
                        </div>
                        <div class="card-body">
                            <form id="addressForm" action="{{ route('addresses.store') }}" method="POST">
                                @csrf
                                <input type="hidden" id="addressId" name="address_id">
                                <input type="hidden" id="isEdit" name="_method" value="POST">
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="name" class="form-label">Tên người nhận <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="name" name="name" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="phone" class="form-label">Số điện thoại <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="phone" name="phone" required>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="address" class="form-label">Địa chỉ giao hàng <span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
                                </div>
                                
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-dark-gray" id="submitBtn">
                                        <i class="fas fa-plus me-1"></i>Thêm địa chỉ
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary" onclick="resetForm()" id="cancelBtn" style="display: none;">
                                        Hủy
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <a href="{{ route('home.checkout') }}" class="btn btn-outline-dark-gray">
                            <i class="fas fa-arrow-left me-1"></i>Quay lại thanh toán
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end section -->

    <script>
        function editAddress(id, name, address, phone) {
            document.getElementById('formTitle').textContent = 'Sửa địa chỉ';
            document.getElementById('addressId').value = id;
            document.getElementById('name').value = name;
            document.getElementById('address').value = address;
            document.getElementById('phone').value = phone;
            document.getElementById('isEdit').value = 'PUT';
            document.getElementById('addressForm').action = `/addresses/${id}`;
            document.getElementById('submitBtn').innerHTML = '<i class="fas fa-save me-1"></i>Cập nhật';
            document.getElementById('cancelBtn').style.display = 'inline-block';
        }

        function resetForm() {
            document.getElementById('formTitle').textContent = 'Thêm địa chỉ mới';
            document.getElementById('addressId').value = '';
            document.getElementById('name').value = '';
            document.getElementById('address').value = '';
            document.getElementById('phone').value = '';
            document.getElementById('isEdit').value = 'POST';
            document.getElementById('addressForm').action = '{{ route("addresses.store") }}';
            document.getElementById('submitBtn').innerHTML = '<i class="fas fa-plus me-1"></i>Thêm địa chỉ';
            document.getElementById('cancelBtn').style.display = 'none';
        }

        function deleteAddress(id) {
            if (confirm('Bạn có chắc chắn muốn xóa địa chỉ này?')) {
                fetch(`/addresses/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    }
                }).then(response => {
                    if (response.ok) {
                        location.reload();
                    } else {
                        alert('Có lỗi xảy ra khi xóa địa chỉ');
                    }
                });
            }
        }
    </script>
@endsection 