@extends('layouts.layout')
@section('content')
    <!-- start section -->
    <section class="top-space-margin half-section bg-gradient-very-light-gray">
        <div class="container">
            <div class="row align-items-center justify-content-center"
                data-anime='{ "el": "childs", "translateY": [-15, 0], "opacity": [0,1], "duration": 300, "delay": 0, "staggervalue": 200, "easing": "easeOutQuad" }'>
                <div class="col-12 col-xl-8 col-lg-10 text-center position-relative page-title-extra-large">
                    <h1 class="alt-font fw-600 text-dark-gray mb-10px">Shopping cart</h1>
                </div>
                <div class="col-12 breadcrumb breadcrumb-style-01 d-flex justify-content-center">
                    <ul>
                        <li><a href="demo-fashion-store.html">Home</a></li>
                        <li>Shopping cart</li>
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
                                        <th scope="col" class="alt-font fw-600">Product</th>
                                        <th scope="col"></th>
                                        <th scope="col" class="alt-font fw-600">Price</th>
                                        <th scope="col" class="alt-font fw-600">Quantity</th>
                                        <th scope="col" class="alt-font fw-600">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="product-remove">
                                            <input type="checkbox" class="cart-item-checkbox">
                                        </td>
                                        <td class="product-thumbnail"><a
                                                href="demo-jewellery-store-single-product.html"><img
                                                    class="cart-product-image" src="https://placehold.co/600x765"
                                                    alt=""></a></td>
                                        <td class="product-name">
                                            <a href="demo-jewellery-store-single-product.html"
                                                class="text-dark-gray fw-500 d-block lh-initial">Textured sweater</a>
                                            <span class="fs-14">Color: Pink</span>
                                        </td>
                                        <td class="product-price" data-title="Price">$23.00</td>
                                        <td class="product-quantity" data-title="Quantity">
                                            <div class="quantity">
                                                <button type="button" class="qty-minus">-</button>
                                                <input class="qty-text" type="text" id="1" value="1"
                                                    aria-label="qty-text">
                                                <button type="button" class="qty-plus">+</button>
                                            </div>
                                        </td>
                                        <td class="product-subtotal" data-title="Total">$23.00</td>
                                    </tr>
                                    <tr>
                                        <td class="product-remove">
                                            <input type="checkbox" class="cart-item-checkbox">
                                        </td>
                                        <td class="product-thumbnail"><a
                                                href="demo-jewellery-store-single-product.html"><img
                                                    class="cart-product-image" src="https://placehold.co/600x765"
                                                    alt=""></a></td>
                                        <td class="product-name">
                                            <a href="demo-jewellery-store-single-product.html"
                                                class="text-dark-gray fw-500 d-block lh-initial">Bermuda shorts</a>
                                            <span class="fs-14">Color: Brown</span>
                                        </td>
                                        <td class="product-price" data-title="Price">$35.00</td>
                                        <td class="product-quantity" data-title="Quantity">
                                            <div class="quantity">
                                                <button type="button" class="qty-minus">-</button>
                                                <input class="qty-text" type="text" id="2" value="1"
                                                    aria-label="qty-text">
                                                <button type="button" class="qty-plus">+</button>
                                            </div>
                                        </td>
                                        <td class="product-subtotal" data-title="Total">$70.00</td>
                                    </tr>
                                    <tr>
                                        <td class="product-remove">
                                            <input type="checkbox" class="cart-item-checkbox">
                                        </td>
                                        <td class="product-thumbnail"><a
                                                href="demo-jewellery-store-single-product.html"><img
                                                    class="cart-product-image" src="https://placehold.co/600x765"
                                                    alt=""></a></td>
                                        <td class="product-name">
                                            <a href="demo-jewellery-store-single-product.html"
                                                class="text-dark-gray fw-500 d-block lh-initial">Pocket sweatshirt</a>
                                            <span class="fs-14">Color: White</span>
                                        </td>
                                        <td class="product-price" data-title="Price">$15.00</td>
                                        <td class="product-quantity" data-title="Quantity">
                                            <div class="quantity">
                                                <button type="button" class="qty-minus">-</button>
                                                <input class="qty-text" type="text" id="3" value="1"
                                                    aria-label="qty-text">
                                                <button type="button" class="qty-plus">+</button>
                                            </div>
                                        </td>
                                        <td class="product-subtotal" data-title="Total">$15.00</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row mt-20px">
                        <div class="col-xl-6 col-xxl-7 col-md-6">
                            <div class="coupon-code-panel mobile d-flex align-items-center d-block d-sm-none px-2 py-2"
                                style="background:#fff; border-radius:4px;">
                                <div class="flex-grow-1 text-start">Chọn tất cả</div>
                                <div class="text-end" style="min-width:48px;">
                                    <input type="checkbox" id="select-all-cart-mobile" class="cart-item-checkbox"
                                        style="width: 18px;">
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-xxl-7 col-md-6">
                            <div class="coupon-code-panel">
                                <input type="text" class="bg-white border-radius-4px" placeholder="Coupon code">
                                <a href="#" class="btn apply-coupon-btn fs-13 fw-600 text-uppercase">Apply</a>
                            </div>
                        </div>



                        <div class="col-xl-6 col-xxl-5 col-md-6 text-center text-md-end sm-mt-15px">
                            <a href="#"
                                class="btn btn-small border-1 btn-round-edge btn-transparent-light-gray text-transform-none me-15px lg-me-5px">Empty
                                cart</a>
                            <a href="#"
                                class="btn btn-small border-1 btn-round-edge btn-transparent-light-gray text-transform-none">Update
                                cart</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="bg-very-light-gray border-radius-6px p-50px xl-p-30px lg-p-25px">
                        <span class="fs-26 alt-font fw-600 text-dark-gray mb-5px d-block">Cart totals</span>
                        <table class="w-100 total-price-table">
                            <tbody>
                                <tr>
                                    <th class="w-45 fw-600 text-dark-gray alt-font">Subtotal</th>
                                    <td class="text-dark-gray fw-600">$405.00</td>
                                </tr>
                                <tr class="shipping">
                                    <th class="fw-600 text-dark-gray alt-font">Shipping</th>
                                    <td data-title="Shipping">
                                        <ul class="p-0 m-0">
                                            <li class="d-flex align-items-center">
                                                <input id="free_shipping" type="radio" name="shipping-option"
                                                    class="d-block w-auto mb-0 me-10px p-0" checked="checked">
                                                <label class="md-line-height-18px" for="free_shipping">Free
                                                    shipping</label>
                                            </li>
                                            <li class="d-flex align-items-center">
                                                <input id="flat" type="radio" name="shipping-option"
                                                    class="d-block w-auto mb-0 me-10px p-0">
                                                <label class="md-line-height-18px" for="flat">Flat: $12.00</label>
                                            </li>
                                            <li class="d-flex align-items-center">
                                                <input id="local_pickup" type="radio" name="shipping-option"
                                                    class="d-block w-auto mb-0 me-10px p-0">
                                                <label class="md-line-height-18px" for="local_pickup">Local pickup</label>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                                <tr class="calculate-shipping">
                                    <th colspan="2" class="fw-500">
                                        <a class="d-flex align-items-center calculate-shipping-title accordion-toggle"
                                            data-bs-toggle="collapse" href="#shipping-accordion" aria-expanded="false">
                                            <p class="fw-600 w-100 mb-0 text-dark-gray">Calculate shipping</p>
                                            <i
                                                class="feather icon-feather-chevron-down text-dark-gray icon-small align-middle"></i>
                                        </a>
                                        <div id="shipping-accordion" class="address-block collapse">
                                            <div class="mt-15px">
                                                <select class="form-select select-small mb-15px">
                                                    <option>Select a country</option>
                                                    <option value="Afganistan">Afghanistan</option>
                                                    <option value="Albania">Albania</option>
                                                    <option value="Algeria">Algeria</option>
                                                    <option value="American Samoa">American Samoa</option>
                                                    <option value="Andorra">Andorra</option>
                                                    <option value="Angola">Angola</option>
                                                    <option value="Anguilla">Anguilla</option>
                                                    <option value="Antigua &amp; Barbuda">Antigua &amp; Barbuda</option>
                                                    <option value="Argentina">Argentina</option>
                                                    <option value="Armenia">Armenia</option>
                                                    <option value="Aruba">Aruba</option>
                                                    <option value="Australia">Australia</option>
                                                    <option value="Austria">Austria</option>
                                                    <option value="Azerbaijan">Azerbaijan</option>
                                                    <option value="Bahamas">Bahamas</option>
                                                    <option value="Bahrain">Bahrain</option>
                                                    <option value="Bangladesh">Bangladesh</option>
                                                    <option value="Barbados">Barbados</option>
                                                    <option value="Belarus">Belarus</option>
                                                    <option value="Belgium">Belgium</option>
                                                    <option value="Belize">Belize</option>
                                                    <option value="Benin">Benin</option>
                                                    <option value="Bermuda">Bermuda</option>
                                                    <option value="Bhutan">Bhutan</option>
                                                    <option value="Bolivia">Bolivia</option>
                                                    <option value="Bonaire">Bonaire</option>
                                                    <option value="Bosnia &amp; Herzegovina">Bosnia &amp; Herzegovina
                                                    </option>
                                                    <option value="Botswana">Botswana</option>
                                                    <option value="Brazil">Brazil</option>
                                                    <option value="British Indian Ocean Ter">British Indian Ocean Ter
                                                    </option>
                                                    <option value="Brunei">Brunei</option>
                                                    <option value="Bulgaria">Bulgaria</option>
                                                    <option value="Burkina Faso">Burkina Faso</option>
                                                    <option value="Burundi">Burundi</option>
                                                    <option value="Cambodia">Cambodia</option>
                                                    <option value="Cameroon">Cameroon</option>
                                                    <option value="Canada">Canada</option>
                                                    <option value="Canary Islands">Canary Islands</option>
                                                    <option value="Cape Verde">Cape Verde</option>
                                                    <option value="Cayman Islands">Cayman Islands</option>
                                                    <option value="Central African Republic">Central African Republic
                                                    </option>
                                                    <option value="Chad">Chad</option>
                                                    <option value="Channel Islands">Channel Islands</option>
                                                    <option value="Chile">Chile</option>
                                                    <option value="China">China</option>
                                                    <option value="Christmas Island">Christmas Island</option>
                                                    <option value="Cocos Island">Cocos Island</option>
                                                    <option value="Colombia">Colombia</option>
                                                    <option value="Comoros">Comoros</option>
                                                    <option value="Congo">Congo</option>
                                                    <option value="Cook Islands">Cook Islands</option>
                                                    <option value="Costa Rica">Costa Rica</option>
                                                    <option value="Cote DIvoire">Cote DIvoire</option>
                                                    <option value="Croatia">Croatia</option>
                                                    <option value="Cuba">Cuba</option>
                                                    <option value="Curaco">Curacao</option>
                                                    <option value="Cyprus">Cyprus</option>
                                                    <option value="Czech Republic">Czech Republic</option>
                                                    <option value="Denmark">Denmark</option>
                                                    <option value="Djibouti">Djibouti</option>
                                                    <option value="Dominica">Dominica</option>
                                                    <option value="Dominican Republic">Dominican Republic</option>
                                                    <option value="East Timor">East Timor</option>
                                                    <option value="Ecuador">Ecuador</option>
                                                    <option value="Egypt">Egypt</option>
                                                    <option value="El Salvador">El Salvador</option>
                                                    <option value="Equatorial Guinea">Equatorial Guinea</option>
                                                    <option value="Eritrea">Eritrea</option>
                                                    <option value="Estonia">Estonia</option>
                                                    <option value="Ethiopia">Ethiopia</option>
                                                    <option value="Falkland Islands">Falkland Islands</option>
                                                    <option value="Faroe Islands">Faroe Islands</option>
                                                    <option value="Fiji">Fiji</option>
                                                    <option value="Finland">Finland</option>
                                                    <option value="France">France</option>
                                                    <option value="French Guiana">French Guiana</option>
                                                    <option value="French Polynesia">French Polynesia</option>
                                                    <option value="French Southern Ter">French Southern Ter</option>
                                                    <option value="Gabon">Gabon</option>
                                                    <option value="Gambia">Gambia</option>
                                                    <option value="Georgia">Georgia</option>
                                                    <option value="Germany">Germany</option>
                                                    <option value="Ghana">Ghana</option>
                                                    <option value="Gibraltar">Gibraltar</option>
                                                    <option value="Great Britain">Great Britain</option>
                                                    <option value="Greece">Greece</option>
                                                    <option value="Greenland">Greenland</option>
                                                    <option value="Grenada">Grenada</option>
                                                    <option value="Guadeloupe">Guadeloupe</option>
                                                    <option value="Guam">Guam</option>
                                                    <option value="Guatemala">Guatemala</option>
                                                    <option value="Guinea">Guinea</option>
                                                    <option value="Guyana">Guyana</option>
                                                    <option value="Haiti">Haiti</option>
                                                    <option value="Hawaii">Hawaii</option>
                                                    <option value="Honduras">Honduras</option>
                                                    <option value="Hong Kong">Hong Kong</option>
                                                    <option value="Hungary">Hungary</option>
                                                    <option value="Iceland">Iceland</option>
                                                    <option value="Indonesia">Indonesia</option>
                                                    <option value="India">India</option>
                                                    <option value="Iran">Iran</option>
                                                    <option value="Iraq">Iraq</option>
                                                    <option value="Ireland">Ireland</option>
                                                    <option value="Isle of Man">Isle of Man</option>
                                                    <option value="Israel">Israel</option>
                                                    <option value="Italy">Italy</option>
                                                    <option value="Jamaica">Jamaica</option>
                                                    <option value="Japan">Japan</option>
                                                    <option value="Jordan">Jordan</option>
                                                    <option value="Kazakhstan">Kazakhstan</option>
                                                    <option value="Kenya">Kenya</option>
                                                    <option value="Kiribati">Kiribati</option>
                                                    <option value="Korea North">Korea North</option>
                                                    <option value="Korea Sout">Korea South</option>
                                                    <option value="Kuwait">Kuwait</option>
                                                    <option value="Kyrgyzstan">Kyrgyzstan</option>
                                                    <option value="Laos">Laos</option>
                                                    <option value="Latvia">Latvia</option>
                                                    <option value="Lebanon">Lebanon</option>
                                                    <option value="Lesotho">Lesotho</option>
                                                    <option value="Liberia">Liberia</option>
                                                    <option value="Libya">Libya</option>
                                                    <option value="Liechtenstein">Liechtenstein</option>
                                                    <option value="Lithuania">Lithuania</option>
                                                    <option value="Luxembourg">Luxembourg</option>
                                                    <option value="Macau">Macau</option>
                                                    <option value="Macedonia">Macedonia</option>
                                                    <option value="Madagascar">Madagascar</option>
                                                    <option value="Malaysia">Malaysia</option>
                                                    <option value="Malawi">Malawi</option>
                                                    <option value="Maldives">Maldives</option>
                                                    <option value="Mali">Mali</option>
                                                    <option value="Malta">Malta</option>
                                                    <option value="Marshall Islands">Marshall Islands</option>
                                                    <option value="Martinique">Martinique</option>
                                                    <option value="Mauritania">Mauritania</option>
                                                    <option value="Mauritius">Mauritius</option>
                                                    <option value="Mayotte">Mayotte</option>
                                                    <option value="Mexico">Mexico</option>
                                                    <option value="Midway Islands">Midway Islands</option>
                                                    <option value="Moldova">Moldova</option>
                                                    <option value="Monaco">Monaco</option>
                                                    <option value="Mongolia">Mongolia</option>
                                                    <option value="Montserrat">Montserrat</option>
                                                    <option value="Morocco">Morocco</option>
                                                    <option value="Mozambique">Mozambique</option>
                                                    <option value="Myanmar">Myanmar</option>
                                                    <option value="Nambia">Nambia</option>
                                                    <option value="Nauru">Nauru</option>
                                                    <option value="Nepal">Nepal</option>
                                                    <option value="Netherland Antilles">Netherland Antilles</option>
                                                    <option value="Netherlands">Netherlands (Holland, Europe)</option>
                                                    <option value="Nevis">Nevis</option>
                                                    <option value="New Caledonia">New Caledonia</option>
                                                    <option value="New Zealand">New Zealand</option>
                                                    <option value="Nicaragua">Nicaragua</option>
                                                    <option value="Niger">Niger</option>
                                                    <option value="Nigeria">Nigeria</option>
                                                    <option value="Niue">Niue</option>
                                                    <option value="Norfolk Island">Norfolk Island</option>
                                                    <option value="Norway">Norway</option>
                                                    <option value="Oman">Oman</option>
                                                    <option value="Pakistan">Pakistan</option>
                                                    <option value="Palau Island">Palau Island</option>
                                                    <option value="Palestine">Palestine</option>
                                                    <option value="Panama">Panama</option>
                                                    <option value="Papua New Guinea">Papua New Guinea</option>
                                                    <option value="Paraguay">Paraguay</option>
                                                    <option value="Peru">Peru</option>
                                                    <option value="Phillipines">Philippines</option>
                                                    <option value="Pitcairn Island">Pitcairn Island</option>
                                                    <option value="Poland">Poland</option>
                                                    <option value="Portugal">Portugal</option>
                                                    <option value="Puerto Rico">Puerto Rico</option>
                                                    <option value="Qatar">Qatar</option>
                                                    <option value="Republic of Montenegro">Republic of Montenegro</option>
                                                    <option value="Republic of Serbia">Republic of Serbia</option>
                                                    <option value="Reunion">Reunion</option>
                                                    <option value="Romania">Romania</option>
                                                    <option value="Russia">Russia</option>
                                                    <option value="Rwanda">Rwanda</option>
                                                    <option value="St Barthelemy">St Barthelemy</option>
                                                    <option value="St Eustatius">St Eustatius</option>
                                                    <option value="St Helena">St Helena</option>
                                                    <option value="St Kitts-Nevis">St Kitts-Nevis</option>
                                                    <option value="St Lucia">St Lucia</option>
                                                    <option value="St Maarten">St Maarten</option>
                                                    <option value="St Pierre &amp; Miquelon">St Pierre &amp; Miquelon
                                                    </option>
                                                    <option value="St Vincent &amp; Grenadines">St Vincent &amp; Grenadines
                                                    </option>
                                                    <option value="Saipan">Saipan</option>
                                                    <option value="Samoa">Samoa</option>
                                                    <option value="Samoa American">Samoa American</option>
                                                    <option value="San Marino">San Marino</option>
                                                    <option value="Sao Tome &amp; Principe">Sao Tome &amp; Principe
                                                    </option>
                                                    <option value="Saudi Arabia">Saudi Arabia</option>
                                                    <option value="Senegal">Senegal</option>
                                                    <option value="Seychelles">Seychelles</option>
                                                    <option value="Sierra Leone">Sierra Leone</option>
                                                    <option value="Singapore">Singapore</option>
                                                    <option value="Slovakia">Slovakia</option>
                                                    <option value="Slovenia">Slovenia</option>
                                                    <option value="Solomon Islands">Solomon Islands</option>
                                                    <option value="Somalia">Somalia</option>
                                                    <option value="South Africa">South Africa</option>
                                                    <option value="Spain">Spain</option>
                                                    <option value="Sri Lanka">Sri Lanka</option>
                                                    <option value="Sudan">Sudan</option>
                                                    <option value="Suriname">Suriname</option>
                                                    <option value="Swaziland">Swaziland</option>
                                                    <option value="Sweden">Sweden</option>
                                                    <option value="Switzerland">Switzerland</option>
                                                    <option value="Syria">Syria</option>
                                                    <option value="Tahiti">Tahiti</option>
                                                    <option value="Taiwan">Taiwan</option>
                                                    <option value="Tajikistan">Tajikistan</option>
                                                    <option value="Tanzania">Tanzania</option>
                                                    <option value="Thailand">Thailand</option>
                                                    <option value="Togo">Togo</option>
                                                    <option value="Tokelau">Tokelau</option>
                                                    <option value="Tonga">Tonga</option>
                                                    <option value="Trinidad &amp; Tobago">Trinidad &amp; Tobago</option>
                                                    <option value="Tunisia">Tunisia</option>
                                                    <option value="Turkey">Turkey</option>
                                                    <option value="Turkmenistan">Turkmenistan</option>
                                                    <option value="Turks &amp; Caicos Is">Turks &amp; Caicos Is</option>
                                                    <option value="Tuvalu">Tuvalu</option>
                                                    <option value="Uganda">Uganda</option>
                                                    <option value="United Kingdom">United Kingdom</option>
                                                    <option value="Ukraine">Ukraine</option>
                                                    <option value="United Arab Erimates">United Arab Emirates</option>
                                                    <option value="United States of America">United States of America
                                                    </option>
                                                    <option value="Uraguay">Uruguay</option>
                                                    <option value="Uzbekistan">Uzbekistan</option>
                                                    <option value="Vanuatu">Vanuatu</option>
                                                    <option value="Vatican City State">Vatican City State</option>
                                                    <option value="Venezuela">Venezuela</option>
                                                    <option value="Vietnam">Vietnam</option>
                                                    <option value="Virgin Islands (Brit)">Virgin Islands (Brit)</option>
                                                    <option value="Virgin Islands (USA)">Virgin Islands (USA)</option>
                                                    <option value="Wake Island">Wake Island</option>
                                                    <option value="Wallis &amp; Futana Is">Wallis &amp; Futana Is</option>
                                                    <option value="Yemen">Yemen</option>
                                                    <option value="Zaire">Zaire</option>
                                                    <option value="Zambia">Zambia</option>
                                                    <option value="Zimbabwe">Zimbabwe</option>
                                                </select>
                                                <select class="form-select select-small mb-15px">
                                                    <option>Select state</option>
                                                </select>
                                                <input type="text" name="city"
                                                    class="input-small border-radius-4px mb-15px" placeholder="Town/City">
                                                <input type="text" name="zip"
                                                    class="input-small border-radius-4px mb-15px" placeholder="ZIP">
                                                <a href="#"
                                                    class="btn btn-small btn-box-shadow btn-round-edge btn-dark-gray w-100">Update</a>
                                            </div>
                                        </div>
                                    </th>
                                </tr>
                                <tr class="total-amount">
                                    <th class="fw-600 text-dark-gray alt-font pb-0">Total</th>
                                    <td class="pb-0" data-title="Total">
                                        <h6 class="d-block fw-700 mb-0 text-dark-gray alt-font">$405.00</h6>
                                        <span class="fs-14">(Includes $19.29 tax)</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <a href="checkout"
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
