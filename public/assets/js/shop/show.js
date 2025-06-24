document.addEventListener('DOMContentLoaded', function() {
    // Nếu có hash trên URL, active tab tương ứng
    if (window.location.hash) {
        let hash = window.location.hash;
        let tabLink = document.querySelector('a[href="' + hash + '"]');
        if (tabLink) {
            let tab = new bootstrap.Tab(tabLink);
            tab.show();
        }
    }

    // Khi click vào tab, cập nhật hash trên URL
    document.querySelectorAll('.nav-tabs .nav-link').forEach(function(tabLink) {
        tabLink.addEventListener('shown.bs.tab', function(e) {
            history.replaceState(null, null, e.target.getAttribute('href'));
        });
    });

    // Ẩn các review-item từ số 4 trở đi
    let reviews = document.querySelectorAll('.review-item');
    let showMoreBtn = document.querySelector('.btn-text');
    let showMoreBtnA = showMoreBtn ? showMoreBtn.closest('a') : null;
    let expanded = false;

    function collapseReviews() {
        reviews.forEach((item, idx) => {
            item.style.display = (idx > 2) ? 'none' : '';
        });
        if (showMoreBtn) showMoreBtn.textContent = 'Hiển thị thêm đánh giá';
        expanded = false;
    }

    function expandReviews() {
        reviews.forEach(item => item.style.display = '');
        if (showMoreBtn) showMoreBtn.textContent = 'Thu gọn đánh giá';
        expanded = true;
    }

    if (reviews.length > 3) {
        collapseReviews();
        if (showMoreBtnA) showMoreBtnA.style.display = '';
    } else if (showMoreBtnA) {
        showMoreBtnA.style.display = 'none';
    }

    if (showMoreBtnA) {
        showMoreBtnA.addEventListener('click', function(e) {
            e.preventDefault();
            if (!expanded) {
                expandReviews();
            } else {
                collapseReviews();
                // Scroll về vị trí review-list-container nếu cần
                document.getElementById('review-list-container').scrollIntoView({
                    behavior: 'smooth'
                });
            }
        });
    }

    // Toast notification for errors
    const toastErrors = document.querySelectorAll('.toast-error');
    toastErrors.forEach(function(el) {
        const msg = el.getAttribute('data-message');
        if (msg) showToast(msg, 'danger');
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

        setTimeout(() => {
            toast.classList.remove('show');
            toast.classList.add('hide');
            setTimeout(() => toast.remove(), 500);
        }, 4000);

        toast.querySelector('.btn-close').onclick = () => toast.remove();
    }
});
$('.qty-plus').click(function () {
var th = $(this).closest('.quantity').find('.qty-text');
th.val(+th.val() + 1);
updateCartTotals(); // Cập nhật tổng giá sau khi tăng
});

$('.qty-minus').click(function () {
var th = $(this).closest('.quantity').find('.qty-text');
if (th.val() > 1)
    th.val(+th.val() - 1);
updateCartTotals(); // Cập nhật tổng giá sau khi giảm
});
$('.qty-text').on('input', function () {
updateCartTotals();
});
document.addEventListener('DOMContentLoaded', function() {
    function updateStockInfo() {
        var color = document.querySelector('input[name="color"]:checked');
        var size = document.querySelector('input[name="size"]:checked');
        var stockInfo = document.getElementById('stock-info');
        if (color && size) {
            var key = color.value + '-' + size.value;
            var stock = window.variantStock[key] !== undefined ? window.variantStock[key] : 0;
            stockInfo.textContent = 'Tồn kho: ' + stock;
            stockInfo.className = stock > 0 ? 'text-success' : 'text-danger';
        } else {
            stockInfo.textContent = '';
        }
    }

    document.querySelectorAll('input[name="color"], input[name="size"]').forEach(function(input) {
        input.addEventListener('change', updateStockInfo);
    });

    // Gọi lần đầu nếu có sẵn lựa chọn
    updateStockInfo();
});