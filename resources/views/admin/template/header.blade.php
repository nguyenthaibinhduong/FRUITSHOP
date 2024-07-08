<!-- Page header starts -->
<div class="page-header">

    <div class="toggle-sidebar" id="toggle-sidebar"><i class="bi bi-list"></i></div>

    <!-- Breadcrumb start -->
    @yield('breadcrumb')
    <!-- Breadcrumb end -->

    <!-- Header actions ccontainer start -->
    <div class="header-actions-container">

        <!-- Search container start -->
        <div class="search-container">

            <!-- Search input group start -->
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Search anything">
                <button class="btn" type="button">
                    <i class="bi bi-search"></i>
                </button>
            </div>
            <!-- Search input group end -->

        </div>
        <!-- Search container end -->

        <!-- Leads start -->
        <a href="orders.html" class="leads d-none d-xl-flex">
            <div class="lead-details">You have <span class="count"> 21 </span> new leads </div>
            <span class="lead-icon"><i
                    class="bi bi-bell-fill animate__animated animate__swing animate__infinite infinite"></i><b
                    class="dot animate__animated animate__heartBeat animate__infinite"></b></span>
        </a>
        <!-- Leads end -->

        <!-- Header actions start -->
        <ul class="header-actions">
            <li class="dropdown d-none d-md-block">
                <a href="#" id="countries" data-toggle="dropdown" aria-haspopup="true">
                    <img src="{{ asset('admins/assets/images/flags/1x1/br.svg') }}" class="flag-img" alt="Admin Panels" />
                </a>
                <div class="dropdown-menu dropdown-menu-end mini" aria-labelledby="countries">
                    <div class="country-container">
                        <a href="index.html">
                            <img src="{{ asset('admins/assets/images/flags/1x1/us.svg') }}" alt="Clean Admin Dashboards" />
                        </a>
                        <a href="index.html">
                            <img src="{{ asset('admins/assets/images/flags/1x1/in.svg') }}" alt="Google Dashboards" />
                        </a>
                        <a href="index.html">
                            <img src="{{ asset('admins/assets/images/flags/1x1/gb.svg') }}" alt="AI Admin Dashboards" />
                        </a>
                        <a href="index.html">
                            <img src="{{ asset('admins/assets/images/flags/1x1/tr.svg') }}" alt="Modern Dashboards" />
                        </a>
                        <a href="index.html">
                            <img src="{{ asset('admins/assets/images/flags/1x1/ca.svg') }}" alt="Best Admin Dashboards" />
                        </a>
                    </div>
                </div>
            </li>
            <li class="dropdown">
                <a href="#" id="userSettings" class="user-settings" data-toggle="dropdown" aria-haspopup="true">
                    <span class="user-name d-none d-md-block">{{ Auth::user()->name }}</span>
                    <span class="avatar">
                        <img src="{{ (Auth::user()->image_url)?asset(Auth::user()->image_url):asset('img/logo/user-1.jpg') }}" alt="Admin Templates">
                        <span class="status online"></span>
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="userSettings">
                    <div class="header-profile-actions">
                        <a href="profile.html">Profile</a>
                        <a href="account-settings.html">Settings</a>
                        <a href="{{ route('logout') }}">Đăng xuất</a>
                        </form>
                    </div>
                </div>
            </li>
        </ul>
        <!-- Header actions end -->

    </div>
    <!-- Header actions ccontainer end -->

</div>
<!-- Page header ends -->