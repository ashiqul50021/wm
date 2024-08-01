@php
  $prefix = Request::route()->getPrefix();
  $route = Route::current()->getName();
@endphp
<aside class="navbar-aside bg-primary" id="offcanvas_aside">
    <div class="aside-top">
        <a href="{{ route('worker.dashboard') }}" class="brand-wrap">
            @php
                $logo = get_setting('site_footer_logo');
            @endphp
            @if($logo != null)
                <img src="{{ asset(get_setting('site_footer_logo')->value ?? ' ') }}" alt="{{ env('APP_NAME') }}"  style="height: 30px !important; width: 100px !important; min-width: 100px !important;">
            @else
                <img src="{{ asset('upload/no_image.jpg') }}" alt="{{ env('APP_NAME') }}" style="height: 30px !important; width: 80px !important; min-width: 80px !important;">
            @endif
        </a>
        <div>
            <button class="btn btn-icon btn-aside-minimize"><i class="text-white material-icons md-menu_open"></i></button>
        </div>
    </div>
    <nav>
        <ul class="menu-aside">
            <li class="menu-item {{ ($route == 'worker.dashboard')? 'active':'' }}">
                <a class="menu-link" href="{{ route('worker.dashboard') }}">
                    <i class="fa-solid fa-house fontawesome_icon_custom"></i>
                    <span class="text">Dashboard</span>
                </a>
            </li>

            {{-- <li class="menu-item has-submenu
                {{ ($prefix == 'dealer/product') ? 'active' : '' }}
            ">
                <a class="menu-link" href="#">
                    <i class="fa-solid fa-bag-shopping fontawesome_icon_custom"></i>
                    <span class="text">Products</span>
                </a>
                <div class="submenu">
                    <a class="{{ ($route == 'dealer.product.all') ? 'active':'' }}" href="{{ route('dealer.product.all') }}">Products</a>
                </div>
            </li> --}}

            <li class="menu-item has-submenu {{ ($route == 'worker.worker.vieworder')||($route == 'worker.worker.pending') ||($route == 'worker.worker.confirmed') ?'active':'' }}">
                    <a class="menu-link" href="#">
                        <i class="icon material-icons md-shopping_cart"></i>
                        <span class="text">Orders</span>
                    </a>
                <div class="submenu">
                    <a class="{{ ($route == 'worker.worker.vieworder') ? 'active':'' }}" href="{{ route('worker.worker.vieworder') }}" >View Order</a>

                    <a class="{{ ($route == 'worker.worker.pending') ? 'active':'' }}" href="{{ route('worker.worker.pending') }}" >Pending Order</a>
                    <a class="{{ ($route == 'worker.worker.confirmed') ? 'active':'' }}" href="{{ route('worker.worker.confirmed') }}" >Confirmed Order</a>
                </div>



            </li>
            <li class="menu-item has-submenu {{ ($route == 'worker.worker.viewPayment')?'active':'' }}">
                    <a class="menu-link" href="#">
                        <i class="icon material-icons md-shopping_cart"></i>
                        <span class="text">Payment</span>
                    </a>
                <div class="submenu">
                    <a class="{{ ($route == 'worker.worker.viewPayment') ? 'active':'' }}" href="{{ route('worker.worker.viewPayment') }}" >View Payment info</a>

                </div>
            </li>

        </ul>
        <hr />

        <br />
        <br />
        <div class="sidebar-widgets">
           <div class="copyright text-center m-25">
              <p>
                 <strong class="d-block">Worker Dashboard</strong> © <script>document.write(new Date().getFullYear())</script> All Rights Reserved
              </p>
           </div>
        </div>
    </nav>
</aside>
