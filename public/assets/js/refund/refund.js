document.addEventListener('DOMContentLoaded', function() {
    // Bank API
    const bankSelect = document.getElementById('bankSelect');
    if (bankSelect) {
        fetch('https://api.vietqr.io/v2/banks')
            .then(res => res.json())
            .then(data => {
                if (data && data.data) {
                    data.data.forEach(function(bank) {
                        const option = document.createElement('option');
                        option.value = bank.code;
                        option.text = bank.shortName + ' - ' + bank.name;
                        bankSelect.appendChild(option);
                    });
                }
            })
            .catch(error => {
                console.error('Error loading banks:', error);
            });
    }

    // Tab switching
    const tabButtons = document.querySelectorAll('.tab-btn');
    const tabContents = document.querySelectorAll('.tab-content');

    tabButtons.forEach(button => {
        button.addEventListener('click', function() {
            const targetTab = this.dataset.tab;

            // Remove active class from all buttons and contents
            tabButtons.forEach(btn => btn.classList.remove('active'));
            tabContents.forEach(content => content.classList.remove('active'));

            // Add active class to clicked button and corresponding content
            this.classList.add('active');
            document.getElementById(targetTab + '-content').classList.add('active');
        });
    });

    // Amount editing
    function setupAmountEdit(editBtnId, inputId) {
        const editBtn = document.getElementById(editBtnId);
        const input = document.getElementById(inputId);

        if (editBtn && input) {
            editBtn.addEventListener('click', function() {
                const isReadonly = input.readOnly;
                input.readOnly = !isReadonly;

                if (!input.readOnly) {
                    input.focus();
                    input.select();
                    this.innerHTML = '<i class="fas fa-check"></i>';
                    this.style.background = '#48bb78';
                } else {
                    this.innerHTML = '<i class="fas fa-edit"></i>';
                    this.style.background = '#667eea';
                }
            });
        }
    }

    setupAmountEdit('editAmountStk', 'refundAmountStk');
    setupAmountEdit('editAmountQr', 'refundAmountQr');

    // File upload handling
    const qrImageInput = document.getElementById('qrImageInput');
    const qrImagePreview = document.getElementById('qrImagePreview');
    const previewImage = document.getElementById('previewImage');
    const removeImageBtn = document.getElementById('removeImage');
    const fileUploadArea = document.getElementById('fileUploadArea');

    if (qrImageInput && qrImagePreview && previewImage) {
        // File input change
        qrImageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                // Validate file size (5MB)
                if (file.size > 5 * 1024 * 1024) {
                    alert('File quá lớn! Vui lòng chọn file nhỏ hơn 5MB.');
                    this.value = '';
                    return;
                }

                // Validate file type
                const allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                if (!allowedTypes.includes(file.type)) {
                    alert('Chỉ hỗ trợ file JPG, PNG, GIF!');
                    this.value = '';
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    qrImagePreview.style.display = 'block';
                    fileUploadArea.style.display = 'none';
                };
                reader.readAsDataURL(file);
            }
        });

        // Remove image
        if (removeImageBtn) {
            removeImageBtn.addEventListener('click', function() {
                qrImageInput.value = '';
                qrImagePreview.style.display = 'none';
                fileUploadArea.style.display = 'block';
            });
        }

        // Drag and drop
        fileUploadArea.addEventListener('dragover', function(e) {
            e.preventDefault();
            this.style.borderColor = '#667eea';
            this.style.background = '#f7fafc';
        });

        fileUploadArea.addEventListener('dragleave', function(e) {
            e.preventDefault();
            this.style.borderColor = '#cbd5e0';
            this.style.background = 'white';
        });

        fileUploadArea.addEventListener('drop', function(e) {
            e.preventDefault();
            this.style.borderColor = '#cbd5e0';
            this.style.background = 'white';

            const files = e.dataTransfer.files;
            if (files.length > 0) {
                qrImageInput.files = files;
                qrImageInput.dispatchEvent(new Event('change'));
            }
        });
    }

    // Form validation
    const form = document.getElementById('refundForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            // Xóa lỗi cũ
            form.querySelectorAll('.error-message').forEach(el => el.textContent = '');

            let hasError = false;
            const activeTab = document.querySelector('.tab-content.active');
            const activeTabId = activeTab.id;

            if (activeTabId === 'stk-content') {
                const bankCode = form.querySelector('select[name="bank_code"]');
                const accountNumber = form.querySelector('input[name="account_number"]');
                const accountName = form.querySelector('input[name="account_name"]');
                const reason = form.querySelector('textarea[name="reason"]');

                if (!bankCode.value) {
                    bankCode.closest('.form-group').querySelector('.error-message').textContent =
                        'Vui lòng chọn ngân hàng!';
                    hasError = true;
                }
                if (!accountNumber.value) {
                    accountNumber.closest('.form-group').querySelector('.error-message')
                        .textContent = 'Vui lòng nhập số tài khoản!';
                    hasError = true;
                }
                if (!accountName.value) {
                    accountName.closest('.form-group').querySelector('.error-message').textContent =
                        'Vui lòng nhập tên chủ thẻ!';
                    hasError = true;
                }
                if (!reason.value) {
                    reason.closest('.form-group').querySelector('.error-message').textContent =
                        'Vui lòng nhập lý do hoàn tiền!';
                    hasError = true;
                }
            } else if (activeTabId === 'qr-content') {
                const qrImage = form.querySelector('input[name="qr_image"]');
                if (!qrImage.files[0]) {
                    qrImage.closest('.form-group').querySelector('.error-message').textContent =
                        'Vui lòng upload mã QR!';
                    hasError = true;
                }
            }

            if (hasError) {
                e.preventDefault();
                return;
            }

            // Show loading state
            const submitBtn = form.querySelector('.submit-btn');
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Đang xử lý...';
            submitBtn.disabled = true;
        });
    }

    const orderTotal = window.orderTotal || 0;
    const amountInput = document.getElementById('refundAmountQr');
    const editBtn = document.getElementById('editAmountQr');
    const editIcon = editBtn.querySelector('i');

    let isEditing = false;

    editBtn.addEventListener('click', function() {
        // Xóa lỗi cũ
        document.querySelectorAll('.js-amount-error').forEach(el => el.remove());

        if (!isEditing) {
            // Đang readonly, chuyển sang editable
            amountInput.removeAttribute('readonly');
            amountInput.focus();
            // Đổi icon thành tích V
            editIcon.classList.remove('fa-edit');
            editIcon.classList.add('fa-check');
            isEditing = true;
        } else {
            // Đang editable, kiểm tra số tiền
            const amount = parseFloat(amountInput.value);
            if (Math.abs(amount - orderTotal) > 0.001) {
                // Hiện lỗi
                const error = document.createElement('span');
                error.className = 'text-danger js-amount-error';
                error.innerText = 'Sai giá trị đơn hàng';
                amountInput.after(error);
                return;
            }
            // Đúng thì set readonly lại
            amountInput.setAttribute('readonly', true);
            // Đổi icon về edit
            editIcon.classList.remove('fa-check');
            editIcon.classList.add('fa-edit');
            isEditing = false;
            // Thông báo thành công
            const success = document.createElement('span');
            success.className = 'text-success js-amount-success';
            success.innerText = 'Số tiền hợp lệ!';
            amountInput.after(success);
            // Ẩn thông báo sau 2 giây
            setTimeout(() => {
                success.remove();
            }, 2000);
        }
    });
});