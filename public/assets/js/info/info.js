document.addEventListener("DOMContentLoaded", function () {
    // Form đổi mật khẩu
    const showChangePasswordForm = document.getElementById('showChangePasswordForm');
    const changePasswordForm = document.getElementById('changePasswordForm');
    const cancelChangePassword = document.getElementById('cancelChangePassword');

    if (showChangePasswordForm && changePasswordForm && cancelChangePassword) {
        showChangePasswordForm.addEventListener('click', function (e) {
            e.preventDefault();
            changePasswordForm.style.display = 'block';
            changePasswordForm.scrollIntoView({ behavior: 'smooth' });
        });

        cancelChangePassword.addEventListener('click', function () {
            changePasswordForm.style.display = 'none';
        });
    }

    const selectedTab = localStorage.getItem("selectedTab");
    const selectedSubTab = localStorage.getItem("selectedSubTab");

    // Bật tab cha
    if (selectedTab && selectedTab.startsWith('#') && selectedTab.length > 1) {
        const tabToActivate = document.querySelector(`a[href="${selectedTab}"]`);
        const tabContentToShow = document.querySelector(selectedTab);

        if (tabToActivate && tabContentToShow) {
            document.querySelectorAll('.nav-link').forEach(tab => tab.classList.remove('active'));
            document.querySelectorAll('.tab-pane').forEach(content => content.classList.remove('show', 'active'));

            tabToActivate.classList.add('active');
            tabContentToShow.classList.add('show', 'active');

            if (selectedTab === "#tab_seven2") {
                let subTabToActivate, subTabContentToShow;

                if (selectedSubTab && selectedSubTab.startsWith('#') && selectedSubTab.length > 1) {
                    subTabToActivate = document.querySelector(`#tab_seven2 .nav-link[href="${selectedSubTab}"]`);
                    subTabContentToShow = document.querySelector(selectedSubTab);
                } else {
                    subTabToActivate = document.querySelector('#tab_seven2 .nav-link[href="#tab_third1"]');
                    subTabContentToShow = document.querySelector('#tab_third1');
                }

                if (subTabToActivate && subTabContentToShow) {
                    document.querySelectorAll('#tab_seven2 .nav-link').forEach(tab => tab.classList.remove('active'));
                    document.querySelectorAll('#tab_seven2 .tab-pane').forEach(content => content.classList.remove('show', 'active'));

                    subTabToActivate.classList.add('active');
                    subTabContentToShow.classList.add('show', 'active');
                }
            }
        }
    }

    // Lưu tab cha
    document.querySelectorAll('.nav-link').forEach(link => {
        link.addEventListener('click', function () {
            const href = this.getAttribute('href');
            if (href && href.startsWith('#') && href.length > 1) {
                localStorage.setItem("selectedTab", href);

                if (href !== '#tab_seven2') {
                    localStorage.removeItem("selectedSubTab");
                } else {
                    const subTabToActivate = document.querySelector('#tab_seven2 .nav-link[href="#tab_third1"]');
                    const subTabContentToShow = document.querySelector('#tab_third1');

                    if (subTabToActivate && subTabContentToShow) {
                        document.querySelectorAll('#tab_seven2 .nav-link').forEach(tab => tab.classList.remove('active'));
                        document.querySelectorAll('#tab_seven2 .tab-pane').forEach(content => content.classList.remove('show', 'active'));

                        subTabToActivate.classList.add('active');
                        subTabContentToShow.classList.add('show', 'active');
                    }
                }
            }
        });
    });

    // Lưu tab con
    document.querySelectorAll('#tab_seven2 .nav-link').forEach(link => {
        link.addEventListener('click', function () {
            const href = this.getAttribute('href');
            if (href && href.startsWith('#') && href.length > 1) {
                localStorage.setItem("selectedSubTab", href);
                localStorage.setItem("selectedTab", "#tab_seven2");
            }
        });
    });

    // Flatpickr
    const currentDate = new Date();
    const currentDateString = currentDate.toLocaleDateString('en-GB');
    const daterangeInput = document.getElementById('daterange');
    if (daterangeInput) {
        console.log('[INFO] Initializing Flatpickr for daterange input');
        daterangeInput.placeholder = `2022-01-01 to ${currentDate.toISOString().slice(0, 10)}`;
        flatpickr("#daterange", {
            mode: "range",
            dateFormat: "Y-m-d",
            minDate: "2022-01-01",
            maxDate: currentDate,
            locale: {
                firstDayOfWeek: 1
            },
            onClose: function (selectedDates, dateStr, instance) {
                if (selectedDates.length === 2) {
                    const format = d => d.getFullYear() + '-' +
                        String(d.getMonth() + 1).padStart(2, '0') + '-' +
                        String(d.getDate()).padStart(2, '0');
                    const from = format(selectedDates[0]);
                    const to = format(selectedDates[1]);
                    instance.input.value = from + " to " + to;
            
                    // Lấy status tab hiện tại nếu có
                    let status = '';
                    const activeTab = document.querySelector('#tab_seven2 .nav-link.active');
                    if (activeTab) {
                        const href = activeTab.getAttribute('href');
                        if (href && href.startsWith('#tab_third')) {
                            // Map tab id sang status nếu cần
                            if (href === '#tab_third2') status = 'pending';
                            if (href === '#tab_third3') status = 'confirmed';
                            if (href === '#tab_third4') status = 'shipping';
                            if (href === '#tab_third5') status = 'success';
                            if (href === '#tab_third6') status = 'cancelled';
                        }
                    }
            
                    // Gọi AJAX
                    let url = `/account/orders?from=${from}&to=${to}`;
                    if (status) url += `&status=${status}`;
            
                    fetch(url, {
                        headers: { 'X-Requested-With': 'XMLHttpRequest' }
                    })
                    .then(res => res.text())
                    .then(html => {
                        // Cập nhật lại danh sách đơn hàng trong tab hiện tại
                        if (status) {
                            document.querySelector(`#tab_seven2 ${activeTab.getAttribute('href')}`).innerHTML = html;
                        } else {
                            document.querySelector('#tab_third1').innerHTML = html;
                        }
                    })
                    .catch(err => {
                        alert('Lỗi khi lọc đơn hàng!');
                        console.error(err);
                    });
                }
            }
        });
    } else {
        console.error('[ERROR] daterange input not found on the page. Flatpickr not initialized.');
    }

    // Nếu có from/to trên URL thì set lại value cho input
    const urlParams = new URLSearchParams(window.location.search);
    const from = urlParams.get('from');
    const to = urlParams.get('to');
    if (from && to && daterangeInput) {
        daterangeInput.value = from + " to " + to;
    }
});
