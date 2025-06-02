    <script src="https://unpkg.com/just-validate@4.3.0/dist/just-validate.production.min.js"></script>

    <script src="{{asset('admin/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('admin/libs/simplebar/simplebar.min.js')}}"></script>
    <script src="{{asset('admin/libs/node-waves/waves.min.js')}}"></script>
    <script src="{{asset('admin/libs/feather-icons/feather.min.js')}}"></script>
    <script src="{{asset('admin/js/pages/plugins/lord-icon-2.1.0.js')}}"></script>
    <script src="{{asset('admin/js/plugins.js')}}"></script>

    <!-- apexcharts -->
    <script src="{{asset('admin/libs/apexcharts/apexcharts.min.js')}}"></script>

    <!-- Vector map-->
    <script src="{{asset('admin/libs/jsvectormap/js/jsvectormap.min.js')}}"></script>
    <script src="{{asset('admin/libs/jsvectormap/maps/world-merc.js')}}"></script>

    <!--Swiper slider js-->
    <script src="{{asset('admin/libs/swiper/swiper-bundle.min.js')}}"></script>

    <!-- Dashboard init -->
    <script src="{{asset('admin/js/pages/dashboard-ecommerce.init.js')}}"></script>

   <!-- Layout config Js -->
    {{-- <script src="{{asset('admin/js/layout.js')}}"></script> --}}
    <!-- Bootstrap Css -->
    <link href="{{asset('admin/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{asset('admin/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{asset('admin/css/app.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="{{asset('admin/css/custom.min.css')}}" rel="stylesheet" type="text/css" />


    <!-- gridjs js -->
    <script src="{{asset('admin/libs/gridjs/gridjs.umd.js')}}"></script>
   <script src="https://unpkg.com/gridjs/plugins/selection/dist/selection.umd.js"></script>

    <script src="{{asset('admin/js/pages/ecommerce-product-list.init.js')}}"></script>

    <script src="{{asset('admin/libs/nouislider/nouislider.min.js')}}"></script>
    <script src="{{asset('admin/libs/wnumb/wNumb.min.js')}}"></script>

 <!--jquery cdn-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <!--select2 cdn-->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="{{asset('admin/js/pages/select2.init.js')}}"></script>
  <!-- App js -->
    <script src="{{asset('admin/js/app.js')}}"></script>
    <script>
  // Khi click mở menu "Danh sách", lưu trạng thái mở
  document.addEventListener('DOMContentLoaded', function () {
    const menuToggle = document.querySelector('[href="#sidebarDashboards"]');
    const menuDropdown = document.getElementById('sidebarDashboards');

    // Đọc trạng thái từ localStorage
    const isOpen = localStorage.getItem('sidebarDashboardsOpen');
    if (isOpen === 'true') {
      menuDropdown.classList.add('show');
      menuToggle.setAttribute('aria-expanded', 'true');
    }

    // Ghi trạng thái mỗi khi click
    menuToggle.addEventListener('click', function () {
      const willOpen = !menuDropdown.classList.contains('show');
      localStorage.setItem('sidebarDashboardsOpen', willOpen);
    });
  });
</script>



