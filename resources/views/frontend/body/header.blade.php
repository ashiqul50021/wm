<style>
    .btn,
    .button {
        padding: 12px 30px !important;
    }

    .form-control[type=file]:not(:disabled):not([readonly]) {
        height: 40px !important;
    }
</style>
<header class="header-area header-style-1 header-height-2">
    <div class="header-top header-top-ptb-1 d-none d-lg-block">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-4">
                    <div class="header-info">
                        <ul>
                            <li class="contact_header">Need help? Call Us: <strong class="text-brand"> <a
                                        class="ms-2" href="tel:{{ get_setting('phone')->value ?? 'null' }}"><i
                                            class="fa fa-phone ms-1"></i>
                                        {{ get_setting('phone')->value ?? 'null' }}</a></strong></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="text-center">
                        <div id="news-flash" class="d-inline-block">
                            <ul>
                                <li>100% Secure delivery without contacting the courier</li>
                                <li>Supper Value Deals - Save more with coupons</li>
                                <li>Trendy 25silver jewelry, save up 35% off today</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="header-info header-info-right">

                        <ul>
                            <li><a href="#" class="" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal">Apply as Dealer</a></li>
                            <li><a href="#" class="" data-bs-toggle="modal"
                                    data-bs-target="#exampleVendor">Apply as Vendor</a></li>
                                    <li><a href="#" class="" data-bs-toggle="modal"
                                        data-bs-target="#exampleSeller">Apply as Seller</a></li>
                            <li><a href="#">Order Tracking</a></li>
                            <li>
                                @if (session()->get('language') == 'bangla')
                                    <a class="language-dropdown-active"
                                        href="{{ route('english.language') }}">English</a>
                                @else
                                    <a class="language-dropdown-active" href="{{ route('bangla.language') }}">বাংলা</a>
                                @endif
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="d-lg-block sticky-bar">
        <div class="header-middle header-middle-ptb-1 d-none d-lg-block">
            <div class="container">
                <div class="header-wrap">
                    <div class="logo logo-width-1">
                        <a href="{{ route('home') }}">
                            @php
                                $logo = get_setting('site_logo');
                            @endphp
                            @if ($logo != null)
                                <img src="{{ asset(get_setting('site_logo')->value ?? 'null') }}"
                                    alt="{{ env('APP_NAME') }}">
                            @else
                                <img src="{{ asset('upload/no_image.jpg') }}" alt="{{ env('APP_NAME') }}"
                                    style="height: 60px !important; width: 80px !important; min-width: 80px !important;">
                            @endif
                        </a>
                    </div>
                    <div class="header-right">
                        <div class="search-style-2">
                            <div class="search-area">
                                <form action="{{ route('product.search') }}" method="post" class="mx-auto">
                                    <input class="search-field search" onfocus="search_result_show()"
                                        onblur="search_result_hide()" name="search" placeholder="Search here..." />
                                    <div>
                                        <button type="submit"
                                            class="bg-brand btn btn-primary text-white btn-sm rounded-0"><i
                                                class="fa-solid fa-magnifying-glass"></i></button>
                                    </div>
                                </form>
                            </div>
                            <div class="shadow-lg searchProducts"></div>
                        </div>
                        <div class="header-action-right">
                            <div class="header-action-2">
                                <div class="header-action-2 cart_hidden_mobile me-2">
                                    <div class="header-action-icon-2">
                                        <a class="mini-cart-icon" href="#">
                                            <img alt="Nest"
                                                src="{{ asset('frontend/assets/imgs/theme/icons/icon-cart.svg') }}" />
                                            <span class="pro-count blue cartQty"></span>
                                        </a>
                                        <a href="{{ route('cart.show') }}"><span class="lable">Cart</span></a>
                                        <div class="cart-dropdown-wrap cart-dropdown-hm2">
                                            <div id="miniCart">

                                            </div>
                                            <div class="shopping-cart-footer" id="miniCart_btn">
                                                <div class="shopping-cart-total">
                                                    <h4>Total <span id="cartSubTotal"></span></h4>
                                                </div>
                                                <div class="shopping-cart-button">
                                                    <a href="{{ route('cart.show') }}" class="outline">View cart</a>
                                                    <a href="{{ route('checkout') }}">Checkout</a>
                                                </div>
                                            </div>
                                            <div class="shopping-cart-footer" id="miniCart_empty_btn">

                                                <div class="shopping-cart-button d-flex flex-row-reverse">
                                                    <a href="{{ route('home') }}">Continue Shopping </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="header-action-icon-2">
                                    @auth
                                        <a href="#">
                                            <img class="svgInject" alt="Nest"
                                                src="{{ asset('frontend/assets/imgs/theme/icons/icon-user.svg') }}" />
                                        </a>
                                        <a href="{{ route('dashboard') }}"><span class="lable ml-0">Account</span></a>
                                        <div class="cart-dropdown-wrap cart-dropdown-hm2 account-dropdown">
                                            <ul>
                                                <li>
                                                    <a href="{{ route('dashboard') }}"><i
                                                            class="fi fi-rs-user mr-10"></i>My Account</a>
                                                </li>
                                                <li>
                                                    <a class=" mr-10" href="{{ route('logout') }}"
                                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                        <i class="fi-rs-sign-out mr-10"></i>
                                                        {{ __('Logout') }}
                                                    </a>
                                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                        class="d-none">
                                                        @csrf
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    @endauth
                                    @guest
                                        <a href="{{ route('login') }}"><span class="lable ml-0"><i
                                                    class="fa-solid fa-arrow-right-to-bracket mr-10"></i>Login</span></a>
                                    @endguest

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-bottom header-bottom-bg-color">
            <div class="container">
                <div class="header-wrap header-space-between position-relative">
                    <div class="logo logo-width-1 d-block d-lg-none">
                        <a href="{{ route('home') }}">
                            @php
                                $logo = get_setting('site_logo');
                            @endphp
                            @if ($logo != null)
                                <img src="{{ asset(get_setting('site_logo')->value ?? 'null') }}"
                                    alt="{{ env('APP_NAME') }}">
                            @else
                                <img src="{{ asset('upload/no_image.jpg') }}" alt="{{ env('APP_NAME') }}"
                                    style="height: 60px !important; width: 80px !important; min-width: 80px !important;">
                            @endif
                        </a>
                    </div>
                    <div class="header-nav d-none d-lg-flex header-auth-nav">
                        <div class="main-categori-wrap d-none d-lg-block">
                            <a class="categories-button-active" href="#">
                                <span class="fi-rs-apps"></span> <span class="et">Browse</span>
                                <span>Categories</span>
                                <i class="fi-rs-angle-down"></i>
                            </a>
                            <div class="categories-dropdown-wrap categories-dropdown-active-large font-heading">
                                <div class="d-flex categori-dropdown-inner">
                                    <ul style="width: 100%;">
                                        @foreach (get_categories()->take(8) as $cat)
                                            <li style="width: 45%; float: left;">
                                                <a href="{{ route('product.category', $cat->slug) }}">
                                                    <img src="{{ asset($cat->image) }}" alt="">
                                                    @if (session()->get('language') == 'bangla')
                                                        {{ $cat->name_bn }}
                                                    @else
                                                        {{ $cat->name_en }}
                                                    @endif
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                                <a href="{{ route('category_list.index') }}" class="more_categories"><span
                                        class="heading-sm-1">View More Categories</span></a>
                            </div>
                        </div>
                        <div class="main-menu main-menu-padding-1 main-menu-lh-2 d-none d-lg-block font-heading">
                            <nav>
                                <ul>
                                    <li>
                                        <a href="{{ route('home') }}">
                                            @if (session()->get('language') == 'bangla')
                                                হোম
                                            @else
                                                Home
                                            @endif
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('product.show') }}">
                                            @if (session()->get('language') == 'bangla')
                                                দোকান
                                            @else
                                                Shop
                                            @endif
                                        </a>
                                    </li>

                                    <!-- Start Mega Menu -->
                                    @foreach (get_categories()->take(5) as $category)
                                        @if ($category->has_sub_sub > 0)
                                            <li class="position-static">
                                                <a href="{{ route('product.category', $category->slug) }}">
                                                    @if (session()->get('language') == 'bangla')
                                                        {{ $category->name_bn }}
                                                    @else
                                                        {{ $category->name_en }}
                                                    @endif
                                                    @if ($category->sub_categories && count($category->sub_categories) > 0)
                                                        <i class="fi-rs-angle-down"></i>
                                                    @endif
                                                </a>
                                                @if ($category->sub_categories && count($category->sub_categories) > 0)
                                                    <ul class="mega-menu">
                                                        @foreach ($category->sub_categories as $sub_category)
                                                            <li class="sub-mega-menu sub-mega-menu-width-22">
                                                                <a class="menu-title"
                                                                    href="{{ route('product.category', $sub_category->slug) }}">
                                                                    @if (session()->get('language') == 'bangla')
                                                                        {{ $sub_category->name_bn }}
                                                                    @else
                                                                        {{ $sub_category->name_en }}
                                                                    @endif
                                                                </a>
                                                                @if ($sub_category->sub_sub_categories && count($sub_category->sub_sub_categories) > 0)
                                                                    <ul>
                                                                        @foreach ($sub_category->sub_sub_categories as $sub_sub_category)
                                                                            <li><a
                                                                                    href="{{ route('product.category', $sub_sub_category->slug) }}">
                                                                                    @if (session()->get('language') == 'bangla')
                                                                                        {{ $sub_sub_category->name_bn }}
                                                                                    @else
                                                                                        {{ $sub_sub_category->name_en }}
                                                                                    @endif
                                                                                </a></li>
                                                                        @endforeach
                                                                    </ul>
                                                                @endif
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </li>
                                        @else
                                            <li>
                                                <a href="{{ route('product.category', $category->slug) }}">
                                                    @if (session()->get('language') == 'bangla')
                                                        {{ $category->name_bn }}
                                                    @else
                                                        {{ $category->name_en }}
                                                    @endif
                                                    @if ($category->sub_categories && count($category->sub_categories) > 0)
                                                        <i class="fi-rs-angle-down"></i>
                                                    @endif
                                                </a>

                                                @if ($category->sub_categories && count($category->sub_categories) > 0)
                                                    <ul class="sub-menu">
                                                        @foreach ($category->sub_categories as $sub_category)
                                                            <li><a
                                                                    href="{{ route('product.category', $sub_category->slug) }}">{{ $sub_category->name_en }}</a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </li>
                                        @endif
                                    @endforeach

                                    <!-- End Mega Menu -->
                                </ul>
                            </nav>
                        </div>
                        <div class="header-action-right d-none sticky-visible">
                            <div class="header-action-2">
                                <div class="header-action-2 cart_hidden_mobile me-2">
                                    <div class="header-action-icon-2">
                                        <a class="mini-cart-icon" href="#">
                                            <img alt="Nest"
                                                src="{{ asset('frontend/assets/imgs/theme/icons/icon-cart.svg') }}" />
                                            <span class="pro-count blue cartQty"></span>
                                        </a>
                                        <a href="{{ route('cart.show') }}"><span class="lable">Cart</span></a>
                                        <div class="cart-dropdown-wrap cart-dropdown-hm2">
                                            <div id="miniCart">

                                            </div>
                                            <div class="shopping-cart-footer" id="miniCart_btn">
                                                <div class="shopping-cart-total">
                                                    <h4>Total <span id="cartSubTotal"></span></h4>
                                                </div>
                                                <div class="shopping-cart-button">
                                                    <a href="{{ route('cart.show') }}" class="outline">View cart</a>
                                                    <a href="{{ route('checkout') }}">Checkout</a>
                                                </div>
                                            </div>
                                            <div class="shopping-cart-footer" id="miniCart_empty_btn">

                                                <div class="shopping-cart-button d-flex flex-row-reverse">
                                                    <a href="{{ route('home') }}">Continue Shopping</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="header-action-icon-2">
                                    @auth
                                        <a href="#">
                                            <img class="svgInject" alt="Nest"
                                                src="{{ asset('frontend/assets/imgs/theme/icons/icon-user.svg') }}" />
                                        </a>
                                        <a href="{{ route('dashboard') }}"><span class="lable ml-0">Account</span></a>
                                        <div class="cart-dropdown-wrap cart-dropdown-hm2 account-dropdown">
                                            <ul>
                                                <li>
                                                    <a href="{{ route('dashboard') }}"><i
                                                            class="fi fi-rs-user mr-10"></i>My Account</a>
                                                </li>
                                                <li>
                                                    <a class=" mr-10" href="{{ route('logout') }}"
                                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                        <i class="fi-rs-sign-out mr-10"></i>
                                                        {{ __('Logout') }}
                                                    </a>
                                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                        class="d-none">
                                                        @csrf
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    @endauth
                                    @guest
                                        <a href="{{ route('login') }}"><span class="lable ml-0"><i
                                                    class="fa-solid fa-arrow-right-to-bracket mr-10"></i>Login</span></a>
                                    @endguest

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="header-action-icon-2 d-block d-lg-none">
                        <div class="burger-icon burger-icon-white">
                            <span class="burger-icon-top"></span>
                            <span class="burger-icon-mid"></span>
                            <span class="burger-icon-bottom"></span>
                        </div>
                    </div>
                    <div class="header-action-right d-block d-lg-none">
                        <div class="header-action-2">
                            <!--Mobile Header Search start-->
                            <a class="p-2 d-block text-reset active show">
                                <i class="fas fa-search la-flip-horizontal la-2x"></i>
                            </a>

                            <section class="advance-search" style="display: none;">
                                <div class="search-box">
                                    <form action="{{ route('product.search') }}" method="post">
                                        @csrf
                                        <div class="input-group py-2">
                                            <span class="back_left hide"><i
                                                    class="fas fa-long-arrow-left me-2"></i></span>
                                            <input class="header-search form-control search-field search"
                                                aria-label="Input group example" aria-describedby="btnGroupAddon"
                                                onfocus="search_result_show()" onblur="search_result_hide()"
                                                name="search" placeholder="Search here..." />
                                            <button type="submit" class="input-group-text btn btn-sm"
                                                id="btnGroupAddon"><i class="fas fa-search"></i></button>
                                        </div>
                                    </form>
                                    <div class="shadow-lg searchProducts"></div>
                                </div>
                            </section>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="header-bottom-1 header-bottom-bg-color sticky-bar d-lg-none">
        <div class="container">
            <ul class="mobile-hor-swipe header-wrap header-space-between position-relative">
                @foreach (get_categories() as $category)
                    <li class="mb-10">
                        <a class="p-10" href="{{ route('product.category', $category->slug) }}">
                            @if (session()->get('language') == 'bangla')
                                {{ $category->name_bn }}
                            @else
                                {{ $category->name_en }}
                            @endif
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</header>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    <div class="heading_s1">
                        <h5 class="mb-5">Apply as a Dealer</h1>
                    </div>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="page-content pt-10 pb-10">
                    <div class="container">
                        <div class="row">
                            <div class="col-xl-10 col-lg-10 col-md-12 m-auto">
                                <div class="login_wrap widget-taber-content background-white">
                                    <div class="padding_eight_all bg-white">
                                        <form method="POST" action="{{ route('dealerApply') }}"
                                            class="needs-validation" novalidate enctype="multipart/form-data">
                                            @csrf
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label for="dealer_name" class="fw-900">Name : *</label>
                                                    <input type="text" name="name" placeholder="Name"
                                                        id="dealer_name" value="{{ old('name') }}" required />
                                                    @error('name')
                                                        <div class="text-danger" style="font-weight: bold;">
                                                            {{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="dealer_phone" class="fw-900">Phone Number : *</label>
                                                    <input type="number" name="phone" id="dealer_phone"
                                                        placeholder="Phone Number" value="{{ old('phone') }}"
                                                        required />
                                                    @error('phone')
                                                        <div class="text-danger" style="font-weight: bold;">
                                                            {{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="dealer_email" class="fw-900">Email : *</label>
                                                    <input type="email" name="email" id="dealer_email"
                                                        placeholder="Email" value="{{ old('email') }}" required />
                                                    @error('email')
                                                        <div class="text-danger" style="font-weight: bold;">
                                                            {{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="dealer_address" class="col-form-label col-md-4"
                                                        style="font-weight: bold;">Address : <span
                                                            class="text-danger">*</span></label>
                                                    <input class="form-control" id="dealer_address" type="text"
                                                        name="address" placeholder="Write dealer address"
                                                        value="{{ old('address') }}">
                                                    @error('address')
                                                        <p class="text-danger">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="dealer_bank_name" class="fw-900">Bank Name : </label>
                                                    <input type="text" name="bank_name" id="dealer_bank_name"
                                                        placeholder="Bank Name" value="{{ old('bank_name') }}" />
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="dealer_bank_account" class="fw-900">Bank Account No :
                                                    </label>
                                                    <input type="text" name="bank_account"
                                                        id="dealer_bank_account" placeholder="Bank Account No"
                                                        value="{{ old('bank_account') }}" />
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label for="dealer_description" class="col-form-label col-md-4"
                                                        style="font-weight: bold;">Description :</label>
                                                    <textarea name="description" id="dealer_description" cols="5" placeholder="Write dealer description"
                                                        class="form-control ">{{ old('description') }}</textarea>
                                                </div>

                                                <div class="form-group col-md-6">
                                                    <div class="form-group">
                                                        <img id="showImage5" class="rounded avatar-lg"
                                                            src="{{ !empty($editData->profile_image) ? url('upload/admin_images/' . $editData->profile_image) : url('upload/no_image.jpg') }}"
                                                            alt="Card image cap" width="100px" height="80px;">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="image5" class="col-form-label"
                                                            style="font-weight: bold;">Profile Photo: <span
                                                                class="text-danger">*</span></label>
                                                        <input name="profile_photo" class="form-control"
                                                            type="file" id="image5">
                                                        @error('profile_photo')
                                                            <p class="text-danger">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="form-group col-md-6">
                                                    <div class="form-group">
                                                        <img id="showImage6" class="rounded avatar-lg"
                                                            src="{{ !empty($editData->profile_image) ? url('upload/admin_images/' . $editData->profile_image) : url('upload/no_image.jpg') }}"
                                                            alt="Card image cap" width="100px" height="80px;">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="image6" class="col-form-label"
                                                            style="font-weight: bold;">Bank Information: <span
                                                                class="text-danger">*</span></label>
                                                        <input name="bank_information" class="form-control"
                                                            type="file" id="image6">
                                                        @error('bank_information')
                                                            <p class="text-danger">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <div class="form-group">
                                                        <img id="showImage7" class="rounded avatar-lg"
                                                            src="{{ !empty($editData->profile_image) ? url('upload/admin_images/' . $editData->profile_image) : url('upload/no_image.jpg') }}"
                                                            alt="Card image cap" width="100px" height="80px;">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="image7" class="col-form-label"
                                                            style="font-weight: bold;">Nid Card:</label>
                                                        <input name="nid" class="form-control" type="file"
                                                            id="image7">
                                                    </div>
                                                </div>

                                                <div class="form-group col-md-6">
                                                    <div class="form-group">
                                                        <img id="showImage8" class="rounded avatar-lg"
                                                            src="{{ !empty($editData->profile_image) ? url('upload/admin_images/' . $editData->profile_image) : url('upload/no_image.jpg') }}"
                                                            alt="Card image cap" width="100px" height="80px;">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="image8" class="col-form-label"
                                                            style="font-weight: bold;">Trade license:</label>
                                                        <input name="trade_license" class="form-control"
                                                            type="file" id="image8">
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="password" class="fw-900">Password : *</label>
                                                    <input type="password" name="password" placeholder="Password"
                                                        id="password" autocomplete="new-password" required />
                                                    <span>password must be at least 8 characters</span>
                                                    @error('password')
                                                        <div class="text-danger" style="font-weight: bold;">
                                                            {{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label class="fw-900">Confirm password : *</label>
                                                    <input type="password" placeholder="Confirm password"
                                                        name="password_confirmation" required />
                                                    @error('password')
                                                        <div class="text-danger" style="font-weight: bold;">
                                                            {{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="login_footer form-group mb-50">
                                                    <div class="chek-form">
                                                        <div class="custome-checkbox">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="checkbox" id="exampleCheckbox12" value=""
                                                                required />
                                                            <label class="form-check-label"
                                                                for="exampleCheckbox12"><span>I agree to terms &amp;
                                                                    Policy.</span></label>
                                                        </div>
                                                    </div>
                                                    <a href="#"><i
                                                            class="fi-rs-book-alt mr-5 text-muted"></i>Lean more</a>
                                                </div>
                                                <div class="form-group mb-30">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary"
                                                        name="login">Submit &amp; Register</button>
                                                </div>
                                                <p class="font-xs text-muted"><strong>Note:</strong>Your personal data
                                                    will be used to support your experience throughout this website, to
                                                    manage access to your account, and for other purposes described in
                                                    our privacy policy</p>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleVendor" tabindex="-1" aria-labelledby="exampleVendorLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleVendorLabel">
                    <div class="heading_s1">
                        <h5 class="mb-5">Apply as a Vendor</h1>
                    </div>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="page-content pt-10 pb-10">
                    <div class="container">
                        <div class="row">
                            <div class="col-xl-10 col-lg-10 col-md-12 m-auto">
                                <div class="login_wrap widget-taber-content background-white">
                                    <div class="padding_eight_all bg-white">
                                        <form method="POST" action="{{ route('vendorApply') }}"
                                            class="needs-validation" novalidate enctype="multipart/form-data">
                                            @csrf
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label for="shop_name" class="col-form-label col-md-4"
                                                        style="font-weight: bold;"> Shop Name : <span
                                                            class="text-danger">*</span></label>
                                                    <input class="form-control" id="shop_name" type="text"
                                                        name="shop_name" placeholder="Write dealer shop name"
                                                        value="{{ old('shop_name') }}">
                                                    @error('shop_name')
                                                        <p class="text-danger">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="phone" class="fw-900">Phone Number : *</label>
                                                    <input type="number" name="phone" id="phone"
                                                        placeholder="Phone Number" value="{{ old('phone') }}"
                                                        required />
                                                    @error('phone')
                                                        <div class="text-danger" style="font-weight: bold;">
                                                            {{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="email" class="fw-900">Email : *</label>
                                                    <input type="email" name="email" id="email"
                                                        placeholder="Email" value="{{ old('email') }}" required />
                                                    @error('email')
                                                        <div class="text-danger" style="font-weight: bold;">
                                                            {{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="address" class="col-form-label col-md-4"
                                                        style="font-weight: bold;">Address : <span
                                                            class="text-danger">*</span></label>
                                                    <input class="form-control" id="address" type="text"
                                                        name="address" placeholder="Write dealer address"
                                                        value="{{ old('address') }}">
                                                    @error('address')
                                                        <p class="text-danger">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label for="description" class="col-form-label col-md-4"
                                                        style="font-weight: bold;">Description :</label>
                                                    <textarea name="description" id="description" cols="5" placeholder="Write dealer description"
                                                        class="form-control ">{{ old('description') }}</textarea>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <div class="form-group">
                                                        <img id="showImage" class="rounded avatar-lg"
                                                            src="{{ !empty($editData->profile_image) ? url('upload/admin_images/' . $editData->profile_image) : url('upload/no_image.jpg') }}"
                                                            alt="Card image cap" width="100px" height="80px;">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="image" class="col-form-label"
                                                            style="font-weight: bold;">Shop Profile: <span
                                                                class="text-danger">*</span></label>
                                                        <input name="shop_profile" class="form-control"
                                                            type="file" id="image">
                                                        @error('shop_profile')
                                                            <p class="text-danger">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="form-group col-md-6">
                                                    <div class="form-group">
                                                        <img id="showImage2" class="rounded avatar-lg"
                                                            src="{{ !empty($editData->profile_image) ? url('upload/admin_images/' . $editData->profile_image) : url('upload/no_image.jpg') }}"
                                                            alt="Card image cap" width="100px" height="80px;">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="image2" class="col-form-label"
                                                            style="font-weight: bold;">Shop Cover Photo: <span
                                                                class="text-danger">*</span></label>
                                                        <input name="shop_cover" class="form-control" type="file"
                                                            id="image2">
                                                        @error('shop_cover')
                                                            <p class="text-danger">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <div class="form-group">
                                                        <img id="showImage3" class="rounded avatar-lg"
                                                            src="{{ !empty($editData->profile_image) ? url('upload/admin_images/' . $editData->profile_image) : url('upload/no_image.jpg') }}"
                                                            alt="Card image cap" width="100px" height="80px;">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="image3" class="col-form-label"
                                                            style="font-weight: bold;">Nid Card:</label>
                                                        <input name="nid" class="form-control" type="file"
                                                            id="image3">
                                                    </div>
                                                </div>

                                                <div class="form-group col-md-6">
                                                    <div class="form-group">
                                                        <img id="showImage4" class="rounded avatar-lg"
                                                            src="{{ !empty($editData->profile_image) ? url('upload/admin_images/' . $editData->profile_image) : url('upload/no_image.jpg') }}"
                                                            alt="Card image cap" width="100px" height="80px;">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="image4" class="col-form-label"
                                                            style="font-weight: bold;">Trade license:</label>
                                                        <input name="trade_license" class="form-control"
                                                            type="file" id="image4">
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="password" class="fw-900">Password : *</label>
                                                    <input type="password" name="password" placeholder="Password"
                                                        id="password" autocomplete="new-password" required />
                                                    <span>password must be at least 8 characters</span>
                                                    @error('password')
                                                        <div class="text-danger" style="font-weight: bold;">
                                                            {{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label class="fw-900">Confirm password : *</label>
                                                    <input type="password" placeholder="Confirm password"
                                                        name="password_confirmation" required />
                                                    @error('password')
                                                        <div class="text-danger" style="font-weight: bold;">
                                                            {{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="login_footer form-group mb-50">
                                                    <div class="chek-form">
                                                        <div class="custome-checkbox">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="checkbox" id="exampleCheckbox12" value=""
                                                                required />
                                                            <label class="form-check-label"
                                                                for="exampleCheckbox12"><span>I agree to terms &amp;
                                                                    Policy.</span></label>
                                                        </div>
                                                    </div>
                                                    <a href="#"><i
                                                            class="fi-rs-book-alt mr-5 text-muted"></i>Lean more</a>
                                                </div>
                                                <div class="form-group mb-30">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary"
                                                        name="login">Submit &amp; Register</button>
                                                </div>
                                                <p class="font-xs text-muted"><strong>Note:</strong>Your personal data
                                                    will be used to support your experience throughout this website, to
                                                    manage access to your account, and for other purposes described in
                                                    our privacy policy</p>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Seller Modal -->
<div class="modal fade" id="exampleSeller" tabindex="-1" aria-labelledby="exampleVendorLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleVendorLabel">
                    <div class="heading_s1">
                        <h5 class="mb-5">Apply as a Seller</h1>
                    </div>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="page-content pt-10 pb-10">
                    <div class="container">
                        <div class="row">
                            <div class="col-xl-10 col-lg-10 col-md-12 m-auto">
                                <div class="login_wrap widget-taber-content background-white">
                                    <div class="padding_eight_all bg-white">
                                        <form method="POST" action="{{ route('sellerApply') }}"
                                            class="needs-validation" novalidate enctype="multipart/form-data">
                                            @csrf
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label for="shop_name" class="col-form-label col-md-4"
                                                        style="font-weight: bold;"> Shop Name : <span
                                                            class="text-danger">*</span></label>
                                                    <input class="form-control" id="shop_name" type="text"
                                                        name="shop_name" placeholder="Write dealer shop name"
                                                        value="{{ old('shop_name') }}">
                                                    @error('shop_name')
                                                        <p class="text-danger">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="phone" class="fw-900">Phone Number : *</label>
                                                    <input type="number" name="phone" id="phone"
                                                        placeholder="Phone Number" value="{{ old('phone') }}"
                                                        required />
                                                    @error('phone')
                                                        <div class="text-danger" style="font-weight: bold;">
                                                            {{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="email" class="fw-900">Email : *</label>
                                                    <input type="email" name="email" id="email"
                                                        placeholder="Email" value="{{ old('email') }}" required />
                                                    @error('email')
                                                        <div class="text-danger" style="font-weight: bold;">
                                                            {{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="address" class="col-form-label col-md-4"
                                                        style="font-weight: bold;">Address : <span
                                                            class="text-danger">*</span></label>
                                                    <input class="form-control" id="address" type="text"
                                                        name="address" placeholder="Write dealer address"
                                                        value="{{ old('address') }}">
                                                    @error('address')
                                                        <p class="text-danger">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label for="description" class="col-form-label col-md-4"
                                                        style="font-weight: bold;">Description :</label>
                                                    <textarea name="description" id="description" cols="5" placeholder="Write dealer description"
                                                        class="form-control ">{{ old('description') }}</textarea>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <div class="form-group">
                                                        <img id="showImages" class="rounded avatar-lg"
                                                            src="{{ !empty($editData->profile_image) ? url('upload/admin_images/' . $editData->profile_image) : url('upload/no_image.jpg') }}"
                                                            alt="Card image cap" width="100px" height="80px;">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="images" class="col-form-label"
                                                            style="font-weight: bold;">Shop Profile: <span
                                                                class="text-danger">*</span></label>
                                                        <input name="shop_profile" class="form-control"
                                                            type="file" id="images">
                                                        @error('shop_profile')
                                                            <p class="text-danger">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="form-group col-md-6">
                                                    <div class="form-group">
                                                        <img id="showImages2" class="rounded avatar-lg"
                                                            src="{{ !empty($editData->profile_image) ? url('upload/admin_images/' . $editData->profile_image) : url('upload/no_image.jpg') }}"
                                                            alt="Card image cap" width="100px" height="80px;">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="image2" class="col-form-label"
                                                            style="font-weight: bold;">Shop Cover Photo: <span
                                                                class="text-danger">*</span></label>
                                                        <input name="shop_cover" class="form-control" type="file"
                                                            id="images2">
                                                        @error('shop_cover')
                                                            <p class="text-danger">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <div class="form-group">
                                                        <img id="showImages3" class="rounded avatar-lg"
                                                            src="{{ !empty($editData->profile_image) ? url('upload/admin_images/' . $editData->profile_image) : url('upload/no_image.jpg') }}"
                                                            alt="Card image cap" width="100px" height="80px;">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="images3" class="col-form-label"
                                                            style="font-weight: bold;">Nid Card:</label>
                                                        <input name="nid" class="form-control" type="file"
                                                            id="images3">
                                                    </div>
                                                </div>

                                                <div class="form-group col-md-6">
                                                    <div class="form-group">
                                                        <img id="showImages4" class="rounded avatar-lg"
                                                            src="{{ !empty($editData->profile_image) ? url('upload/admin_images/' . $editData->profile_image) : url('upload/no_image.jpg') }}"
                                                            alt="Card image cap" width="100px" height="80px;">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="images4" class="col-form-label"
                                                            style="font-weight: bold;">Trade license:</label>
                                                        <input name="trade_license" class="form-control"
                                                            type="file" id="images4">
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="password" class="fw-900">Password : *</label>
                                                    <input type="password" name="password" placeholder="Password"
                                                        id="password" autocomplete="new-password" required />
                                                    <span>password must be at least 8 characters</span>
                                                    @error('password')
                                                        <div class="text-danger" style="font-weight: bold;">
                                                            {{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label class="fw-900">Confirm password : *</label>
                                                    <input type="password" placeholder="Confirm password"
                                                        name="password_confirmation" required />
                                                    @error('password')
                                                        <div class="text-danger" style="font-weight: bold;">
                                                            {{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="login_footer form-group mb-50">
                                                    <div class="chek-form">
                                                        <div class="custome-checkbox">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="checkbox" id="exampleCheckbox12" value=""
                                                                required />
                                                            <label class="form-check-label"
                                                                for="exampleCheckbox12"><span>I agree to terms &amp;
                                                                    Policy.</span></label>
                                                        </div>
                                                    </div>
                                                    <a href="#"><i
                                                            class="fi-rs-book-alt mr-5 text-muted"></i>Lean more</a>
                                                </div>
                                                <div class="form-group mb-30">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary"
                                                        name="login">Submit &amp; Register</button>
                                                </div>
                                                <p class="font-xs text-muted"><strong>Note:</strong>Your personal data
                                                    will be used to support your experience throughout this website, to
                                                    manage access to your account, and for other purposes described in
                                                    our privacy policy</p>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Mobile Side menu Start -->
<div class="mobile-header-active mobile-header-wrapper-style">
    <div class="mobile-header-wrapper-inner">
        <div class="mobile-header-top">
            <div class="mobile-header-logo">
                <a href="{{ route('home') }}">
                    @php
                        $logo = get_setting('site_logo');
                    @endphp
                    @if ($logo != null)
                        <img src="{{ asset(get_setting('site_logo')->value ?? 'null') }}"
                            alt="{{ env('APP_NAME') }}">
                    @else
                        <img src="{{ asset('upload/no_image.jpg') }}" alt="{{ env('APP_NAME') }}"
                            style="height: 60px !important; width: 80px !important; min-width: 80px !important;">
                    @endif
                </a>
            </div>
            <div class="mobile-menu-close close-style-wrap close-style-position-inherit">
                <button class="close-style search-close">
                    <i class="icon-top"></i>
                    <i class="icon-bottom"></i>
                </button>
            </div>
        </div>
        <div class="mobile-header-content-area">
            <div class="mobile-search search-style-3 mobile-header-border">
                <form action="#">
                    <input type="text" placeholder="Search for items…" />
                    <button type="submit"><i class="fi-rs-search"></i></button>
                </form>
            </div>
            <div class="mobile-menu-wrap mobile-header-border">
                <!-- mobile menu start -->
                <nav>
                    <ul class="mobile-menu font-heading">
                        <li class="menu-item-has-children">
                            <a href="{{ route('home') }}">Home</a>
                        </li>
                        <li class="menu-item-has-children">
                            <a href="{{ route('product.show') }}">
                                @if (session()->get('language') == 'bangla')
                                    দোকান
                                @else
                                    Shop
                                @endif
                            </a>
                        </li>
                        <li class="menu-item-has-children">
                            <a href="{{ route('category_list.index') }}">Category</a>
                            <ul class="dropdown">
                                @foreach (get_categories()->take(8) as $cat)
                                    <li class="menu-item-has-children">
                                        <a href="{{ route('product.category', $cat->slug) }}">
                                            @if (session()->get('language') == 'bangla')
                                                {{ $cat->name_bn }}
                                            @else
                                                {{ $cat->name_en }}
                                            @endif
                                        </a>
                                        @if ($category->sub_categories && count($category->sub_categories) > 0)
                                            <ul class="dropdown">
                                                @foreach ($category->sub_categories as $subcategory)
                                                    <li>
                                                        <a
                                                            href="{{ route('product.category', $subcategory->slug) }}">
                                                            @if (session()->get('language') == 'bangla')
                                                                {{ $subcategory->name_bn }}
                                                            @else
                                                                {{ $subcategory->name_en }}
                                                            @endif
                                                        </a>
                                                    </li>
                                                @endforeach
                                                @if ($subcategory->sub_sub_categories && count($subcategory->sub_sub_categories) > 0)
                                                    <ul class="dropdown">
                                                        @foreach ($subcategory->sub_sub_categories as $subsubcategory)
                                                            <li>
                                                                <a
                                                                    href="{{ route('product.category', $subsubcategory->slug) }}">
                                                                    @if (session()->get('language') == 'bangla')
                                                                        {{ $subsubcategory->name_bn }}
                                                                    @else
                                                                        {{ $subsubcategory->name_en }}
                                                                    @endif
                                                                </a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </ul>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                        <li class="menu-item-has-children">
                            <a href="#">Pages</a>
                            <ul class="dropdown">
                                @foreach (get_pages_both_footer()->take(4) as $page)
                                    <li>
                                        <a href="{{ route('page.about', $page->slug) }}">{{ $page->title }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                        <li class="menu-item-has-children">
                            <a href="#">Language</a>
                            <ul class="dropdown">
                                @if (session()->get('language') == 'bangla')
                                    <li>
                                        <a href="{{ route('english.language') }}">English</a>
                                    </li>
                                @else
                                    <li>
                                        <a href="{{ route('bangla.language') }}">বাংলা</a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    </ul>
                </nav>
                <!-- mobile menu end -->
            </div>
            <div class="mobile-header-info-wrap">
                <div class="single-mobile-header-info">
                    <a href="{{ route('login') }}"><i class="fi-rs-user"></i>Log In </a>
                </div>
                <div class="single-mobile-header-info">
                    <a href="{{ route('register') }}"><i class="fi-rs-user"></i>Sign Up </a>
                </div>
                <div class="single-mobile-header-info">
                    <a href="tel:{{ get_setting('phone')->value ?? 'null' }}"><i
                            class="fi-rs-headphones"></i>{{ get_setting('phone')->value ?? 'null' }} </a>
                </div>
            </div>
            <div class="mobile-social-icon mb-50">
                <h6 class="mb-15">Follow Us</h6>
                <a href="{{ get_setting('facebook_url')->value ?? 'null' }}"><img
                        src="{{ asset('frontend/assets/imgs/theme/icons/icon-facebook-white.svg') }}"
                        alt="" /></a>
                <a href="{{ get_setting('youtube_url')->value ?? 'null' }}"><img
                        src="{{ asset('frontend/assets/imgs/theme/icons/icon-twitter-white.svg') }}"
                        alt="" /></a>
                <a href="{{ get_setting('twitter_url')->value ?? 'null' }}"><img
                        src="{{ asset('frontend/assets/imgs/theme/icons/icon-instagram-white.svg') }}"
                        alt="" /></a>
                <a href="{{ get_setting('instagram_url')->value ?? 'null' }}"><img
                        src="{{ asset('frontend/assets/imgs/theme/icons/icon-pinterest-white.svg') }}"
                        alt="" /></a>
                <a href="{{ get_setting('pinterest_url')->value ?? 'null' }}"><img
                        src="{{ asset('frontend/assets/imgs/theme/icons/icon-youtube-white.svg') }}"
                        alt="" /></a>
            </div>
            <div class="site-copyright">
                Developed by:
                <a target="_blank"
                    href="{{ get_setting('developer_link')->value ?? 'null' }}">{{ get_setting('developed_by')->value ?? 'null' }}</a>
            </div>
        </div>
    </div>
</div>
<!-- Mobile Side menu End -->
<!--End header-->

@push('footer-script')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#image2').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#showImage2').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            });
        });
    </script>
    <!-- Nid Card Show -->
    <script type="text/javascript">
        $(document).ready(function() {
            $('#image3').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#showImage3').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            });
        });
    </script>
    <!-- Trade license Show -->
    <script type="text/javascript">
        $(document).ready(function() {
            $('#image4').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#showImage4').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            });
        });
    </script>

    {{-- Profile Image --}}
    <script type="text/javascript">
        $(document).ready(function() {
            $('#image5').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#showImage5').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            });
        });
    </script>
    {{-- bank Information --}}
    <script type="text/javascript">
        $(document).ready(function() {
            $('#image6').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#showImage6').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            });
        });
    </script>
    <!-- Nid Card Show -->
    <script type="text/javascript">
        $(document).ready(function() {
            $('#image7').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#showImage7').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            });
        });
    </script>
    <!-- Trade license Show -->
    <script type="text/javascript">
        $(document).ready(function() {
            $('#image8').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#showImage8').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            });
        });
    </script>


    <script type="text/javascript">
        /* ================ Advance Product Search ============ */
        $("body").on("keyup", ".search", function() {
            let text = $(".search").val();
            let category_id = $("#searchCategory").val();
            // alert(category_id);
            // console.log(text);

            if (text.length > 0) {

                $.ajax({
                    data: {
                        search: text,
                        category: category_id
                    },
                    url: "/search-product",
                    method: 'post',
                    beforSend: function(request) {
                        return request.setReuestHeader('X-CSRF-Token', ("meta[name='csrf-token']"))

                    },
                    success: function(result) {
                        $(".searchProducts").html(result);
                    }

                }); // end ajax
            } // end if
            if (text.length < 1) $(".searchProducts").html("");
        }); // end function

        /* ================ Advance Product slideUp/slideDown ============ */
        function search_result_hide() {
            $(".searchProducts").slideUp();
        }

        function search_result_show() {
            $(".searchProducts").slideDown();
        }
    </script>

    <script>
        $(document).ready(function() {
            $(".show").click(function() {
                $(".advance-search").show();
            });
            $(".hide").click(function() {
                $(".advance-search").hide();
            });
        });
    </script>
    {{-- seller profile --}}
     <script type="text/javascript">
        $(document).ready(function() {
            $('#images').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#showImages').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            });
        });
    </script>
     {{-- seller cover --}}
     <script type="text/javascript">
        $(document).ready(function() {
            $('#images2').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#showImages2').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            });
        });
    </script>
     {{-- seller NID --}}
     <script type="text/javascript">
        $(document).ready(function() {
            $('#images3').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#showImages3').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            });
        });
    </script>
     {{-- seller trade License --}}
     <script type="text/javascript">
        $(document).ready(function() {
            $('#images4').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#showImages4').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            });
        });
    </script>
@endpush
