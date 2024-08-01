@php
    $prefix = Request::route()->getPrefix();
    $route = Route::current()->getName();
@endphp
<aside class="navbar-aside bg-primary" id="offcanvas_aside">
    <div class="aside-top">
        <a href="{{ route('admin.dashboard') }}" class="brand-wrap">
            @php
                $logo = get_setting('site_footer_logo');
            @endphp
            @if ($logo != null)
                <img src="{{ asset(get_setting('site_footer_logo')->value ?? ' ') }}" alt="{{ env('APP_NAME') }}"
                    style="height: 30px !important; width: 100px !important; min-width: 100px !important;">
            @else
                <img src="{{ asset('upload/no_image.jpg') }}" alt="{{ env('APP_NAME') }}"
                    style="height: 30px !important; width: 80px !important; min-width: 80px !important;">
            @endif
        </a>
        <div>
            <button class="btn btn-icon btn-aside-minimize"><i
                    class="text-white material-icons md-menu_open"></i></button>
        </div>
    </div>
    <nav>
        <ul class="menu-aside">
            <li class="menu-item {{ $route == 'admin.dashboard' ? 'active' : '' }}">
                <a class="menu-link" href="{{ route('admin.dashboard') }}">
                    <i class="fa-solid fa-house fontawesome_icon_custom"></i>
                    <span class="text">Dashboard</span>
                </a>
            </li>

            <li
                class="menu-item has-submenu
                {{ $route == 'slider.index' ? 'active' : '' }}
                {{ $route == 'slider.edit' ? 'active' : '' }}
                {{ $route == 'slider.create' ? 'active' : '' }}
            ">
                @if (Auth::guard('admin')->user()->role == '1' ||
                        in_array('111', json_decode(Auth::guard('admin')->user()->staff->role->permissions)) ||
                        in_array('112', json_decode(Auth::guard('admin')->user()->staff->role->permissions)))
                    <a class="menu-link" href="#">
                        <i class="fa-solid fa-photo-film fontawesome_icon_custom"></i>
                        <span class="text">Sliders</span>
                    </a>
                @endif
                <div class="submenu">
                    @if (Auth::guard('admin')->user()->role == '1' ||
                            in_array('111', json_decode(Auth::guard('admin')->user()->staff->role->permissions)))
                        <a class="{{ $route == 'slider.index' ? 'active' : '' }}"
                            href="{{ route('slider.index') }}">Slider List</a>
                    @endif
                    @if (Auth::guard('admin')->user()->role == '1' ||
                            in_array('112', json_decode(Auth::guard('admin')->user()->staff->role->permissions)))
                        <a class="{{ $route == 'slider.create' ? 'active' : '' }}"
                            href="{{ route('slider.create') }}">Slider Add</a>
                    @endif
                </div>
            </li>

            <li
                class="menu-item has-submenu
                {{ $prefix == 'admin/product' || $prefix == 'admin/category' || $prefix == 'admin/unit' || $route == 'attribute.index' || $route == 'unit.index' || $prefix == 'admin/brand' || $route == 'menufacturing.index' ? 'active' : '' }}
            ">
                @if (Auth::guard('admin')->user()->role == '1' ||
                        in_array('1', json_decode(Auth::guard('admin')->user()->staff->role->permissions)) ||
                        in_array('2', json_decode(Auth::guard('admin')->user()->staff->role->permissions)) ||
                        in_array('6', json_decode(Auth::guard('admin')->user()->staff->role->permissions)) ||
                        in_array('10', json_decode(Auth::guard('admin')->user()->staff->role->permissions)) ||
                        in_array('14', json_decode(Auth::guard('admin')->user()->staff->role->permissions)) ||
                        in_array('18', json_decode(Auth::guard('admin')->user()->staff->role->permissions)) ||
                        in_array('21', json_decode(Auth::guard('admin')->user()->staff->role->permissions)))
                    <a class="menu-link" href="#">
                        <i class="fa-solid fa-bag-shopping fontawesome_icon_custom"></i>
                        <span class="text">Products</span>
                    </a>
                @endif
                {{-- @if (in_array('1', json_decode(Auth::guard('admin')->user()->staff->role->permissions))) --}}
                {{-- @dd(Auth::guard('admin')->user()) --}}

                {{-- @endif --}}
                <div class="submenu">
                    @if (Auth::guard('admin')->user()->role == '1' ||
                            in_array('1', json_decode(Auth::guard('admin')->user()->staff->role->permissions)))
                        <a class="{{ $route == 'product.add' ? 'active' : '' }}"
                            href="{{ route('product.add') }}">Product Add</a>
                    @endif
                    @if (Auth::guard('admin')->user()->role == '1' ||
                            in_array('2', json_decode(Auth::guard('admin')->user()->staff->role->permissions)))
                        <a class="{{ $route == 'product.all' ? 'active' : '' }}"
                            href="{{ route('product.all') }}">Products</a>
                    @endif
                    @if (Auth::guard('admin')->user()->role == '1' ||
                            in_array('6', json_decode(Auth::guard('admin')->user()->staff->role->permissions)))
                        <a class="{{ $prefix == 'admin/category' ? 'active' : '' }}"
                            href="{{ route('category.index') }}">Categories</a>
                    @endif
                    @if (Auth::guard('admin')->user()->role == '1' ||
                            in_array('10', json_decode(Auth::guard('admin')->user()->staff->role->permissions)))
                        <a class="{{ $route == 'attribute.index' ? 'active' : '' }}"
                            href="{{ route('attribute.index') }}">Attributes</a>
                    @endif
                    @if (Auth::guard('admin')->user()->role == '1' ||
                            in_array('14', json_decode(Auth::guard('admin')->user()->staff->role->permissions)))
                        <a class="{{ $route == 'unit.index' ? 'active' : '' }}"
                            href="{{ route('unit.index') }}">Unit</a>
                    @endif
                    @if (Auth::guard('admin')->user()->role == '1' ||
                            in_array('18', json_decode(Auth::guard('admin')->user()->staff->role->permissions)))
                        <a class="{{ $prefix == 'admin/brand' ? 'active' : '' }}"
                            href="{{ route('brand.all') }}">Brands</a>
                    @endif
                    @if (Auth::guard('admin')->user()->role == '1' ||
                            in_array('21', json_decode(Auth::guard('admin')->user()->staff->role->permissions)))
                        <a class="{{ $route == 'product.productReviews' ? 'active' : '' }}"
                            href="{{ route('product.productReviews') }}">Product Reviews</a>
                    @endif
                    {{-- @if (Auth::guard('admin')->user()->role == '1' || in_array('9', json_decode(Auth::guard('admin')->user()->staff->role->permissions)))
                        <a class="{{ ($route == 'menufacturing.index') ? 'active':'' }}" href="{{ route('menufacturing.index') }}">Manufacturing Image</a>
                    @endif --}}
                </div>
            </li>

            <li
                class="menu-item has-submenu
            {{ $prefix == 'admin/manufacture' || $route == 'menufacture.index' || $route == 'menufacture.create' || $route == 'menufacture.orderPayment' || $route == 'menufacture.paymentList' || $route == 'worker.workerBalance' || $route == 'manufacture.pending' || $route == 'manufacture.confirmed' ? 'active' : '' }}
             ">
                @if (Auth::guard('admin')->user()->role == '1' ||
                        in_array('25', json_decode(Auth::guard('admin')->user()->staff->role->permissions)) ||
                        in_array('29', json_decode(Auth::guard('admin')->user()->staff->role->permissions)) ||
                        in_array('24', json_decode(Auth::guard('admin')->user()->staff->role->permissions)) ||
                        in_array('27', json_decode(Auth::guard('admin')->user()->staff->role->permissions)) ||
                        in_array('28', json_decode(Auth::guard('admin')->user()->staff->role->permissions)) ||
                        in_array('30', json_decode(Auth::guard('admin')->user()->staff->role->permissions)) ||
                        in_array('32', json_decode(Auth::guard('admin')->user()->staff->role->permissions)))
                    <a class="menu-link" href="#">
                        <i class="fas fa-tools fontawesome_icon_custom"></i>
                        <span class="text">Manufacture</span>
                    </a>
                @endif
                <div class="submenu">

                    @if (Auth::guard('admin')->user()->role == '1' ||
                            in_array('24', json_decode(Auth::guard('admin')->user()->staff->role->permissions)))
                        <a class="{{ $route == 'manufacture.create' ? 'active' : '' }}"
                            href="{{ route('manufacture.create') }}">Manufacture Order Create</a>
                    @endif
                    @if (Auth::guard('admin')->user()->role == '1' ||
                            in_array('25', json_decode(Auth::guard('admin')->user()->staff->role->permissions)))
                        <a class="{{ $route == 'manufacture.index' ? 'active' : '' }}"
                            href="{{ route('manufacture.index') }}">Manufacture Order List</a>
                    @endif
                        @if (Auth::guard('admin')->user()->role == '1' ||
                            in_array('26', json_decode(Auth::guard('admin')->user()->staff->role->permissions)))
                        <a class="{{ $route == 'manufacture.complete' ? 'active' : '' }}"
                            href="{{ route('manufacture.complete') }}">Completed Order</a>
                    @endif
                    @if (Auth::guard('admin')->user()->role == '1' ||
                            in_array('25', json_decode(Auth::guard('admin')->user()->staff->role->permissions)))
                        <a class="{{ $route == 'manufacture.confirmed' ? 'active' : '' }}"
                            href="{{ route('manufacture.confirmed') }}">Confirmed Orders</a>
                    @endif
                    @if (Auth::guard('admin')->user()->role == '1' ||
                            in_array('26', json_decode(Auth::guard('admin')->user()->staff->role->permissions)))
                        <a class="{{ $route == 'manufacture.pending' ? 'active' : '' }}"
                            href="{{ route('manufacture.pending') }}">Pending Orders</a>
                    @endif
                    @if (Auth::guard('admin')->user()->role == '1' ||
                            in_array('27', json_decode(Auth::guard('admin')->user()->staff->role->permissions)))
                        <a class="{{ $route == 'manufacture.orderPayment' ? 'active' : '' }}"
                            href="{{ route('manufacture.orderPayment') }}">Receive Order</a>
                    @endif
                    @if (Auth::guard('admin')->user()->role == '1' ||
                            in_array('28', json_decode(Auth::guard('admin')->user()->staff->role->permissions)))
                        <a class="{{ $route == 'manufacture.manufactureStock' ? 'active' : '' }}"
                            href="{{ route('manufacture.manufactureStock') }}">Manufacture Stock</a>
                    @endif
                    @if (Auth::guard('admin')->user()->role == '1' ||
                            in_array('29', json_decode(Auth::guard('admin')->user()->staff->role->permissions)))
                        <a class="{{ $route == 'manufacture.bodyPartOrderInfo' ? 'active' : '' }}"
                            href="{{ route('manufacture.bodyPartOrderInfo') }}">Finishing Part Orders</a>
                    @endif
                    @if (Auth::guard('admin')->user()->role == '1' ||
                            in_array('30', json_decode(Auth::guard('admin')->user()->staff->role->permissions)))
                        <a class="{{ $route == 'manufacture.ManufacturePaymentInfo' ? 'active' : '' }}"
                            href="{{ route('manufacture.ManufacturePaymentInfo') }}">Manufacture Pyments Info</a>
                    @endif
                        @if (Auth::guard('admin')->user()->role == '1' ||
                            in_array('31', json_decode(Auth::guard('admin')->user()->staff->role->permissions)))
                        <a class="{{ $route == 'manufacture.ManufacturePayment.expense' ? 'active' : '' }}"
                            href="{{ route('manufacture.ManufacturePayment.expense') }}">Manufacture Show Expense</a>
                    @endif

                    @if (Auth::guard('admin')->user()->role == '1' ||
                            in_array('32', json_decode(Auth::guard('admin')->user()->staff->role->permissions)))
                        <a class="{{ $route == 'worker.workerBalance' ? 'active' : '' }}"
                            href="{{ route('worker.workerBalance') }}">Workers Balance</a>
                    @endif
                        @if (Auth::guard('admin')->user()->role == '1' ||
                                in_array('33', json_decode(Auth::guard('admin')->user()->staff->role->permissions)))
                            <a class="{{ $route == 'worker.inactive' ? 'active' : '' }}"
                               href="{{ route('worker.inactive') }}">Workers Balance Inactive</a>
                        @endif
                </div>
            </li>


            <li
                class="menu-item has-submenu
                        {{ $route == 'vendor.index' ? 'active' : '' }}
                        {{ $route == 'vendor.edit' ? 'active' : '' }}
                        {{ $route == 'vendor.create' ? 'active' : '' }}
                    ">
                @if (Auth::guard('admin')->user()->role == '1' ||
                        in_array('34', json_decode(Auth::guard('admin')->user()->staff->role->permissions)) ||
                        in_array('35', json_decode(Auth::guard('admin')->user()->staff->role->permissions)))
                    <a class="menu-link" href="#">
                        <i class="icon material-icons md-person_add"></i>
                        <span class="text">Branch</span>
                    </a>
                @endif
                <div class="submenu">
                    @if (Auth::guard('admin')->user()->role == '1' ||
                            in_array('34', json_decode(Auth::guard('admin')->user()->staff->role->permissions)))
                        <a class="{{ $route == 'vendor.index' ? 'active' : '' }}"
                            href="{{ route('vendor.index') }}">Branch List</a>
                    @endif
                    @if (Auth::guard('admin')->user()->role == '1' ||
                            in_array('35', json_decode(Auth::guard('admin')->user()->staff->role->permissions)))
                        <a class="{{ $route == 'vendor.create' ? 'active' : '' }}"
                            href="{{ route('vendor.create') }}">Branch Add</a>
                    @endif
                </div>
            </li>
            {{-- Seller part  --}}
            <li
                class="menu-item has-submenu
                        {{ $route == 'seller.index' ? 'active' : '' }}
                        {{ $route == 'seller.edit' ? 'active' : '' }}
                        {{ $route == 'seller.create' ? 'active' : '' }}
                        {{ $route == 'seller.productRequest' ? 'active' : '' }}
                    ">
                @if (Auth::guard('admin')->user()->role == '1')
                    <a class="menu-link" href="#">
                        <i class="icon material-icons md-person_add"></i>
                        <span class="text">Seller</span>
                    </a>
                @endif
                <div class="submenu">
                    @if (Auth::guard('admin')->user()->role == '1')
                        <a class="{{ $route == 'seller.index' ? 'active' : '' }}"
                            href="{{ route('seller.index') }}">Seller List</a>
                    @endif
                    @if (Auth::guard('admin')->user()->role == '1')
                        <a class="{{ $route == 'seller.create' ? 'active' : '' }}"
                            href="{{ route('seller.create') }}">Seller Add</a>
                    @endif
                    @if (Auth::guard('admin')->user()->role == '1')
                        <a class="{{ $route == 'seller.productRequest' ? 'active' : '' }}"
                            href="{{ route('seller.productRequest') }}">Seller Product Request</a>
                    @endif
                </div>
            </li>

            {{-- Seller Commission  --}}

            <li
                class="menu-item has-submenu
                        {{ $route == 'sellerCommission.index' ? 'active' : '' }}
                        {{ $route == 'sellerCommission.edit' ? 'active' : '' }}
                        {{ $route == 'sellerCommission.create' ? 'active' : '' }}
                    ">
                @if (Auth::guard('admin')->user()->role == '1')
                    <a class="menu-link" href="#">
                        <i class="icon material-icons md-person_add"></i>
                        <span class="text">Seller Commission</span>
                    </a>
                @endif
                <div class="submenu">
                    @if (Auth::guard('admin')->user()->role == '1')
                        <a class="{{ $route == 'sellerCommission.index' ? 'active' : '' }}"
                            href="{{ route('sellerCommission.index') }}">Seller commision List</a>
                    @endif
                    @if (Auth::guard('admin')->user()->role == '1')
                        <a class="{{ $route == 'sellerCommission.create' ? 'active' : '' }}"
                            href="{{ route('sellerCommission.create') }}">Seller commission Add</a>
                    @endif
                </div>
            </li>

            <li
                class="menu-item has-submenu
                    {{ $route == 'dealer.index' ? 'active' : '' }}
                    {{ $route == 'dealer.edit' ? 'active' : '' }}
                    {{ $route == 'dealer.create' ? 'active' : '' }}
                    {{ $route == 'admin.dealer.all_request' ? 'active' : '' }}
                    {{ $route == 'admin.all_request.show' ? 'active' : '' }}
                    {{ $prefix == 'admin/all-request' ? 'active' : '' }}
                    {{ $route == 'admin.dealer.order.confirm' ? 'active' : '' }}
                    {{ $route == 'orders.dealer.show' ? 'active' : '' }}
                    {{ $route == 'admin.dealer.order.due' ? 'active' : '' }}
                   ">
                @if (Auth::guard('admin')->user()->role == '1' ||
                        in_array('38', json_decode(Auth::guard('admin')->user()->staff->role->permissions)) ||
                        in_array('39', json_decode(Auth::guard('admin')->user()->staff->role->permissions)) ||
                        in_array('42', json_decode(Auth::guard('admin')->user()->staff->role->permissions)) ||
                        in_array('45', json_decode(Auth::guard('admin')->user()->staff->role->permissions)) ||
                        in_array('46', json_decode(Auth::guard('admin')->user()->staff->role->permissions)))
                    <a class="menu-link" href="#">
                        <i class="fa-solid fa-handshake fontawesome_icon_custom"></i>
                        <span class="text">Dealers</span>
                    </a>
                @endif
                <div class="submenu">
                    @if (Auth::guard('admin')->user()->role == '1' ||
                            in_array('38', json_decode(Auth::guard('admin')->user()->staff->role->permissions)))
                        <a class="{{ $route == 'dealer.index' ? 'active' : '' }}"
                            href="{{ route('dealer.index') }}">Dealers List</a>
                    @endif
                    @if (Auth::guard('admin')->user()->role == '1' ||
                            in_array('39', json_decode(Auth::guard('admin')->user()->staff->role->permissions)))
                        <a class="{{ $route == 'dealer.create' ? 'active' : '' }}"
                            href="{{ route('dealer.create') }}">Dealer Add</a>
                    @endif
                    @if (Auth::guard('admin')->user()->role == '1' ||
                            in_array('42', json_decode(Auth::guard('admin')->user()->staff->role->permissions)))
                        <a class="{{ $route == 'admin.dealer.all_request' ? 'active' : '' }}"
                            href="{{ route('admin.dealer.all_request') }}">Dealer Order Request</a>
                    @endif
                    @if (Auth::guard('admin')->user()->role == '1' ||
                            in_array('45', json_decode(Auth::guard('admin')->user()->staff->role->permissions)))
                        <a class="{{ $route == 'admin.dealer.order.confirm' ? 'active' : '' }}"
                            href="{{ route('admin.dealer.order.confirm') }}">Dealer Order Confirm</a>
                    @endif
                    @if (Auth::guard('admin')->user()->role == '1' ||
                            in_array('46', json_decode(Auth::guard('admin')->user()->staff->role->permissions)))
                        <a class="{{ $route == 'admin.dealer.order.due' ? 'active' : '' }}"
                            href="{{ route('admin.dealer.order.due') }}">Dealer Due Products</a>
                    @endif
                        @if (Auth::guard('admin')->user()->role == '1' ||
                               in_array('47', json_decode(Auth::guard('admin')->user()->staff->role->permissions)))
                            <a class="{{ $route == 'admin.dealer.order.delivered' ? 'active' : '' }}"
                               href="{{ route('admin.dealer.order.delivered') }}">Dealer Order Delivered</a>
                        @endif
                </div>
            </li>



            <li
                class="menu-item has-submenu
                    {{ $route == 'worker.index' ? 'active' : '' }}
                    {{ $route == 'worker.edit' ? 'active' : '' }}
                    {{ $route == 'worker.create' ? 'active' : '' }}
                    {{ $route == 'worker.workerRegistration' ? 'active' : '' }}

                    {{-- {{ ($route == 'admin.dealer.all_request')? 'active':'' }}
                    {{ ($prefix == 'admin/all-request') ? 'active':'' }}
                    {{ ($route == 'admin.dealer.order.confirm')? 'active':'' }} --}}
                ">
                @if (Auth::guard('admin')->user()->role == '1' ||
                        in_array('48', json_decode(Auth::guard('admin')->user()->staff->role->permissions)) ||
                        in_array('49', json_decode(Auth::guard('admin')->user()->staff->role->permissions)) ||
                        in_array('52', json_decode(Auth::guard('admin')->user()->staff->role->permissions)))
                    <a class="menu-link" href="#">
                        <i class="fas fa-people-carry fontawesome_icon_custom"></i>
                        <span class="text">Workers</span>
                    </a>
                @endif
                <div class="submenu">
                    @if (Auth::guard('admin')->user()->role == '1' ||
                            in_array('48', json_decode(Auth::guard('admin')->user()->staff->role->permissions)))
                        <a class="{{ $route == 'worker.index' ? 'active' : '' }}"
                            href="{{ route('worker.index') }}">Worker List</a>
                    @endif
                    @if (Auth::guard('admin')->user()->role == '1' ||
                            in_array('49', json_decode(Auth::guard('admin')->user()->staff->role->permissions)))
                        <a class="{{ $route == 'worker.create' ? 'active' : '' }}"
                            href="{{ route('worker.create') }}">worker Add</a>
                    @endif
                    @if (Auth::guard('admin')->user()->role == '1' ||
                            in_array('52', json_decode(Auth::guard('admin')->user()->staff->role->permissions)))
                        <a class="{{ $route == 'worker.workerRegistration' ? 'active' : '' }}"
                            href="{{ route('worker.workerRegistration') }}">Register Request</a>
                    @endif

                    {{-- <a class="{{ ($route == 'admin.dealer.all_request') ? 'active':'' }}" href="{{ route('admin.dealer.all_request') }}">Dealer Request</a>
                        <a class="{{ ($route == 'admin.dealer.order.confirm') ? 'active':'' }}" href="{{ route('admin.dealer.order.confirm') }}">Dealer Order Confirm</a> --}}
                </div>
            </li>


            {{-- <li class="menu-item has-submenu
                {{ ($route == 'campaing.index')? 'active':'' }}
                {{ ($route == 'campaing.create')? 'active':'' }}
                {{ ($route == 'campaing.edit')? 'active':'' }}
            ">
                @if (Auth::guard('admin')->user()->role == '1' || in_array('41', json_decode(Auth::guard('admin')->user()->staff->role->permissions)))
                    <a class="menu-link" href="#">
                       <i class="fa-solid fa-photo-film fontawesome_icon_custom"></i>
                        <span class="text">Campaigns</span>
                    </a>
                @endif
                <div class="submenu">
                    @if (Auth::guard('admin')->user()->role == '1' || in_array('41', json_decode(Auth::guard('admin')->user()->staff->role->permissions)))
                        <a class="{{ ($route == 'campaing.index') ? 'active':'' }}" href="{{ route('campaing.index') }}">Campaign List</a>
                    @endif
                    @if (Auth::guard('admin')->user()->role == '1' || in_array('42', json_decode(Auth::guard('admin')->user()->staff->role->permissions)))
                        <a class="{{ ($route == 'campaing.create') ? 'active':'' }}" href="{{ route('campaing.create') }}">Campaign Add</a>
                    @endif
                </div>
            </li>
            @if (Auth::guard('admin')->user()->role == '1')
            <li class="menu-item has-submenu
                {{ ($route == 'coupons.index')? 'active':'' }}
                {{ ($route == 'coupons.create')? 'active':'' }}
                {{ ($route == 'coupons.edit')? 'active':'' }}
            ">
                <a class="menu-link" href="#">
                    <i class="icon material-icons md-monetization_on"></i>
                    <span class="text">Coupons</span>
                </a>
                <div class="submenu">
                    <a class="{{ ($route == 'coupons.index') ? 'active':'' }}" href="{{ route('coupons.index') }}">Coupon List</a>
                    <a class="{{ ($route == 'coupons.create') ? 'active':'' }}" href="{{ route('coupons.create') }}">Coupon Add</a>
                </div>
            </li>
            @endif --}}
            <li class="menu-item has-submenu {{ $prefix == 'admin/supplier' ? 'active' : '' }}">
                @if (Auth::guard('admin')->user()->role == '1' ||
                        in_array('61', json_decode(Auth::guard('admin')->user()->staff->role->permissions)) ||
                        in_array('63', json_decode(Auth::guard('admin')->user()->staff->role->permissions)))
                    <a class="menu-link" href="#">
                        <i class="icon material-icons md-stars"></i>
                        <span class="text">Suppliers</span>
                    </a>
                @endif
                <div class="submenu">
                    @if (Auth::guard('admin')->user()->role == '1' ||
                            in_array('61', json_decode(Auth::guard('admin')->user()->staff->role->permissions)))
                        <a class="{{ $route == 'supplier.all' ? 'active' : '' }}"
                            href="{{ route('supplier.all') }}">Supplier List</a>
                    @endif
                    @if (Auth::guard('admin')->user()->role == '1' ||
                            in_array('63', json_decode(Auth::guard('admin')->user()->staff->role->permissions)))
                        <a class="{{ $route == 'supplier.create' ? 'active' : '' }}"
                            href="{{ route('supplier.create') }}">Supplier Add</a>
                    @endif
                </div>
            </li>
            <li
                class="menu-item has-submenu {{ $route == 'all_orders.index' || $route == 'pos.orderList' || $route == 'pos.orderShow' || $route == 'pos.orderDue' || $route == 'pos.dueCollectInfo' ? 'active' : '' }}">
                @if (Auth::guard('admin')->user()->role == '1' ||
                        in_array('65', json_decode(Auth::guard('admin')->user()->staff->role->permissions)) ||
                        in_array('69', json_decode(Auth::guard('admin')->user()->staff->role->permissions)) ||
                        in_array('73', json_decode(Auth::guard('admin')->user()->staff->role->permissions)) ||
                        in_array('77', json_decode(Auth::guard('admin')->user()->staff->role->permissions)))
                    <a class="menu-link" href="#">
                        <i class="icon material-icons md-shopping_cart"></i>
                        <span class="text">Sales</span>
                    </a>
                @endif
                <div class="submenu">
                    @if (Auth::guard('admin')->user()->role == '1' ||
                            in_array('65', json_decode(Auth::guard('admin')->user()->staff->role->permissions)))
                        <a class="{{ $route == 'all_orders.index' ? 'active' : '' }}"
                            href="{{ route('all_orders.index') }}">All Orders</a>
                    @endif
                    @if (Auth::guard('admin')->user()->role == '1' ||
                            in_array('69', json_decode(Auth::guard('admin')->user()->staff->role->permissions)))
                        <a class="{{ $route == 'pos.orderList' ? 'active' : '' }}"
                            href="{{ route('pos.orderList') }}">Pos Order</a>
                    @endif
                    @if (Auth::guard('admin')->user()->role == '1' ||
                            in_array('73', json_decode(Auth::guard('admin')->user()->staff->role->permissions)))
                        <a class="{{ $route == 'pos.orderDue' ? 'active' : '' }}"
                            href="{{ route('pos.orderDue') }}">Customer Due</a>
                    @endif
                    @if (Auth::guard('admin')->user()->role == '1' ||
                            in_array('77', json_decode(Auth::guard('admin')->user()->staff->role->permissions)))
                        <a class="{{ $route == 'pos.dueCollectInfo' ? 'active' : '' }}"
                            href="{{ route('pos.dueCollectInfo') }}">Due Collect Info</a>
                    @endif
                </div>
            </li>
            {{-- <li class="menu-item has-submenu {{ ($route == 'sms.templates') || ($route == 'sms.providers')?'active':'' }}">
                @if (Auth::guard('admin')->user()->role == '1' || in_array('34', json_decode(Auth::guard('admin')->user()->staff->role->permissions)))
                    <a class="menu-link" href="#">
                        <i class="fontawesome_icon_custom fa-solid fa-phone"></i>
                        <span class="text">OTP System</span>
                    </a>
                @endif
                <div class="submenu">
                    @if (Auth::guard('admin')->user()->role == '1' || in_array('34', json_decode(Auth::guard('admin')->user()->staff->role->permissions)))
                        <a class="{{ ($route == 'sms.templates') ? 'active':'' }}" href="{{ route('sms.templates') }}" >SMS Teamplates</a>
                    @endif

                    @if (Auth::guard('admin')->user()->role == '1' || in_array('34', json_decode(Auth::guard('admin')->user()->staff->role->permissions)))
                        <a class="{{ ($route == 'sms.providers') ? 'active':'' }}" href="{{ route('sms.providers') }}" >SMS Providers</a>
                    @endif
                </div>
            </li> --}}
            @if (Auth::guard('admin')->user()->role == '1')
                <li
                    class="menu-item has-submenu
                    {{ $route == 'staff.index' ? 'active' : '' }}
                    {{ $route == 'staff.create' ? 'active' : '' }}
                    {{ $route == 'staff.edit' ? 'active' : '' }}
                    {{ $route == 'roles.index' ? 'active' : '' }}
                    {{ $route == 'roles.create' ? 'active' : '' }}
                    {{ $route == 'roles.edit' ? 'active' : '' }}
                ">

                    <a class="menu-link" href="#">
                        <i class="icon material-icons md-pie_chart"></i>
                        <span class="text">Staff</span>
                    </a>

                    <div class="submenu">

                        <a class="{{ $route == 'staff.index' ? 'active' : '' }}"
                            href="{{ route('staff.index') }}">All Staff</a>


                        <a class="{{ $route == 'roles.index' ? 'active' : '' }}"
                            href="{{ route('roles.index') }}">Staff Premissions</a>

                    </div>
                </li>
            @endif

            <li
                class="menu-item has-submenu
                {{ $route == 'stock_report.index' ? 'active' : '' }}
                {{ $route == 'sale_report' ? 'active' : '' }}
                {{ $route == 'order_sale_report' ? 'active' : '' }}
                {{ $route == 'all.order.profit.report' ? 'active' : '' }}
                {{ $route == 'show.order.profit.report' ? 'active' : '' }}
                {{ $route == 'pos.order.profit.report' ? 'active' : '' }}
                {{ $route == 'show.pos.order.profit.report' ? 'active' : '' }}
                ">
                @if (Auth::guard('admin')->user()->role == '1' ||
                        in_array('780', json_decode(Auth::guard('admin')->user()->staff->role->permissions)))
                    <a class="menu-link" href="#">
                        <i class="icon material-icons md-pie_chart"></i>
                        <span class="text">Report</span>
                    </a>
                @endif
                <div class="submenu">
                    @if (Auth::guard('admin')->user()->role == '1' ||
                            in_array('78', json_decode(Auth::guard('admin')->user()->staff->role->permissions)))
                        <a class="{{ $route == 'stock_report.index' ? 'active' : '' }} mb-1"
                            href="{{ route('stock_report.index') }}">Product Stock</a>
                    @endif

                    @if (Auth::guard('admin')->user()->role == '1' ||
                            in_array('79', json_decode(Auth::guard('admin')->user()->staff->role->permissions)))
                        <a class="{{ $route == 'sale_report' ? 'active' : '' }}"
                            href="{{ route('sale_report') }}">Pos Sale Report </a>
                    @endif
                    @if (Auth::guard('admin')->user()->role == '1' ||
                            in_array('80', json_decode(Auth::guard('admin')->user()->staff->role->permissions)))
                        <a class="{{ $route == 'order_sale_report' ? 'active' : '' }}"
                            href="{{ route('order_sale_report') }}">All Order Sale Report </a>
                    @endif
                    @if (Auth::guard('admin')->user()->role == '1' ||
                            in_array('800', json_decode(Auth::guard('admin')->user()->staff->role->permissions)))
                        <a class="{{ $route == 'show.order.profit.report' ? 'active' : '' }}"
                            href="{{ route('show.order.profit.report') }}">All Order Profit Report </a>
                    @endif

                    @if (Auth::guard('admin')->user()->role == '1' || in_array('80', json_decode(Auth::guard('admin')->user()->staff->role->permissions)))
                    <a class="{{ $route == 'show.pos.order.profit.report' ? 'active' : '' }}"
                        href="{{ route('show.pos.order.profit.report') }}">Pos Order Profit Report </a>
                    @endif

                </div>
            </li>


            <li
                class="menu-item has-submenu
                {{ $route == 'banner.index' ? 'active' : '' }}
                {{ $route == 'banner.edit' ? 'active' : '' }}
                {{ $route == 'banner.create' ? 'active' : '' }}
            ">
                @if (Auth::guard('admin')->user()->role == '1' ||
                        in_array('81', json_decode(Auth::guard('admin')->user()->staff->role->permissions)) ||
                        in_array('86', json_decode(Auth::guard('admin')->user()->staff->role->permissions)))
                    <a class="menu-link" href="#">
                        <i class="icon material-icons md-pie_chart"></i>
                        <span class="text">Banner</span>
                    </a>
                @endif
                <div class="submenu">
                    @if (Auth::guard('admin')->user()->role == '1' ||
                            in_array('81', json_decode(Auth::guard('admin')->user()->staff->role->permissions)))
                        <a class="{{ $route == 'banner.index' ? 'active' : '' }}"
                            href="{{ route('banner.index') }}">Banner List</a>
                    @endif
                    @if (Auth::guard('admin')->user()->role == '1' ||
                            in_array('86', json_decode(Auth::guard('admin')->user()->staff->role->permissions)))
                        <a class="{{ $route == 'banner.create' ? 'active' : '' }}"
                            href="{{ route('banner.create') }}">Banner Add</a>
                    @endif
                </div>
            </li>


            <li
                class="menu-item has-submenu
                {{ $route == 'subscribers.index' ? 'active' : '' }}
            ">
                @if (Auth::guard('admin')->user()->role == '1' ||
                        in_array('87', json_decode(Auth::guard('admin')->user()->staff->role->permissions)))
                    <a class="menu-link" href="#">
                        <i class="icon material-icons md-pie_chart"></i>
                        <span class="text">Subscribers</span>
                    </a>
                @endif
                <div class="submenu">
                    @if (Auth::guard('admin')->user()->role == '1' ||
                            in_array('87', json_decode(Auth::guard('admin')->user()->staff->role->permissions)))
                        <a class="{{ $route == 'subscribers.index' ? 'active' : '' }}"
                            href="{{ route('subscribers.index') }}">Subsribers List</a>
                    @endif
                </div>
            </li>

            {{-- <li class="menu-item has-submenu
                {{ ($route == 'blog.index')? 'active':'' }}
                {{ ($route == 'blog.edit')? 'active':'' }}
                {{ ($route == 'blog.create')? 'active':'' }}
            ">
                @if (Auth::guard('admin')->user()->role == '1' || in_array('21', json_decode(Auth::guard('admin')->user()->staff->role->permissions)))
                    <a class="menu-link" href="#">
                        <i class="icon material-icons md-comment"></i>
                        <span class="text">Blog</span>
                    </a>
                @endif
                <div class="submenu">
                    @if (Auth::guard('admin')->user()->role == '1' || in_array('21', json_decode(Auth::guard('admin')->user()->staff->role->permissions)))
                        <a class="{{ ($route == 'blog.index') ? 'active':'' }}" href="{{ route('blog.index') }}">Blog List</a>
                    @endif
                    @if (Auth::guard('admin')->user()->role == '1' || in_array('22', json_decode(Auth::guard('admin')->user()->staff->role->permissions)))
                        <a class="{{ ($route == 'blog.create') ? 'active':'' }}" href="{{ route('blog.create') }}">Blog Add</a>
                    @endif
                </div>
            </li> --}}

            <li
                class="menu-item has-submenu
                {{ $route == 'page.index' ? 'active' : '' }}
                {{ $route == 'page.edit' ? 'active' : '' }}
                {{ $route == 'page.create' ? 'active' : '' }}
            ">
                @if (Auth::guard('admin')->user()->role == '1' ||
                        in_array('88', json_decode(Auth::guard('admin')->user()->staff->role->permissions)) ||
                        in_array('89', json_decode(Auth::guard('admin')->user()->staff->role->permissions)))
                    <a class="menu-link" href="#">
                        <i class="icon material-icons md-pages"></i>
                        <span class="text">Pages</span>
                    </a>
                @endif
                <div class="submenu">
                    @if (Auth::guard('admin')->user()->role == '1' ||
                            in_array('88', json_decode(Auth::guard('admin')->user()->staff->role->permissions)))
                        <a class="{{ $route == 'page.index' ? 'active' : '' }}"
                            href="{{ route('page.index') }}">Page List</a>
                    @endif
                    @if (Auth::guard('admin')->user()->role == '1' ||
                            in_array('89', json_decode(Auth::guard('admin')->user()->staff->role->permissions)))
                        <a class="{{ $route == 'page.create' ? 'active' : '' }}"
                            href="{{ route('page.create') }}">Page Add</a>
                    @endif
                </div>
            </li>
            <li
                class="menu-item has-submenu
                {{ $route == 'accounts.heads' ? 'active' : '' }}
                {{ $route == 'accounts.ledgers' ? 'active' : '' }}
                {{ $route == 'accounts.heads.create' ? 'active' : '' }}
                ">
                @if (Auth::guard('admin')->user()->role == '1' ||
                        in_array('92', json_decode(Auth::guard('admin')->user()->staff->role->permissions)))
                    <a class="menu-link" href="#">
                        <i class="icon material-icons md-person"></i>
                        <span class="text">Accounts</span>
                    </a>
                @endif
                <div class="submenu">
                    @if (Auth::guard('admin')->user()->role == '1' ||
                            in_array('92', json_decode(Auth::guard('admin')->user()->staff->role->permissions)))
                        <a class="{{ $route == 'accounts.ledgers' ? 'active' : '' }}"
                            href="{{ route('accounts.ledgers') }}">Cashbook</a>
                    @endif
                    {{-- <a class="{{ ($route == 'accounts.heads')? 'active':'' }} {{ ($route == 'accounts.heads.create')? 'active':'' }}" href="{{ route('accounts.heads') }}">Account Heads</a> --}}
                </div>
            </li>


            <li
                class="menu-item has-submenu
                {{ $route == 'customer.index' ? 'active' : '' }}
                {{ $route == 'outCustomer' ? 'active' : '' }}
                {{ $route == 'customer.create' ? 'active' : '' }}
                ">
                @if (Auth::guard('admin')->user()->role == '1' ||
                        in_array('94', json_decode(Auth::guard('admin')->user()->staff->role->permissions)) ||
                        in_array('95', json_decode(Auth::guard('admin')->user()->staff->role->permissions)) ||
                        in_array('99', json_decode(Auth::guard('admin')->user()->staff->role->permissions)))
                    <a class="menu-link" href="#">
                        <i class="icon material-icons md-person"></i>
                        <span class="text">User Setting</span>
                    </a>
                @endif
                <div class="submenu">
                    @if (Auth::guard('admin')->user()->role == '1' ||
                            in_array('94', json_decode(Auth::guard('admin')->user()->staff->role->permissions)))
                        <a class="{{ $route == 'customer.index' ? 'active' : '' }}"
                            href="{{ route('customer.index') }}">User list</a>
                    @endif
                    @if (Auth::guard('admin')->user()->role == '1' ||
                            in_array('95', json_decode(Auth::guard('admin')->user()->staff->role->permissions)))
                        <a class="{{ $route == 'outCustomer' ? 'active' : '' }}"
                            href="{{ route('outCustomer') }}">Out User list</a>
                    @endif
                    @if (Auth::guard('admin')->user()->role == '1' ||
                            in_array('99', json_decode(Auth::guard('admin')->user()->staff->role->permissions)))
                        <a class="{{ $route == 'customer.create' ? 'active' : '' }}"
                            href="{{ route('customer.create') }}">User Create</a>
                    @endif
                </div>
            </li>

        </ul>
        <hr />

        <ul class="menu-aside">
            <li
                class="menu-item has-submenu
                {{ $route == 'setting.index' ? 'active' : '' }}
                {{ $route == 'shipping.index' ? 'active' : '' }}
                {{ $route == 'shipping.create' ? 'active' : '' }}
                {{ $route == 'shipping.edit' ? 'active' : '' }}
                {{ $route == 'setting.facebook_plugin_setting' ? 'active' : '' }}
                ">
                @if (Auth::guard('admin')->user()->role == '1' ||
                        in_array('115', json_decode(Auth::guard('admin')->user()->staff->role->permissions)) ||
                        in_array('117', json_decode(Auth::guard('admin')->user()->staff->role->permissions)) ||
                        in_array('119', json_decode(Auth::guard('admin')->user()->staff->role->permissions)) ||
                        in_array('121', json_decode(Auth::guard('admin')->user()->staff->role->permissions)) ||
                        in_array('126', json_decode(Auth::guard('admin')->user()->staff->role->permissions)))
                    <a class="menu-link" href="#">
                        <i class="icon material-icons md-settings"></i>
                        <span class="text">Settings</span>
                    </a>
                @endif
                <div class="submenu">
                    @if (Auth::guard('admin')->user()->role == '1' ||
                            in_array('115', json_decode(Auth::guard('admin')->user()->staff->role->permissions)))
                        <a class="{{ $route == 'setting.index' ? 'active' : '' }}"
                            href="{{ route('setting.index') }}">Home</a>
                    @endif
                    @if (Auth::guard('admin')->user()->role == '1' ||
                            in_array('117', json_decode(Auth::guard('admin')->user()->staff->role->permissions)))
                        <a class="{{ $route == 'setting.activation' ? 'active' : '' }}"
                            href="{{ route('setting.activation') }}">Activation</a>
                    @endif
                    @if (Auth::guard('admin')->user()->role == '1' ||
                            in_array('119', json_decode(Auth::guard('admin')->user()->staff->role->permissions)))
                        <a class="{{ $route == 'setting.facebook_plugin_setting' ? 'active' : '' }}"
                            href="{{ route('setting.facebook_plugin_setting') }}">Facebook Plugin</a>
                    @endif
                    @if (Auth::guard('admin')->user()->role == '1' ||
                            in_array('121', json_decode(Auth::guard('admin')->user()->staff->role->permissions)))
                        <a class="{{ $route == 'shipping.index' || $route == 'shipping.create' || $route == 'shipping.edit' ? 'active' : '' }}"
                            href="{{ route('shipping.index') }}">Shipping Methods</a>
                    @endif
                    @if (Auth::guard('admin')->user()->role == '1' ||
                            in_array('126', json_decode(Auth::guard('admin')->user()->staff->role->permissions)))
                        <a class="{{ $route == 'paymentMethod.config' ? 'active' : '' }}"
                            href="{{ route('paymentMethod.config') }}">Payment Methods</a>
                    @endif
                    {{-- @if (Auth::guard('admin')->user()->role == '1' ||
                            in_array('126', json_decode(Auth::guard('admin')->user()->staff->role->permissions)))
                        <a class="{{ $route == 'seller comission' ? 'active' : '' }}"
                            href="{{ route('paymentMethod.config') }}">Seller Comission</a>
                    @endif --}}
                </div>
            </li>
        </ul>

        <br />
        <br />
        <div class="sidebar-widgets">
            <div class="copyright text-center m-25">
                <p>
                    <strong class="d-block">Admin Dashboard</strong> ©
                    <script>
                        document.write(new Date().getFullYear())
                    </script> All Rights Reserved
                </p>
            </div>
        </div>
    </nav>
</aside>
