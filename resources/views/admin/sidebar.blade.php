<aside class="main-sidebar col-12 col-md-3 col-lg-2 px-0">
    <div class="main-navbar">
        <nav class="navbar align-items-stretch navbar-light bg-white flex-md-nowrap border-bottom p-0">
            <a class="navbar-brand w-100 mr-0" href="{{ route('admin.dashboard') }}" style="line-height: 25px;">
                <div class="d-table m-auto">
                    <img id="main-logo" class="d-inline-block align-top mr-1" style="max-width: 100px;"
                        src="{{asset('img/bvend_web_logo.png')}}" alt="Bvend Logo">
                    {{-- <span class="d-none d-md-inline ml-1">@yield('role')</span> --}}
                </div>
            </a>
            <a class="toggle-sidebar d-sm-inline d-md-none d-lg-none">
                <i class="material-icons">&#xE5C4;</i>
            </a>
        </nav>
    </div>
    {{-- <form action="#" class="main-sidebar__search w-100 border-right d-sm-flex d-md-none d-lg-none">
        <div class="input-group input-group-seamless ml-3">
            <div class="input-group-prepend">
                <div class="input-group-text">
                    <i class="fas fa-search"></i>
                </div>
            </div>
            <input class="navbar-search form-control" type="text" placeholder="Search for something..."
                aria-label="Search">
        </div>
    </form> --}}
    <div class="nav-wrapper">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link " href="{{ route('admin.dashboard') }}">
                    <!-- <i class="material-icons">person</i> -->
                    <span>Dashboard</span>
                </a>
            </li>
            <!-- <li class="nav-item">
                <a class="nav-link " href="">
                <i class="material-icons">person</i>
                <span>Manager</span>
                </a>
                </li> -->
            <li class="nav-item">
                <a class="nav-link" href="{{route('vendor_account_active')}}">
                    <!-- <i class="material-icons">person</i> -->
                    <span>Vendor</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('product_index')}}">
                    <!-- <i class="material-icons">storefront</i> -->
                    <span>Product</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('admin_transaction_search')}}">
                    <!-- <i class="material-icons">storefront</i> -->
                    <span>Transaction</span>
                </a>
            </li>
        </ul>
    </div>
</aside>