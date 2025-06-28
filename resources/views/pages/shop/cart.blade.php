@extends('layouts.layout')
@section('content')
    <!-- start section -->
    <section class="top-space-margin half-section bg-gradient-very-light-gray">
        <div class="container">
            <div class="row align-items-center justify-content-center"
                data-anime='{ "el": "childs", "translateY": [-15, 0], "opacity": [0,1], "duration": 300, "delay": 0, "staggervalue": 200, "easing": "easeOutQuad" }'>
                <div class="col-12 col-xl-8 col-lg-10 text-center position-relative page-title-extra-large">
                    <h1 class="alt-font fw-600 text-dark-gray mb-10px">Giỏ Hàng</h1>
                </div>
                <div class="col-12 breadcrumb breadcrumb-style-01 d-flex justify-content-center">
                    <ul>
                        <li><a href="demo-fashion-store.html">Trang chủ</a></li>
                        <li>Giỏ Hàng</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!-- end section -->
    <!-- start section -->
    <section class="pt-0">
        <div class="container">
             @if (session('success'))
                <div class="d-none toast-message" data-message="{{ session('success') }}" data-type="success"></div>
            @endif
            @if (session('error'))
                <div class="d-none toast-message" data-message="{{ session('error') }}" data-type="danger"></div>
            
            @endif
              @if (session('info'))
                <div class="d-none toast-message" data-message="{{ session('info') }}" data-type="info"></div>
            @endif
            <div id="toast-container" class="position-fixed bottom-0 end-0 p-3" style="z-index: 9999;"></div>

            <div class="row align-items-start">
                <div class="col-lg-8 pe-50px md-pe-15px md-mb-50px xs-mb-35px">
                    <div class="row align-items-center">
                        <div class="col-12">
                            <table class="table cart-products">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-center">
                                            <input type="checkbox" id="select-all-cart">
                                        </th>
                                        <th scope="col" class="alt-font fw-600">Sản phẩm</th>
                                        <th scope="col"></th>
                                        <th scope="col" class="alt-font fw-600">Giá</th>
                                        <th scope="col" class="alt-font fw-600">Số lượng</th>
                                        <th scope="col" class="alt-font fw-600">Tổng tiền</th>
                                    </tr>
                                </thead>
                                <tbody>
                                     @foreach($cartItems as $item)
                                        <tr>
                                            <td class="product-remove">
                                               <input type="checkbox" class="cart-item-checkbox" value="{{ $item->id }}">

                                            </td>
                                           <td class="product-thumbnail">
                                                <a href="demo-jewellery-store-single-product.html">
                                                    <img class="cart-product-image" src="{{ $item->productVariant->variant_image_url }}" alt="">
                                                </a>
                                            </td>
                                            <td class="product-name">
                                                <a href="demo-jewellery-store-single-product.html" class="text-dark-gray fw-500 d-block lh-initial">
                                                    {{ $item->productVariant->name }}
                                                </a>
                                              <span class="fs-14">
                                                    Màu: {{ $item->productVariant->color->color_name ?? 'N/A' }}
                                                </span>
                                            </td>
                                            <td class="product-price" data-title="Price">
                                                {{ number_format($item->price_at_time, 0, ',', '.') }} đ
                                            </td>
                                            <td class="product-quantity" data-title="Quantity">
                                                <div class="quantity" data-id="{{ $item->id }}">
                                                    <button type="button" class="qty-minus">-</button>
                                                    <input class="qty-text" type="text" value="{{ $item->quantity }}" >
                                                    <button type="button" class="qty-plus">+</button>
                                                </div>
                                            </td>
                                            <td class="product-subtotal" data-title="Total">
                                                {{ number_format($item->quantity * $item->price_at_time, 0, ',', '.') }} đ
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row mt-20px">
                   
                            <div class="col-xl-6 col-xxl-7 col-md-6">
                            <form action="{{ route('cart.applyVoucher') }}" method="POST" class="row g-2 align-items-center">
                                @csrf
                                <div class="col-8">
                                    <select name="code" class="form-select" required>
                                        <option value="">-- Chọn mã giảm giá --</option>
                                        @foreach($availableVouchers as $voucher)
                                            <option value="{{ $voucher->code }}"
                                                {{ session('voucher_code') == $voucher->code ? 'selected' : '' }}>
                                                @if ($voucher->type_discount === 'percent')
                                                    {{ $voucher->code }} - Giảm {{ $voucher->value }}%
                                                    (tối đa {{ number_format($voucher->max_discount, 0, ',', '.') }} đ)
                                                @else
                                                    {{ $voucher->code }} - Giảm {{ number_format($voucher->value, 0, ',', '.') }} đ
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-4">
                                    <button type="submit" class="btn btn-dark w-100">Áp dụng</button>
                                </div>
                            </form>
                        </div>




                        <div class="col-xl-6 col-xxl-5 col-md-6 text-center text-md-end sm-mt-15px">
                          <a href="#" id="delete-selected-btn"
                                class="btn btn-small border-1 btn-round-edge btn-transparent-light-gray text-transform-none me-15px lg-me-5px">
                                Xóa sản phẩm đã chọn
                        </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="bg-very-light-gray border-radius-6px p-50px xl-p-30px lg-p-25px">
                        <span class="fs-26 alt-font fw-600 text-dark-gray mb-5px d-block">	Tổng đơn hàng</span>
                        <table class="w-100 total-price-table">
                            <tbody>
                                <tr>
                                    <th class="w-45 fw-600 text-dark-gray alt-font">Tạm tính</th>
                                    <td class="text-dark-gray fw-600" id="subtotal">
                                        {{ number_format($subtotal, 0, ',', '.') }} đ
                                    </td>
                                </tr>
                              
                                    <tr class="max_discount">
                                        <th class="fw-600 text-dark-gray alt-font">
                                            {{ session('voucher_code') ? 'Voucher' : 'Mã giảm giá' }}
                                        </th>
                                        <td data-title="Voucher">
                                            @if(session('voucher_code'))
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <span class="text-danger fw-600">
                                                            -{{ number_format(session('voucher_discount', 0), 0, ',', '.') }} đ
                                                        </span><br>
                                                        <small class="text-dark-gray">({{ session('voucher_code') }})</small>
                                                    </div>
                                                    <a href="{{ route('cart.removeVoucher') }}" class="text-danger ms-3">✕</a>
                                                </div>
                                            @else
                                                <span class="text-muted">Chưa áp dụng</span>
                                            @endif
                                        </td>
                                    </tr>

                                <tr class="total-amount">
                                    <th class="fw-600 text-dark-gray alt-font pb-0">Tổng tiền </th>
                                    <td class="pb-0" data-title="Total">
                                        <h6 id="total" class="d-block fw-700 mb-0 text-dark-gray alt-font">
                                            {{ number_format($total, 0, ',', '.') }} đ
                                        </h6>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <a href="{{ route('home.checkout') }}"
                        class="btn btn-dark-gray btn-large btn-switch-text btn-round-edge btn-box-shadow w-100 mt-25px">
                            <span>
                                <span class="btn-double-text" data-text="Đặt Hàng">Đặt Hàng</span>
                            </span>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- end section -->
@endsection
@section('js-page-custom')
  <script>
// ...existing code...
document.addEventListener('DOMContentLoaded', function() {
    // Desktop check all
    const selectAllDesktop = document.getElementById('select-all-cart');
    // Mobile check all
    const selectAllMobile = document.getElementById('select-all-cart-mobile');
    // Tất cả checkbox sản phẩm
    const itemCheckboxes = document.querySelectorAll('.cart-item-checkbox:not(#select-all-cart):not(#select-all-cart-mobile)');

    function setAllCheckboxes(checked) {
        itemCheckboxes.forEach(cb => cb.checked = checked);
    }

    // Khi click desktop check all
    if (selectAllDesktop) {
        selectAllDesktop.addEventListener('change', function() {
            setAllCheckboxes(this.checked);
            if (selectAllMobile) selectAllMobile.checked = this.checked;
        });
    }

    // Khi click mobile check all
    if (selectAllMobile) {
        selectAllMobile.addEventListener('change', function() {
            setAllCheckboxes(this.checked);
            if (selectAllDesktop) selectAllDesktop.checked = this.checked;
        });
    }

    // Khi click từng checkbox sản phẩm
    itemCheckboxes.forEach(cb => {
        cb.addEventListener('change', function() {
            const allChecked = Array.from(itemCheckboxes).every(c => c.checked);
            if (selectAllDesktop) selectAllDesktop.checked = allChecked;
            if (selectAllMobile) selectAllMobile.checked = allChecked;
        });
    });
});
// ...existing code...
</script>
<script>
document.getElementById('delete-selected-btn').addEventListener('click', function (e) {
    e.preventDefault();

    const selected = document.querySelectorAll('.cart-item-checkbox:checked');
    const ids = Array.from(selected).map(cb => cb.value);

    if (ids.length === 0) {
        alert("Vui lòng chọn sản phẩm để xoá.");
        return;
    }

    fetch("{{ route('cart.deleteSelected') }}", {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ ids })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            alert('Đã xoá sản phẩm thành công.');
            location.reload();
        } else {
            alert('Xoá thất bại.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Có lỗi xảy ra.');
    });
});
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.qty-plus, .qty-minus').forEach(function (btn) {
        btn.addEventListener('click', function () {
            let parent = btn.closest('.quantity');
            let id = parent.dataset.id;
            let input = parent.querySelector('.qty-text');
            let action = btn.classList.contains('qty-plus') ? 'increase' : 'decrease';

            fetch("{{ route('cart.updateQuantity') }}", {
                method: "POST",
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ id: id, action: action })
            })
            .then(res => res.json())
            .then(res => {
                if (res.success) {
                    input.value = res.quantity;
                    parent.closest('tr').querySelector('.product-subtotal').innerText = res.item_total;
                    document.getElementById('subtotal').innerText = res.subtotal;
                    document.getElementById('total').innerText = res.total;
                } else {
                    showToast(res.message || 'Có lỗi xảy ra.', 'danger');
                }
            })
            .catch(() => {
                showToast("Không thể cập nhật giỏ hàng.", 'danger');
            });
        });
    });
});

</script>
{{-- <script>
document.addEventListener('DOMContentLoaded', function () {
    // Hiển thị tất cả các thông báo từ session
    document.querySelectorAll('.toast-message').forEach(function(el) {
        const msg = el.getAttribute('data-message');
        const type = el.getAttribute('data-type') || 'info';
        if (msg) showToast(msg, type);
    });

    function showToast(message, type = 'info') {
        const container = document.getElementById('toast-container');
        if (!container) return;

        const toast = document.createElement('div');
        toast.className = `toast align-items-center text-bg-${type} border-0 show mb-2`;
        toast.role = 'alert';
        toast.innerHTML = `
            <div class="d-flex">
                <div class="toast-body">${message}</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        `;
        container.appendChild(toast);

        // Auto hide sau 4s
        setTimeout(() => {
            toast.classList.remove('show');
            toast.classList.add('hide');
            setTimeout(() => toast.remove(), 500);
        }, 4000);

        // Cho phép đóng bằng nút
        toast.querySelector('.btn-close').onclick = () => toast.remove();
    }
});
</script> --}}

<script>
  
function showToast(message, type = 'info') {
    const container = document.getElementById('toast-container');
    if (!container) return;

    const toast = document.createElement('div');
    toast.className = `toast align-items-center text-bg-${type} border-0 show mb-2`;
    toast.role = 'alert';
    toast.innerHTML = `
        <div class="d-flex">
            <div class="toast-body">${message}</div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    `;
    container.appendChild(toast);

    setTimeout(() => {
        toast.classList.remove('show');
        toast.classList.add('hide');
        setTimeout(() => toast.remove(), 500);
    }, 4000);

    toast.querySelector('.btn-close').onclick = () => toast.remove();
}

// Sau đó dùng trong bất kỳ đâu
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.toast-message').forEach(function(el) {
        const msg = el.getAttribute('data-message');
        const type = el.getAttribute('data-type') || 'info';
        if (msg) showToast(msg, type);
    });
});

</script>
@endsection
@section('cdn-custom')
    <style>
        .coupon-code-panel.d-block.d-sm-none::before {
            content: none;
        }
        @media (max-width: 575.98px) {
    .coupon-code-panel.mobile {
        padding-right: 1px !important; /* hoặc px-3 nếu table dùng */
    }
    .cart-item-checkbox {
        margin-right: 0 !important;
    }
}
    </style>
@endsection
