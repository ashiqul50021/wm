@php
    use App\Models\Seller;
    // use App\Models\VendorRole;
    $prefix = Request::route()->getPrefix();
    $route = Route::current()->getName();
    $user = Auth::guard('seller')->user();

    if ($user->role == '9') {
        $id = Auth::guard('seller')->user()->id;
        $sellerData = Seller::where('user_id', $id)->with('user')->first();
    } else {
        $sellerId = Auth::guard('seller')->user()->seller_id;
        $sellerData = Seller::where('user_id', $sellerId)->with('user')->first();
    }

@endphp
<aside class="navbar-aside bg-primary" id="offcanvas_aside">
    <div class="aside-top">
        <a href="{{ route('seller.dashboard') }}" class="brand-wrap">
            @php
                $logo = get_setting('site_footer_logo');
            @endphp

            @if ($sellerData)
                {{-- @dd($vendorData->shop_profile); --}}
                @if ($sellerData->shop_profile != null)
                    <img src="{{ asset($sellerData->shop_profile) }}" alt="{{ env('APP_NAME') }}"
                        style="height: 50px !important; width: 50px !important; min-width: 50px !important;">
                @else
                    <img src="{{ asset('upload/no_image.jpg') }}" alt="{{ env('APP_NAME') }}"
                        style="height: 30px !important; width: 80px !important; min-width: 80px !important;">
                @endif
            @endif

        </a>

        <div>
            <button class="btn btn-icon btn-aside-minimize"><i
                    class="text-white material-icons md-menu_open"></i></button>
        </div>
    </div>
    <p style="font-size: x-large; font-weight: 600;color: white;padding: 10px">{{ $sellerData->shop_name ?? 'N/A' }}</p>
    <nav>
        <ul class="menu-aside">
            <li class="menu-item {{ $route == 'seller.dashboard' ? 'active' : '' }}">
                <a class="menu-link" href="{{ route('seller.dashboard') }}">
                    <i class="fa-solid fa-house fontawesome_icon_custom"></i>
                    <span class="text">Dashboard</span>
                </a>
            </li>

            <li
                class="menu-item has-submenu
                {{ $route == 'seller.product.add' ? 'active' : '' }}
                {{ $route == 'seller.product.all' ? 'active' : '' }}
                {{ $route == 'seller.product.edit' ? 'active' : '' }}
                {{ $route == 'seller.category.index' ? 'active' : '' }}
                {{ $route == 'seller.category.edit' ? 'active' : '' }}
                {{ $route == 'seller.attribute.index' ? 'active' : '' }}
                {{ $route == 'seller.unit.index' ? 'active' : '' }}
                {{ $route == 'seller.brand.all' ? 'active' : '' }}
                ">
                @if ($user->role == '9')
                    <a class="menu-link" href="#">
                        <i class="fa-solid fa-bag-shopping fontawesome_icon_custom"></i>
                        <span class="text">Products</span>
                    </a>
                @endif
                <div class="submenu">
                    @if ($user->role == '9')
                        <a class="{{ $route == 'seller.product.add' ? 'active' : '' }}"
                            href="{{ route('seller.product.add') }}">Product Add</a>
                    @endif
                    @if ($user->role == '9')
                        <a class="{{ $route == 'seller.product.all' ? 'active' : '' }}"
                            href="{{ route('seller.product.all') }}">Products</a>
                    @endif
                    @if ($user->role == '9')
                        <a class="{{ $prefix == 'seller/category' ? 'active' : '' }}"
                            href="{{ route('seller.category.index') }}">Categories</a>
                    @endif
                    {{-- @if ($user->role == '9')
                        <a class="{{ $route == 'seller.attribute.index' ? 'active' : '' }}"
                            href="{{ route('seller.attribute.index') }}">Attributes</a>
                    @endif --}}
                    @if ($user->role == '9')
                        <a class="{{ $route == 'seller.unit.index' ? 'active' : '' }}"
                            href="{{ route('seller.unit.index') }}">Unit</a>
                    @endif
                    @if ($user->role == '9')
                        <a class="" href="{{ route('seller.brand.all') }}">Brands</a>
                    @endif
                </div>
            </li>



            {{-- <li
                class="menu-item has-submenu
                {{ $route == 'seller.supplier.all' ? 'active' : '' }}
                {{ $route == 'seller.supplier.create' ? 'active' : '' }}
                ">
                @if ($user->role == '9')
                    <a class="menu-link" href="#">
                        <i class="icon material-icons md-stars"></i>
                        <span class="text">Suppliers</span>
                    </a>
                @endif
                <div class="submenu">
                    @if ($user->role == '9')
                        <a class="{{ $route == 'seller.supplier.all' ? 'active' : '' }}"
                            href="{{ route('seller.supplier.all') }}">Supplier List</a>
                    @endif
                    @if ($user->role == '9')
                        <a class="{{ $route == 'seller.supplier.create' ? 'active' : '' }}"
                            href="{{ route('seller.supplier.create') }}">Supplier Add</a>
                    @endif
                </div>
            </li> --}}
            <li
                class="menu-item has-submenu
                {{ $route == 'seller.commission' ? 'active' : '' }}
                ">
                @if ($user->role == '9')
                    <a class="menu-link" href="#">
                        <i class="icon material-icons md-stars"></i>
                        <span class="text">Commissions List</span>
                    </a>
                @endif
                <div class="submenu">
                    @if ($user->role == '9')
                        <a class="{{ $route == 'seller.commission' ? 'active' : '' }}"
                            href="{{ route('seller.commission') }}">Commission List</a>
                    @endif
                </div>
            </li>

            <li
                class="menu-item has-submenu
                {{ $route == 'seller.stock_report.index' ? 'active' : '' }}
                {{ $route == 'seller.saleReport' ? 'active' : '' }}
                ">
                @if (Auth::guard('seller')->user()->role == '9')
                    <a class="menu-link" href="#">
                        <i class="icon material-icons md-pie_chart"></i>
                        <span class="text">Report</span>
                    </a>
                @endif
                <div class="submenu">
                    @if (Auth::guard('seller')->user()->role == '9')
                        <a class="{{ $route == 'seller.stock_report.index' ? 'active' : '' }}"
                            href="{{ route('seller.stock_report.index') }}">Product Stock</a>
                    @endif

                </div>
            </li>



            </li>


        </ul>
        <hr />

        <br />
        <br />
        <div class="sidebar-widgets">
            <div class="copyright text-center m-25">
                <p>
                    <strong class="d-block">{{ $user->name ?? 'seller' }} Dashboard</strong> ©
                    <script>
                        document.write(new Date().getFullYear())
                    </script> All Rights Reserved
                </p>
            </div>
        </div>
    </nav>
</aside>
