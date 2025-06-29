<!doctype html>
<html class="no-js" lang="en">
@include('card.head')
<style>
    .nav-link.no-wrap {
        white-space: nowrap;
    }
</style>

<div id="chatbox" style="position: fixed; bottom: 20px; left: 20px; z-index: 9999;">
    <button onclick="toggleChat()"
        style="background-color: #007bff; color: white; padding: 10px 15px; border: none; border-radius: 25px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); cursor: pointer;">
        💬 Chat với chúng tôi
    </button>
    <div id="chat-content"
        style="display: none; margin-top: 10px; width: 300px; background: white; border: 1px solid #ddd; border-radius: 10px; padding: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.2);">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <strong>Hỗ trợ khách hàng</strong>
            <button onclick="toggleChat()"
                style="background: transparent; border: none; font-size: 16px; cursor: pointer;">✖</button>
        </div>
        <hr>
        <p style="font-size: 14px;">Xin chào! Chúng tôi có thể giúp gì cho bạn?</p>

        <!-- Đây là phần bạn cần thêm để thấy được chat -->
        <div id="chat-box"
            style="border: 1px solid #ccc; padding: 10px; height: 150px; overflow-y: auto; margin-top: 10px; font-size: 14px;">
        </div>

        <input type="text" id="message" placeholder="Nhập câu hỏi..."
            style="width: 100%; padding: 5px; border-radius: 5px; border: 1px solid #ccc; margin-top: 10px;"
            onkeydown="if(event.key === 'Enter') sendMessage();">
        <button onclick="sendMessage()"
            style="margin-top: 10px; width: 100%; padding: 8px; background-color: #007bff; color: white; border: none; border-radius: 5px;">Gửi</button>
    </div>
</div>

<body data-mobile-nav-style="classic">
    <!-- start header -->
    <header class="header-with-topbar">
        <!-- start header top bar -->
        <div
            class="header-top-bar top-bar-light bg-base-color disable-fixed md-border-bottom border-color-transparent-dark-very-light">
            <div class="container-fluid">
                <div class="row h-40px align-items-center m-0">
                    <div class="col-12 justify-content-center alt-font fs-13 fw-500 text-uppercase">
                        <div class="text-dark-gray">Miễn phí giao hàng với đơn hàng từ 200.000 VND.</div>
                        <a href="admin" class="text-dark-gray fw-600 ms-5px text-dark-gray-hover"><span
                                class="text-decoration-line-bottom">Mua Ngay</span></a>
                    </div>
                </div>
            </div>
        </div>
        <!-- end header top bar -->
        <!-- start navigation -->
        @include('card.nav')
    </header>
    <!-- end header -->
    <!-- start section -->
    @include('card.banner')
    <!-- end section -->
    <!-- start section -->
    <section class="half-section">
        <div class="container">
            <div class="row row-cols-1 row-cols-xl-4 row-cols-lg-4 row-cols-md-2 row-cols-sm-2"
                data-anime='{ "el": "childs", "translateX": [30, 0], "opacity": [0,1], "duration": 800, "delay": 200, "staggervalue": 300, "easing": "easeOutQuad" }'>
                <!-- start features box item -->
                <div class="col icon-with-text-style-01 md-mb-35px">
                    <div class="feature-box feature-box-left-icon-middle last-paragraph-no-margin">
                        <div class="feature-box-icon me-20px">
                            <i class="line-icon-Box-Close icon-large text-dark-gray"></i>
                        </div>
                        <div class="feature-box-content">
                            <span class="alt-font fs-20 fw-500 d-block text-dark-gray">Free shipping</span>
                            <p class="fs-16 lh-24">Free shipping on first order</p>
                        </div>
                    </div>
                </div>
                <!-- end features box item -->
                <!-- start features box item -->
                <div class="col icon-with-text-style-01 md-mb-35px">
                    <div class="feature-box feature-box-left-icon-middle last-paragraph-no-margin">
                        <div class="feature-box-icon me-20px">
                            <i class="line-icon-Reload-3 icon-large text-dark-gray"></i>
                        </div>
                        <div class="feature-box-content">
                            <span class="alt-font fs-20 fw-500 d-block text-dark-gray">15 days returns</span>
                            <p class="fs-16 lh-24">Moneyback guarantee</p>
                        </div>
                    </div>
                </div>
                <!-- end features box item -->
                <!-- start features box item -->
                <div class="col icon-with-text-style-01 xs-mb-35px">
                    <div class="feature-box feature-box-left-icon-middle last-paragraph-no-margin">
                        <div class="feature-box-icon me-20px">
                            <i class="line-icon-Credit-Card2 icon-large text-dark-gray"></i>
                        </div>
                        <div class="feature-box-content">
                            <span class="alt-font fs-20 fw-500 d-block text-dark-gray">Secure payment</span>
                            <p class="fs-16 lh-24">100% protected payment</p>
                        </div>
                    </div>
                </div>
                <!-- end features box item -->
                <!-- start features box item -->
                <div class="col icon-with-text-style-01">
                    <div class="feature-box feature-box-left-icon-middle last-paragraph-no-margin">
                        <div class="feature-box-icon me-20px">
                            <i class="line-icon-Phone-2 icon-large text-dark-gray"></i>
                        </div>
                        <div class="feature-box-content">
                            <span class="alt-font fs-20 fw-500 d-block text-dark-gray">Online support</span>
                            <p class="fs-16 lh-24">24/7 days a week support</p>
                        </div>
                    </div>
                </div>
                <!-- end features box item -->
            </div>
        </div>
    </section>
    <!-- end section -->
    <!-- start section -->
    @include('card.category_top')
    <!-- end section -->
    <!-- start section -->
    @include('card.best_sale_product')
    <!-- end section -->
    <!-- start section -->
    @if (!empty($voucher_block_3) && $voucher_block_3->max_used >= 1)
        <section class="p-15px bg-dark-gray text-white">
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center">
                        <span class="fs-15 text-uppercase fw-500">Mã giảm giá
                            @if($voucher_block_3->type_discount == 'percent')
                                {{$voucher_block_3->value .'%' .' tối đa '. ($voucher_block_3->max_discount)/1000 . 'k'}}
                                @else
                                {{($voucher_block_3->value)/1000 .'k'}}
                            @endif
                             <span
                                class="fs-14 fw-700 lh-28 alt-font text-dark-gray text-uppercase d-inline-block border-radius-30px ps-15px pe-15px ms-5px align-middle">
                                <form action="{{ url('accept_voucher/' . $voucher_block_3->id) }}" method="post">
                                    @csrf
                                    <button
                                        class="btn btn-gradient border-0 px-3 py-1 rounded-pill fw-600 shadow-sm align-middle"
                                        style="background: linear-gradient(90deg,#ffb347 0,#ffcc33 100%); color: #222; font-size: 15px;">Nhận
                                        ngay</button>
                                </form>
                            </span></span>
                    </div>
                </div>
            </div>
        </section>
    @else
        <section class="p-15px bg-dark-gray text-white">
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center">
                        <span class="fs-15 text-uppercase fw-500"><span
                                class="fs-14 fw-700 lh-28 alt-font text-dark-gray text-uppercase d-inline-block border-radius-30px ps-15px pe-15px ms-5px align-middle">
                                <button
                                    class="btn btn-gradient border-0 px-3 py-1 rounded-pill fw-600 shadow-sm align-middle"
                                    style="background: linear-gradient(90deg,#ffb347 0,#ffcc33 100%); color: #222; font-size: 15px;">Mua
                                    hàng từ 200k để được free ship</button>

                            </span></span>
                    </div>
                </div>
            </div>
        </section>
    @endif
    <!-- end section -->
    <!-- start section -->
    @include('card.new_product')
    <!-- end section -->
    <!-- start section -->
    <section class="half-section border-bottom border-color-extra-medium-gray">
        <div class="container">
            <div class="row row-cols-2 row-cols-md-5 row-cols-sm-3 position-relative justify-content-center"
                data-anime='{ "el": "childs", "translateY": [-15, 0], "scale": [0.8, 1], "opacity": [0,1], "duration": 300, "delay": 0, "staggervalue": 100, "easing": "easeOutQuad" }'>
                <!-- start client item -->
                <div class="col text-center sm-mb-30px">
                    <a href="#"><img src="{{ asset('assets/images/logo-asos.svg') }}" class="h-30px"
                            alt="" /></a>
                </div>
                <!-- end client item -->
                <!-- start client item -->
                <div class="col text-center sm-mb-30px">
                    <a href="#"><img src="{{ asset('assets/images/logo-chanel.svg') }}" class="h-30px"
                            alt="" /></a>
                </div>
                <!-- end client item -->
                <!-- start client item -->
                <div class="col text-center sm-mb-30px">
                    <a href="#"><img src="{{ asset('assets/images/logo-gucci.svg') }}" class="h-30px"
                            alt="" /></a>
                </div>
                <!-- end client item -->
                <!-- start client item -->
                <div class="col text-center xs-mb-30px">
                    <a href="#"><img src="{{ asset('assets/images/logo-celine.svg') }}" class="h-30px"
                            alt="" /></a>
                </div>
                <!-- end client item -->
                <!-- start client item -->
                <div class="col text-center">
                    <a href="#"><img src="{{ asset('assets/images/logo-adidas.svg') }}" class="h-30px"
                            alt="" /></a>
                </div>
                <!-- end client item -->
            </div>
        </div>
    </section>
    <!-- end section -->
    <!-- start section -->
    @include('card.feature')
    <!-- end section -->
    <!-- start section -->
    <section class="p-0 border-top border-bottom border-color-extra-medium-gray">
        <div class="container-fluid">
            <div class="row position-relative">
                <div class="col swiper text-center swiper-width-auto"
                    data-slider-options='{ "slidesPerView": "auto", "spaceBetween":0, "speed": 10000, "loop": true, "pagination": { "el": ".slider-four-slide-pagination-2", "clickable": false }, "allowTouchMove": false, "autoplay": { "delay":0, "disableOnInteraction": false }, "navigation": { "nextEl": ".slider-four-slide-next-2", "prevEl": ".slider-four-slide-prev-2" }, "keyboard": { "enabled": true, "onlyInViewport": true }, "effect": "slide" }'>
                    <div class="swiper-wrapper marquee-slide">
                        <!-- start client item -->
                        <div class="swiper-slide">
                            <div
                                class="alt-font fs-26 fw-500 text-dark-gray border-color-extra-medium-gray border-end pt-30px pb-30px ps-60px pe-60px sm-p-25px">
                                Get 20% off for your first order</div>
                        </div>
                        <!-- end client item -->
                        <!-- start client item -->
                        <div class="swiper-slide">
                            <div
                                class="alt-font fs-26 fw-500 text-dark-gray border-color-extra-medium-gray border-end pt-30px pb-30px ps-60px pe-60px sm-p-25px">
                                The fashion core collection</div>
                        </div>
                        <!-- end client item -->
                        <!-- start client item -->
                        <div class="swiper-slide">
                            <div
                                class="alt-font fs-26 fw-500 text-dark-gray border-color-extra-medium-gray border-end pt-30px pb-30px ps-60px pe-60px sm-p-25px">
                                100% secure protected payment</div>
                        </div>
                        <!-- end client item -->
                        <!-- start client item -->
                        <div class="swiper-slide">
                            <div
                                class="alt-font fs-26 fw-500 text-dark-gray border-color-extra-medium-gray border-end pt-30px pb-30px ps-60px pe-60px sm-p-25px">
                                Free shipping for orders over $130</div>
                        </div>
                        <!-- end client item -->
                        <!-- start client item -->
                        <div class="swiper-slide">
                            <div
                                class="alt-font fs-26 fw-500 text-dark-gray border-color-extra-medium-gray border-end pt-30px pb-30px ps-60px pe-60px sm-p-25px">
                                Pay with multiple credit cards</div>
                        </div>
                        <!-- end client item -->
                        <!-- start client item -->
                        <div class="swiper-slide">
                            <div
                                class="alt-font fs-26 fw-500 text-dark-gray border-color-extra-medium-gray border-end pt-30px pb-30px ps-60px pe-60px sm-p-25px">
                                Get 20% off for your first order</div>
                        </div>
                        <!-- end client item -->
                        <!-- start client item -->
                        <div class="swiper-slide">
                            <div
                                class="alt-font fs-26 fw-500 text-dark-gray border-color-extra-medium-gray border-end pt-30px pb-30px ps-60px pe-60px sm-p-25px">
                                The fashion core collection</div>
                        </div>
                        <!-- end client item -->
                        <!-- start client item -->
                        <div class="swiper-slide">
                            <div
                                class="alt-font fs-26 fw-500 text-dark-gray border-color-extra-medium-gray border-end pt-30px pb-30px ps-60px pe-60px sm-p-25px">
                                100% secure protected payment</div>
                        </div>
                        <!-- end client item -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end section -->
    <!-- start section -->
    @include('card.blog')
    <!-- end section -->
    <!-- start footer -->
    @include('card.footer')
    <!-- end footer -->
    <!-- start cookie message -->
    <div id="cookies-model" class="cookie-message bg-dark-gray border-radius-8px">
        <div class="cookie-description fs-14 text-white mb-20px lh-22">We use cookies to enhance your browsing
            experience, serve personalized ads or content, and analyze our traffic. By clicking "Allow cookies" you
            consent to our use of cookies. </div>
        <div class="cookie-btn">
            <a href="#"
                class="btn btn-transparent-white border-1 border-color-transparent-white-light btn-very-small btn-switch-text btn-rounded w-100 mb-15px"
                aria-label="btn">
                <span>
                    <span class="btn-double-text" data-text="Cookie policy">Cookie policy</span>
                </span>
            </a>
            <a href="#"
                class="btn btn-white btn-very-small btn-switch-text btn-box-shadow accept_cookies_btn btn-rounded w-100"
                data-accept-btn aria-label="text">
                <span>
                    <span class="btn-double-text" data-text="Allow cookies">Allow cookies</span>
                </span>
            </a>
        </div>
    </div>
    <!-- end cookie message -->
    <!-- start sticky elements -->
    <div class="sticky-wrap z-index-1 d-none d-xl-inline-block" data-animation-delay="100"
        data-shadow-animation="true">
        <div class="elements-social social-icon-style-10">
            <ul class="fs-16">
                <li class="me-30px"><a class="facebook" href="https://www.facebook.com/" target="_blank">
                        <i class="fa-brands fa-facebook-f me-10px"></i>
                        <span class="alt-font">Facebook</span>
                    </a>
                </li>
                <li class="me-30px">
                    <a class="dribbble" href="http://www.dribbble.com" target="_blank">
                        <i class="fa-brands fa-dribbble me-10px"></i>
                        <span class="alt-font">Dribbble</span>
                    </a>
                </li>
                <li class="me-30px">
                    <a class="twitter" href="http://www.twitter.com" target="_blank">
                        <i class="fa-brands fa-twitter me-10px"></i>
                        <span class="alt-font">Twitter</span>
                    </a>
                </li>
                <li>
                    <a class="instagram" href="http://www.instagram.com" target="_blank">
                        <i class="fa-brands fa-instagram me-10px"></i>
                        <span class="alt-font">Instagram</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <!-- end sticky elements -->
    <!-- start scroll progress -->
    <div class="scroll-progress d-none d-xxl-block">
        <a href="#" class="scroll-top" aria-label="scroll">
            <span class="scroll-text">Cuộn</span><span class="scroll-line"><span class="scroll-point"></span></span>
        </a>
    </div>
    <!-- end scroll progress -->
    <!-- javascript libraries -->
    @include('card.js')
</body>

</html>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    @if (session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Thành công!',
            text: "{{ session('success') }}",
        });
    @endif

    @if (session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Lỗi!',
            text: "{{ session('error') }}",
        });
    @endif


    function toggleChat() {
        const chat = document.getElementById('chat-content');
        chat.style.display = (chat.style.display === 'none' || chat.style.display === '') ? 'block' : 'none';
    }

    function sendMessage() {
        const msg = document.getElementById('message').value;
        if (!msg.trim()) return;
        const chat = document.getElementById('chat-box');
        chat.innerHTML += `<div class="user"><b>Bạn:</b> ${msg}</div>`;
        fetch('/chat', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    message: msg
                })
            }).then(res => res.json())
            .then(data => {
                chat.innerHTML += `<div class="bot"><b>Bot:</b> ${data.answer}</div>`;
                chat.scrollTop = chat.scrollHeight;
                document.getElementById('message').value = '';
            });
    }
</script>
