@extends('layouts.layout')
<style>

</style>
@section('content')

            <!-- start section -->
            <section class="top-space-margin half-section bg-gradient-very-light-gray">
                <div class="container">
                    <div class="row align-items-center justify-content-center" data-anime='{ "el": "childs", "translateY": [-15, 0], "opacity": [0,1], "duration": 300, "delay": 0, "staggervalue": 200, "easing": "easeOutQuad" }'>
                        <div class="col-12 col-xl-8 col-lg-10 text-center position-relative page-title-extra-large">
                            <h1 class="alt-font fw-600 text-dark-gray mb-10px">FAQs</h1>
                        </div>
                        <div class="col-12 breadcrumb breadcrumb-style-01 d-flex justify-content-center">
                            <ul>
                                <li><a href="demo-fashion-store.html">Home</a></li>
                                <li>Faqs</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>
            <!-- end section -->
            <!-- start section -->
            <section class="pt-0">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-3 col-lg-4 tab-style-07 md-mb-20px" data-anime='{ "el": "childs", "translateY": [30, 0], "opacity": [0,1], "duration": 300, "delay": 200, "staggervalue": 300, "easing": "easeOutQuad" }'>
                            <ul class="nav nav-tabs justify-content-center border-0 text-left alt-font fw-500">
                                <li class="nav-item">
                                    <a data-bs-toggle="tab" href="#tab_seven1" class="nav-link fs-18 active">
                                        <span>General</span>
                                        <span class="bg-hover bg-base-color"></span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link fs-18" data-bs-toggle="tab" href="#tab_seven2">
                                        <span>Shopping information</span>
                                        <span class="bg-hover bg-base-color"></span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link fs-18" data-bs-toggle="tab" href="#tab_seven3">
                                        <span>Payment information</span>
                                        <span class="bg-hover bg-base-color"></span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link fs-18" data-bs-toggle="tab" href="#tab_seven4">
                                        <span>Orders and returns</span>
                                        <span class="bg-hover bg-base-color"></span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link fs-18" data-bs-toggle="tab" href="#tab_seven5">
                                        <span>Ordering from crafto</span>
                                        <span class="bg-hover bg-base-color"></span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link fs-18" data-bs-toggle="tab" href="#tab_seven6">
                                        <span>Help and support</span>
                                        <span class="bg-hover bg-base-color"></span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <form class="nav-item" action="{{route('logout')}}" method="post">
                                        @csrf
                                        <button class="nav-link " data-bs-toggle="" href="">
                                            <span>Đăng xuất</span>
                                            <span class=""></span>
                                        </button>
                                    </form>
                                </li>
                            </ul>

                        </div>

                        <div class="col-lg-8 offset-xl-1 lg-ps-50px md-ps-15px">
                            <div class="tab-content h-100">
                                <!-- start tab content -->
                                <div class="tab-pane fade in active show" id="tab_seven1">
                                    <div class="row">
                                        <div class="col-12" data-anime='{ "el": "childs", "translateY": [30, 0], "opacity": [0,1], "duration": 300, "delay": 400, "staggervalue": 300, "easing": "easeOutQuad" }'>
                                            <div class="accordion accordion-style-02" id="accordion-style-01" data-active-icon="icon-feather-minus" data-inactive-icon="icon-feather-plus">
                                                <!-- start accordion item -->
                                                <div class="accordion-item active-accordion">
                                                    <div class="accordion-header border-bottom border-color-extra-medium-gray">
                                                        <a href="#" data-bs-toggle="collapse" data-bs-target="#accordion-style-01-01" aria-expanded="true" data-bs-parent="#accordion-style-01">
                                                            <div class="accordion-title mb-0 position-relative text-dark-gray">
                                                                <i class="feather icon-feather-minus"></i><span class="fw-500 fs-18">Can i order over the phone?</span>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div id="accordion-style-01-01" class="accordion-collapse collapse show" data-bs-parent="#accordion-style-01">
                                                        <div class="accordion-body last-paragraph-no-margin border-bottom border-color-extra-medium-gray">
                                                            <p>Lorem ipsum is simply dummy text of the printing and typesetting industry. Lorem ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took galley of type and scrambled to make type.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end accordion item -->
                                                <!-- start accordion item -->
                                                <div class="accordion-item">
                                                    <div class="accordion-header border-bottom border-color-extra-medium-gray">
                                                        <a href="#" data-bs-toggle="collapse" data-bs-target="#accordion-style-01-02" aria-expanded="false" data-bs-parent="#accordion-style-01">
                                                            <div class="accordion-title mb-0 position-relative text-dark-gray">
                                                                <i class="feather icon-feather-plus"></i><span class="fw-500 fs-18">I am having difficulty placing an order?</span>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div id="accordion-style-01-02" class="accordion-collapse collapse" data-bs-parent="#accordion-style-01">
                                                        <div class="accordion-body last-paragraph-no-margin border-bottom border-color-extra-medium-gray">
                                                            <p>Lorem ipsum is simply dummy text of the printing and typesetting industry. Lorem ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took galley of type and scrambled to make type.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end accordion item -->
                                                <!-- start accordion item -->
                                                <div class="accordion-item">
                                                    <div class="accordion-header border-bottom border-color-extra-medium-gray">
                                                        <a href="#" data-bs-toggle="collapse" data-bs-target="#accordion-style-01-03" aria-expanded="false" data-bs-parent="#accordion-style-01">
                                                            <div class="accordion-title mb-0 position-relative text-dark-gray">
                                                                <i class="feather icon-feather-plus"></i><span class="fw-500 fs-18">What payment methods does accept?</span>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div id="accordion-style-01-03" class="accordion-collapse collapse" data-bs-parent="#accordion-style-01">
                                                        <div class="accordion-body last-paragraph-no-margin border-bottom border-color-extra-medium-gray">
                                                            <p>Lorem ipsum is simply dummy text of the printing and typesetting industry. Lorem ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took galley of type and scrambled to make type.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end accordion item -->
                                                <!-- start accordion item -->
                                                <div class="accordion-item">
                                                    <div class="accordion-header border-bottom border-color-extra-medium-gray">
                                                        <a href="#" data-bs-toggle="collapse" data-bs-target="#accordion-style-01-04" aria-expanded="false" data-bs-parent="#accordion-style-01">
                                                            <div class="accordion-title mb-0 position-relative text-dark-gray">
                                                                <i class="feather icon-feather-plus"></i><span class="fw-500 fs-18">Can i amend my order once placed?</span>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div id="accordion-style-01-04" class="accordion-collapse collapse" data-bs-parent="#accordion-style-01">
                                                        <div class="accordion-body last-paragraph-no-margin border-bottom border-color-extra-medium-gray">
                                                            <p>Lorem ipsum is simply dummy text of the printing and typesetting industry. Lorem ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took galley of type and scrambled to make type.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end accordion item -->
                                                <!-- start accordion item -->
                                                <div class="accordion-item">
                                                    <div class="accordion-header border-bottom border-color-extra-medium-gray">
                                                        <a href="#" data-bs-toggle="collapse" data-bs-target="#accordion-style-01-05" aria-expanded="false" data-bs-parent="#accordion-style-01">
                                                            <div class="accordion-title mb-0 position-relative text-dark-gray">
                                                                <i class="feather icon-feather-plus"></i><span class="fw-500 fs-18">How do i know if my order was successful?</span>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div id="accordion-style-01-05" class="accordion-collapse collapse" data-bs-parent="#accordion-style-01">
                                                        <div class="accordion-body last-paragraph-no-margin border-bottom border-color-extra-medium-gray">
                                                            <p>Lorem ipsum is simply dummy text of the printing and typesetting industry. Lorem ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took galley of type and scrambled to make type.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end accordion item -->
                                                <!-- start accordion item -->
                                                <div class="accordion-item">
                                                    <div class="accordion-header border-bottom border-color-transparent">
                                                        <a href="#" data-bs-toggle="collapse" data-bs-target="#accordion-style-01-06" aria-expanded="false" data-bs-parent="#accordion-style-01">
                                                            <div class="accordion-title mb-0 position-relative text-dark-gray">
                                                                <i class="feather icon-feather-plus"></i><span class="fw-500 fs-18">What if my order is incorrect?</span>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div id="accordion-style-01-06" class="accordion-collapse collapse" data-bs-parent="#accordion-style-01">
                                                        <div class="accordion-body last-paragraph-no-margin border-bottom border-color-transparent">
                                                            <p>Lorem ipsum is simply dummy text of the printing and typesetting industry. Lorem ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took galley of type and scrambled to make type.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end accordion item -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end tab content -->
                                <!-- start tab content -->
                                <div class="tab-pane fade in h-100" id="tab_seven2">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="accordion accordion-style-02" id="accordion-style-02" data-active-icon="icon-feather-minus" data-inactive-icon="icon-feather-plus">
                                                <!-- start accordion item -->
                                                <div class="accordion-item active-accordion">
                                                    <div class="accordion-header border-bottom border-color-extra-medium-gray">
                                                        <a href="#" data-bs-toggle="collapse" data-bs-target="#accordion-style-02-01" aria-expanded="true" data-bs-parent="#accordion-style-02">
                                                            <div class="accordion-title mb-0 position-relative text-dark-gray">
                                                                <i class="feather icon-feather-minus"></i><span class="fw-500 fs-18">Can i order over the phone?</span>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div id="accordion-style-02-01" class="accordion-collapse collapse show" data-bs-parent="#accordion-style-02">
                                                        <div class="accordion-body last-paragraph-no-margin border-bottom border-color-extra-medium-gray">
                                                            <p>Lorem ipsum is simply dummy text of the printing and typesetting industry. Lorem ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took galley of type and scrambled to make type.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end accordion item -->
                                                <!-- start accordion item -->
                                                <div class="accordion-item">
                                                    <div class="accordion-header border-bottom border-color-extra-medium-gray">
                                                        <a href="#" data-bs-toggle="collapse" data-bs-target="#accordion-style-02-02" aria-expanded="false" data-bs-parent="#accordion-style-02">
                                                            <div class="accordion-title mb-0 position-relative text-dark-gray">
                                                                <i class="feather icon-feather-plus"></i><span class="fw-500 fs-18">I am having difficulty placing an order?</span>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div id="accordion-style-02-02" class="accordion-collapse collapse" data-bs-parent="#accordion-style-02">
                                                        <div class="accordion-body last-paragraph-no-margin border-bottom border-color-extra-medium-gray">
                                                            <p>Lorem ipsum is simply dummy text of the printing and typesetting industry. Lorem ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took galley of type and scrambled to make type.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end accordion item -->
                                                <!-- start accordion item -->
                                                <div class="accordion-item">
                                                    <div class="accordion-header border-bottom border-color-extra-medium-gray">
                                                        <a href="#" data-bs-toggle="collapse" data-bs-target="#accordion-style-02-03" aria-expanded="false" data-bs-parent="#accordion-style-02">
                                                            <div class="accordion-title mb-0 position-relative text-dark-gray">
                                                                <i class="feather icon-feather-plus"></i><span class="fw-500 fs-18">What payment methods does accept?</span>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div id="accordion-style-02-03" class="accordion-collapse collapse" data-bs-parent="#accordion-style-02">
                                                        <div class="accordion-body last-paragraph-no-margin border-bottom border-color-extra-medium-gray">
                                                            <p>Lorem ipsum is simply dummy text of the printing and typesetting industry. Lorem ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took galley of type and scrambled to make type.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end accordion item -->
                                                <!-- start accordion item -->
                                                <div class="accordion-item">
                                                    <div class="accordion-header border-bottom border-color-extra-medium-gray">
                                                        <a href="#" data-bs-toggle="collapse" data-bs-target="#accordion-style-02-04" aria-expanded="false" data-bs-parent="#accordion-style-02">
                                                            <div class="accordion-title mb-0 position-relative text-dark-gray">
                                                                <i class="feather icon-feather-plus"></i><span class="fw-500 fs-18">Can i amend my order once placed?</span>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div id="accordion-style-02-04" class="accordion-collapse collapse" data-bs-parent="#accordion-style-02">
                                                        <div class="accordion-body last-paragraph-no-margin border-bottom border-color-extra-medium-gray">
                                                            <p>Lorem ipsum is simply dummy text of the printing and typesetting industry. Lorem ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took galley of type and scrambled to make type.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end accordion item -->
                                                <!-- start accordion item -->
                                                <div class="accordion-item">
                                                    <div class="accordion-header border-bottom border-color-extra-medium-gray">
                                                        <a href="#" data-bs-toggle="collapse" data-bs-target="#accordion-style-02-05" aria-expanded="false" data-bs-parent="#accordion-style-02">
                                                            <div class="accordion-title mb-0 position-relative text-dark-gray">
                                                                <i class="feather icon-feather-plus"></i><span class="fw-500 fs-18">How do i know if my order was successful?</span>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div id="accordion-style-02-05" class="accordion-collapse collapse" data-bs-parent="#accordion-style-02">
                                                        <div class="accordion-body last-paragraph-no-margin border-bottom border-color-extra-medium-gray">
                                                            <p>Lorem ipsum is simply dummy text of the printing and typesetting industry. Lorem ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took galley of type and scrambled to make type.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end accordion item -->
                                                <!-- start accordion item -->
                                                <div class="accordion-item">
                                                    <div class="accordion-header border-bottom border-color-transparent">
                                                        <a href="#" data-bs-toggle="collapse" data-bs-target="#accordion-style-02-06" aria-expanded="false" data-bs-parent="#accordion-style-02">
                                                            <div class="accordion-title mb-0 position-relative text-dark-gray">
                                                                <i class="feather icon-feather-plus"></i><span class="fw-500 fs-18">What if my order is incorrect?</span>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div id="accordion-style-02-06" class="accordion-collapse collapse" data-bs-parent="#accordion-style-02">
                                                        <div class="accordion-body last-paragraph-no-margin border-bottom border-color-transparent">
                                                            <p>Lorem ipsum is simply dummy text of the printing and typesetting industry. Lorem ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took galley of type and scrambled to make type.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end accordion item -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end tab content -->
                                <!-- start tab content -->
                                <div class="tab-pane fade in h-100" id="tab_seven3">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="accordion accordion-style-02" id="accordion-style-03" data-active-icon="icon-feather-minus" data-inactive-icon="icon-feather-plus">
                                                <!-- start accordion item -->
                                                <div class="accordion-item active-accordion">
                                                    <div class="accordion-header border-bottom border-color-extra-medium-gray">
                                                        <a href="#" data-bs-toggle="collapse" data-bs-target="#accordion-style-03-01" aria-expanded="true" data-bs-parent="#accordion-style-03">
                                                            <div class="accordion-title mb-0 position-relative text-dark-gray">
                                                                <i class="feather icon-feather-minus"></i><span class="fw-500 fs-18">Can I return my order?</span>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div id="accordion-style-03-01" class="accordion-collapse collapse show" data-bs-parent="#accordion-style-03">
                                                        <div class="accordion-body last-paragraph-no-margin border-bottom border-color-extra-medium-gray">
                                                            <p>Lorem ipsum is simply dummy text of the printing and typesetting industry. Lorem ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took galley of type and scrambled to make type.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end accordion item -->
                                                <!-- start accordion item -->
                                                <div class="accordion-item">
                                                    <div class="accordion-header border-bottom border-color-extra-medium-gray">
                                                        <a href="#" data-bs-toggle="collapse" data-bs-target="#accordion-style-03-02" aria-expanded="false" data-bs-parent="#accordion-style-03">
                                                            <div class="accordion-title mb-0 position-relative text-dark-gray">
                                                                <i class="feather icon-feather-plus"></i><span class="fw-500 fs-18">What if my item is damaged or faulty?</span>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div id="accordion-style-03-02" class="accordion-collapse collapse" data-bs-parent="#accordion-style-03">
                                                        <div class="accordion-body last-paragraph-no-margin border-bottom border-color-extra-medium-gray">
                                                            <p>Lorem ipsum is simply dummy text of the printing and typesetting industry. Lorem ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took galley of type and scrambled to make type.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end accordion item -->
                                                <!-- start accordion item -->
                                                <div class="accordion-item">
                                                    <div class="accordion-header border-bottom border-color-extra-medium-gray">
                                                        <a href="#" data-bs-toggle="collapse" data-bs-target="#accordion-style-03-03" aria-expanded="false" data-bs-parent="#accordion-style-03">
                                                            <div class="accordion-title mb-0 position-relative text-dark-gray">
                                                                <i class="feather icon-feather-plus"></i><span class="fw-500 fs-18">How long will it take to process a return?</span>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div id="accordion-style-03-03" class="accordion-collapse collapse" data-bs-parent="#accordion-style-03">
                                                        <div class="accordion-body last-paragraph-no-margin border-bottom border-color-extra-medium-gray">
                                                            <p>Lorem ipsum is simply dummy text of the printing and typesetting industry. Lorem ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took galley of type and scrambled to make type.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end accordion item -->
                                                <!-- start accordion item -->
                                                <div class="accordion-item">
                                                    <div class="accordion-header border-bottom border-color-extra-medium-gray">
                                                        <a href="#" data-bs-toggle="collapse" data-bs-target="#accordion-style-03-04" aria-expanded="false" data-bs-parent="#accordion-style-03">
                                                            <div class="accordion-title mb-0 position-relative text-dark-gray">
                                                                <i class="feather icon-feather-plus"></i><span class="fw-500 fs-18">Why does the refund amount exclude delivery?</span>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div id="accordion-style-03-04" class="accordion-collapse collapse" data-bs-parent="#accordion-style-03">
                                                        <div class="accordion-body last-paragraph-no-margin border-bottom border-color-extra-medium-gray">
                                                            <p>Lorem ipsum is simply dummy text of the printing and typesetting industry. Lorem ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took galley of type and scrambled to make type.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end accordion item -->
                                                <!-- start accordion item -->
                                                <div class="accordion-item">
                                                    <div class="accordion-header border-bottom border-color-extra-medium-gray">
                                                        <a href="#" data-bs-toggle="collapse" data-bs-target="#accordion-style-03-05" aria-expanded="false" data-bs-parent="#accordion-style-03">
                                                            <div class="accordion-title mb-0 position-relative text-dark-gray">
                                                                <i class="feather icon-feather-plus"></i><span class="fw-500 fs-18">Need more help?</span>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div id="accordion-style-03-05" class="accordion-collapse collapse" data-bs-parent="#accordion-style-03">
                                                        <div class="accordion-body last-paragraph-no-margin border-bottom border-color-extra-medium-gray">
                                                            <p>Lorem ipsum is simply dummy text of the printing and typesetting industry. Lorem ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took galley of type and scrambled to make type.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end accordion item -->
                                                <!-- start accordion item -->
                                                <div class="accordion-item">
                                                    <div class="accordion-header border-bottom border-color-transparent">
                                                        <a href="#" data-bs-toggle="collapse" data-bs-target="#accordion-style-03-06" aria-expanded="false" data-bs-parent="#accordion-style-03">
                                                            <div class="accordion-title mb-0 position-relative text-dark-gray">
                                                                <i class="feather icon-feather-plus"></i><span class="fw-500 fs-18">What if my item is damaged or faulty?</span>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div id="accordion-style-03-06" class="accordion-collapse collapse" data-bs-parent="#accordion-style-03">
                                                        <div class="accordion-body last-paragraph-no-margin border-bottom border-color-transparent">
                                                            <p>Lorem ipsum is simply dummy text of the printing and typesetting industry. Lorem ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took galley of type and scrambled to make type.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end accordion item -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end tab content -->
                                <!-- start tab content -->
                                <div class="tab-pane fade in h-100" id="tab_seven4">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="accordion accordion-style-02" id="accordion-style-04" data-active-icon="icon-feather-minus" data-inactive-icon="icon-feather-plus">
                                                <!-- start accordion item -->
                                                <div class="accordion-item active-accordion">
                                                    <div class="accordion-header border-bottom border-color-extra-medium-gray">
                                                        <a href="#" data-bs-toggle="collapse" data-bs-target="#accordion-style-04-01" aria-expanded="true" data-bs-parent="#accordion-style-04">
                                                            <div class="accordion-title mb-0 position-relative text-dark-gray">
                                                                <i class="feather icon-feather-minus"></i><span class="fw-500 fs-18">Can i order over the phone?</span>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div id="accordion-style-04-01" class="accordion-collapse collapse show" data-bs-parent="#accordion-style-04">
                                                        <div class="accordion-body last-paragraph-no-margin border-bottom border-color-extra-medium-gray">
                                                            <p>Lorem ipsum is simply dummy text of the printing and typesetting industry. Lorem ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took galley of type and scrambled to make type.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end accordion item -->
                                                <!-- start accordion item -->
                                                <div class="accordion-item">
                                                    <div class="accordion-header border-bottom border-color-extra-medium-gray">
                                                        <a href="#" data-bs-toggle="collapse" data-bs-target="#accordion-style-04-02" aria-expanded="false" data-bs-parent="#accordion-style-04">
                                                            <div class="accordion-title mb-0 position-relative text-dark-gray">
                                                                <i class="feather icon-feather-plus"></i><span class="fw-500 fs-18">I am having difficulty placing an order?</span>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div id="accordion-style-04-02" class="accordion-collapse collapse" data-bs-parent="#accordion-style-04">
                                                        <div class="accordion-body last-paragraph-no-margin border-bottom border-color-extra-medium-gray">
                                                            <p>Lorem ipsum is simply dummy text of the printing and typesetting industry. Lorem ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took galley of type and scrambled to make type.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end accordion item -->
                                                <!-- start accordion item -->
                                                <div class="accordion-item">
                                                    <div class="accordion-header border-bottom border-color-extra-medium-gray">
                                                        <a href="#" data-bs-toggle="collapse" data-bs-target="#accordion-style-04-03" aria-expanded="false" data-bs-parent="#accordion-style-04">
                                                            <div class="accordion-title mb-0 position-relative text-dark-gray">
                                                                <i class="feather icon-feather-plus"></i><span class="fw-500 fs-18">What payment methods does accept?</span>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div id="accordion-style-04-03" class="accordion-collapse collapse" data-bs-parent="#accordion-style-04">
                                                        <div class="accordion-body last-paragraph-no-margin border-bottom border-color-extra-medium-gray">
                                                            <p>Lorem ipsum is simply dummy text of the printing and typesetting industry. Lorem ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took galley of type and scrambled to make type.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end accordion item -->
                                                <!-- start accordion item -->
                                                <div class="accordion-item">
                                                    <div class="accordion-header border-bottom border-color-extra-medium-gray">
                                                        <a href="#" data-bs-toggle="collapse" data-bs-target="#accordion-style-04-04" aria-expanded="false" data-bs-parent="#accordion-style-04">
                                                            <div class="accordion-title mb-0 position-relative text-dark-gray">
                                                                <i class="feather icon-feather-plus"></i><span class="fw-500 fs-18">Can i amend my order once placed?</span>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div id="accordion-style-04-04" class="accordion-collapse collapse" data-bs-parent="#accordion-style-04">
                                                        <div class="accordion-body last-paragraph-no-margin border-bottom border-color-extra-medium-gray">
                                                            <p>Lorem ipsum is simply dummy text of the printing and typesetting industry. Lorem ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took galley of type and scrambled to make type.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end accordion item -->
                                                <!-- start accordion item -->
                                                <div class="accordion-item">
                                                    <div class="accordion-header border-bottom border-color-extra-medium-gray">
                                                        <a href="#" data-bs-toggle="collapse" data-bs-target="#accordion-style-04-05" aria-expanded="false" data-bs-parent="#accordion-style-04">
                                                            <div class="accordion-title mb-0 position-relative text-dark-gray">
                                                                <i class="feather icon-feather-plus"></i><span class="fw-500 fs-18">How do i know if my order was successful?</span>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div id="accordion-style-04-05" class="accordion-collapse collapse" data-bs-parent="#accordion-style-04">
                                                        <div class="accordion-body last-paragraph-no-margin border-bottom border-color-extra-medium-gray">
                                                            <p>Lorem ipsum is simply dummy text of the printing and typesetting industry. Lorem ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took galley of type and scrambled to make type.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end accordion item -->
                                                <!-- start accordion item -->
                                                <div class="accordion-item">
                                                    <div class="accordion-header border-bottom border-color-transparent">
                                                        <a href="#" data-bs-toggle="collapse" data-bs-target="#accordion-style-04-06" aria-expanded="false" data-bs-parent="#accordion-style-04">
                                                            <div class="accordion-title mb-0 position-relative text-dark-gray">
                                                                <i class="feather icon-feather-plus"></i><span class="fw-500 fs-18">What if my order is incorrect?</span>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div id="accordion-style-04-06" class="accordion-collapse collapse" data-bs-parent="#accordion-style-04">
                                                        <div class="accordion-body last-paragraph-no-margin border-bottom border-color-transparent">
                                                            <p>Lorem ipsum is simply dummy text of the printing and typesetting industry. Lorem ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took galley of type and scrambled to make type.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end accordion item -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end tab content -->
                                <!-- start tab content -->
                                <div class="tab-pane fade in h-100" id="tab_seven5">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="accordion accordion-style-02" id="accordion-style-05" data-active-icon="icon-feather-minus" data-inactive-icon="icon-feather-plus">
                                                <!-- start accordion item -->
                                                <div class="accordion-item active-accordion">
                                                    <div class="accordion-header border-bottom border-color-extra-medium-gray">
                                                        <a href="#" data-bs-toggle="collapse" data-bs-target="#accordion-style-05-01" aria-expanded="true" data-bs-parent="#accordion-style-05">
                                                            <div class="accordion-title mb-0 position-relative text-dark-gray">
                                                                <i class="feather icon-feather-minus"></i><span class="fw-500 fs-18">Can i order over the phone?</span>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div id="accordion-style-05-01" class="accordion-collapse collapse show" data-bs-parent="#accordion-style-05">
                                                        <div class="accordion-body last-paragraph-no-margin border-bottom border-color-extra-medium-gray">
                                                            <p>Lorem ipsum is simply dummy text of the printing and typesetting industry. Lorem ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took galley of type and scrambled to make type.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end accordion item -->
                                                <!-- start accordion item -->
                                                <div class="accordion-item">
                                                    <div class="accordion-header border-bottom border-color-extra-medium-gray">
                                                        <a href="#" data-bs-toggle="collapse" data-bs-target="#accordion-style-05-02" aria-expanded="false" data-bs-parent="#accordion-style-05">
                                                            <div class="accordion-title mb-0 position-relative text-dark-gray">
                                                                <i class="feather icon-feather-plus"></i><span class="fw-500 fs-18">I am having difficulty placing an order?</span>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div id="accordion-style-05-02" class="accordion-collapse collapse" data-bs-parent="#accordion-style-05">
                                                        <div class="accordion-body last-paragraph-no-margin border-bottom border-color-extra-medium-gray">
                                                            <p>Lorem ipsum is simply dummy text of the printing and typesetting industry. Lorem ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took galley of type and scrambled to make type.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end accordion item -->
                                                <!-- start accordion item -->
                                                <div class="accordion-item">
                                                    <div class="accordion-header border-bottom border-color-extra-medium-gray">
                                                        <a href="#" data-bs-toggle="collapse" data-bs-target="#accordion-style-05-03" aria-expanded="false" data-bs-parent="#accordion-style-05">
                                                            <div class="accordion-title mb-0 position-relative text-dark-gray">
                                                                <i class="feather icon-feather-plus"></i><span class="fw-500 fs-18">What payment methods does accept?</span>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div id="accordion-style-05-03" class="accordion-collapse collapse" data-bs-parent="#accordion-style-05">
                                                        <div class="accordion-body last-paragraph-no-margin border-bottom border-color-extra-medium-gray">
                                                            <p>Lorem ipsum is simply dummy text of the printing and typesetting industry. Lorem ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took galley of type and scrambled to make type.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end accordion item -->
                                                <!-- start accordion item -->
                                                <div class="accordion-item">
                                                    <div class="accordion-header border-bottom border-color-extra-medium-gray">
                                                        <a href="#" data-bs-toggle="collapse" data-bs-target="#accordion-style-05-04" aria-expanded="false" data-bs-parent="#accordion-style-05">
                                                            <div class="accordion-title mb-0 position-relative text-dark-gray">
                                                                <i class="feather icon-feather-plus"></i><span class="fw-500 fs-18">Can i amend my order once placed?</span>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div id="accordion-style-05-04" class="accordion-collapse collapse" data-bs-parent="#accordion-style-05">
                                                        <div class="accordion-body last-paragraph-no-margin border-bottom border-color-extra-medium-gray">
                                                            <p>Lorem ipsum is simply dummy text of the printing and typesetting industry. Lorem ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took galley of type and scrambled to make type.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end accordion item -->
                                                <!-- start accordion item -->
                                                <div class="accordion-item">
                                                    <div class="accordion-header border-bottom border-color-extra-medium-gray">
                                                        <a href="#" data-bs-toggle="collapse" data-bs-target="#accordion-style-05-05" aria-expanded="false" data-bs-parent="#accordion-style-05">
                                                            <div class="accordion-title mb-0 position-relative text-dark-gray">
                                                                <i class="feather icon-feather-plus"></i><span class="fw-500 fs-18">How do i know if my order was successful?</span>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div id="accordion-style-05-05" class="accordion-collapse collapse" data-bs-parent="#accordion-style-05">
                                                        <div class="accordion-body last-paragraph-no-margin border-bottom border-color-extra-medium-gray">
                                                            <p>Lorem ipsum is simply dummy text of the printing and typesetting industry. Lorem ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took galley of type and scrambled to make type.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end accordion item -->
                                                <!-- start accordion item -->
                                                <div class="accordion-item">
                                                    <div class="accordion-header border-bottom border-color-transparent">
                                                        <a href="#" data-bs-toggle="collapse" data-bs-target="#accordion-style-05-06" aria-expanded="false" data-bs-parent="#accordion-style-05">
                                                            <div class="accordion-title mb-0 position-relative text-dark-gray">
                                                                <i class="feather icon-feather-plus"></i><span class="fw-500 fs-18">What if my order is incorrect?</span>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div id="accordion-style-05-06" class="accordion-collapse collapse" data-bs-parent="#accordion-style-05">
                                                        <div class="accordion-body last-paragraph-no-margin border-bottom border-color-transparent">
                                                            <p>Lorem ipsum is simply dummy text of the printing and typesetting industry. Lorem ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took galley of type and scrambled to make type.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end accordion item -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end tab content -->
                                <!-- start tab content -->
                                <div class="tab-pane fade in h-100" id="tab_seven6">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="accordion accordion-style-02" id="accordion-style-06" data-active-icon="icon-feather-minus" data-inactive-icon="icon-feather-plus">
                                                <!-- start accordion item -->
                                                <div class="accordion-item active-accordion">
                                                    <div class="accordion-header border-bottom border-color-extra-medium-gray">
                                                        <a href="#" data-bs-toggle="collapse" data-bs-target="#accordion-style-06-01" aria-expanded="true" data-bs-parent="#accordion-style-06">
                                                            <div class="accordion-title mb-0 position-relative text-dark-gray">
                                                                <i class="feather icon-feather-minus"></i><span class="fw-500 fs-18">Can i order over the phone?</span>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div id="accordion-style-06-01" class="accordion-collapse collapse show" data-bs-parent="#accordion-style-06">
                                                        <div class="accordion-body last-paragraph-no-margin border-bottom border-color-extra-medium-gray">
                                                            <p>Lorem ipsum is simply dummy text of the printing and typesetting industry. Lorem ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took galley of type and scrambled to make type.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end accordion item -->
                                                <!-- start accordion item -->
                                                <div class="accordion-item">
                                                    <div class="accordion-header border-bottom border-color-extra-medium-gray">
                                                        <a href="#" data-bs-toggle="collapse" data-bs-target="#accordion-style-06-02" aria-expanded="false" data-bs-parent="#accordion-style-06">
                                                            <div class="accordion-title mb-0 position-relative text-dark-gray">
                                                                <i class="feather icon-feather-plus"></i><span class="fw-500 fs-18">I am having difficulty placing an order?</span>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div id="accordion-style-06-02" class="accordion-collapse collapse" data-bs-parent="#accordion-style-06">
                                                        <div class="accordion-body last-paragraph-no-margin border-bottom border-color-extra-medium-gray">
                                                            <p>Lorem ipsum is simply dummy text of the printing and typesetting industry. Lorem ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took galley of type and scrambled to make type.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end accordion item -->
                                                <!-- start accordion item -->
                                                <div class="accordion-item">
                                                    <div class="accordion-header border-bottom border-color-extra-medium-gray">
                                                        <a href="#" data-bs-toggle="collapse" data-bs-target="#accordion-style-06-03" aria-expanded="false" data-bs-parent="#accordion-style-06">
                                                            <div class="accordion-title mb-0 position-relative text-dark-gray">
                                                                <i class="feather icon-feather-plus"></i><span class="fw-500 fs-18">What payment methods does accept?</span>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div id="accordion-style-06-03" class="accordion-collapse collapse" data-bs-parent="#accordion-style-06">
                                                        <div class="accordion-body last-paragraph-no-margin border-bottom border-color-extra-medium-gray">
                                                            <p>Lorem ipsum is simply dummy text of the printing and typesetting industry. Lorem ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took galley of type and scrambled to make type.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end accordion item -->
                                                <!-- start accordion item -->
                                                <div class="accordion-item">
                                                    <div class="accordion-header border-bottom border-color-extra-medium-gray">
                                                        <a href="#" data-bs-toggle="collapse" data-bs-target="#accordion-style-06-04" aria-expanded="false" data-bs-parent="#accordion-style-06">
                                                            <div class="accordion-title mb-0 position-relative text-dark-gray">
                                                                <i class="feather icon-feather-plus"></i><span class="fw-500 fs-18">Can i amend my order once placed?</span>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div id="accordion-style-06-04" class="accordion-collapse collapse" data-bs-parent="#accordion-style-06">
                                                        <div class="accordion-body last-paragraph-no-margin border-bottom border-color-extra-medium-gray">
                                                            <p>Lorem ipsum is simply dummy text of the printing and typesetting industry. Lorem ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took galley of type and scrambled to make type.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end accordion item -->
                                                <!-- start accordion item -->
                                                <div class="accordion-item">
                                                    <div class="accordion-header border-bottom border-color-extra-medium-gray">
                                                        <a href="#" data-bs-toggle="collapse" data-bs-target="#accordion-style-06-05" aria-expanded="false" data-bs-parent="#accordion-style-06">
                                                            <div class="accordion-title mb-0 position-relative text-dark-gray">
                                                                <i class="feather icon-feather-plus"></i><span class="fw-500 fs-18">How do i know if my order was successful?</span>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div id="accordion-style-06-05" class="accordion-collapse collapse" data-bs-parent="#accordion-style-06">
                                                        <div class="accordion-body last-paragraph-no-margin border-bottom border-color-extra-medium-gray">
                                                            <p>Lorem ipsum is simply dummy text of the printing and typesetting industry. Lorem ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took galley of type and scrambled to make type.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end accordion item -->
                                                <!-- start accordion item -->
                                                <div class="accordion-item">
                                                    <div class="accordion-header border-bottom border-color-transparent">
                                                        <a href="#" data-bs-toggle="collapse" data-bs-target="#accordion-style-06-06" aria-expanded="false" data-bs-parent="#accordion-style-06">
                                                            <div class="accordion-title mb-0 position-relative text-dark-gray">
                                                                <i class="feather icon-feather-plus"></i><span class="fw-500 fs-18">What if my order is incorrect?</span>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div id="accordion-style-06-06" class="accordion-collapse collapse" data-bs-parent="#accordion-style-06">
                                                        <div class="accordion-body last-paragraph-no-margin border-bottom border-color-transparent">
                                                            <p>Lorem ipsum is simply dummy text of the printing and typesetting industry. Lorem ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took galley of type and scrambled to make type.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end accordion item -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end tab content -->
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- end section -->
@endsection
