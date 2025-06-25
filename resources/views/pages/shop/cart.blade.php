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
                                                    <input class="qty-text" type="text" value="{{ $item->quantity }}" readonly>
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
                        {{-- <div class="col-xl-6 col-xxl-7 col-md-6">
                            <div class="coupon-code-panel mobile d-flex align-items-center d-block d-sm-none px-2 py-2"
                                style="background:#fff; border-radius:4px;">
                                <div class="flex-grow-1 text-start">Chọn tất cả</div>
                                <div class="text-end" style="min-width:48px;">
                                    <input type="checkbox" id="select-all-cart-mobile" class="cart-item-checkbox"
                                        style="width: 18px;">
                                </div>
                            </div>
                        </div> --}}
                <div class="col-xl-6 col-xxl-7 col-md-6">
                    <div class="row g-2 align-items-center">
                        <div class="col-8">
                            <select id="voucher-select" class="form-select">
                                <option value="">-- Chọn mã giảm giá --</option>
                                @foreach($availableVouchers as $voucher)
                                    <option value="{{ $voucher->code }}">
                                        {{ $voucher->code }} - Giảm {{ number_format($voucher->max_discount, 0, ',', '.') }} đ
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-4">
                            <a href="#" class="btn btn-dark w-100" onclick="applyVoucher()">Áp dụng</a>
                        </div>
                    </div>

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
            <span class="text-danger fw-600">
                -{{ number_format(session('voucher_discount', 0), 0, ',', '.') }} đ
            </span><br>
            <small class="text-dark-gray">({{ session('voucher_code') }})</small>
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
                        <a href="CHECK OUT DON HANG"
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
                }
            })
            .catch(() => alert("Có lỗi xảy ra khi cập nhật số lượng."));
        });
    });
});
</script>

<script>
function updateShipping(fee) {
    let subtotalText = document.getElementById('subtotal')?.innerText.replace(/\D/g, '') || 0;
    let discountText = document.getElementById('voucher-discount')?.innerText.replace(/\D/g, '') || 0;

    let subtotal = parseInt(subtotalText);
    let discount = parseInt(discountText);

    let total = subtotal - discount + fee;
    document.getElementById('total-price').innerText = total.toLocaleString('vi-VN') + ' đ';
}
</script>

<script>
function applyVoucher() {
    let code = $('#voucher-select').val();

    if (!code) {
        alert("Vui lòng chọn mã giảm giá.");
        return;
    }

    $.ajax({
        url: "{{ route('cart.applyVoucher') }}",
        method: "POST",
        data: {
            _token: '{{ csrf_token() }}',
            code: code
        },
        success: function (res) {
            if (res.success) {
                $('#subtotal').text(res.subtotal);
                $('#total').text(res.total);

                // Cập nhật phần hiển thị tiền giảm
                $('#voucher-discount').text('-' + res.discount);

                alert("Áp dụng mã giảm giá thành công!");
            } else {
                alert(res.message);
            }
        },
        error: function () {
            alert("Có lỗi xảy ra khi áp dụng mã.");
        }
    });
}
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
