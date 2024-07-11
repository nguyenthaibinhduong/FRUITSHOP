<!-- Page header starts -->
<div class="page-header">

    <div class="toggle-sidebar" id="toggle-sidebar"><i class="bi bi-list"></i></div>

    <!-- Breadcrumb start -->
    @yield('breadcrumb')
    <!-- Breadcrumb end -->

    <!-- Header actions ccontainer start -->
    <div class="header-actions-container">
        <div class="search-container">
        </div>
        <ul class="header-actions">
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