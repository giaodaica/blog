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
    document.getElementById('daterange').placeholder = `01/01/2022-${currentDateString}`;
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
                instance.input.value = selectedDates[0].toLocaleDateString() + " - " + selectedDates[1].toLocaleDateString();
            }
        }
    });
});
