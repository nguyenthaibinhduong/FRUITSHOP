    <!-- Humberger Begin -->
    <div class="humberger__menu__overlay"></div>
    <div class="humberger__menu__wrapper">
        <div class="humberger__menu__logo">
            <a href="#"><img src="client/img/logo.png" alt=""></a>
        </div>
        @if(Auth::check())
        <div class="humberger__menu__cart">
            <ul>
                <li><a href="#"><i class="fa fa-heart"></i> <span>1</span></a></li>
                <li><a class="offcanvasToggle" ><i class="fa fa-shopping-bag"></i> <span class="count_cart"></span></a></li>
            </ul>
        </div>
        @endif
        @if(!Auth::check())
        <div class="humberger__menu__widget">
            <div class="header__top__right__language header__top__right__auth">
                 <a href="{{ route('register') }}"><i class="fa fa-user"></i> Đăng ký</a>
            </div>
            <div class="header__top__right__auth">
                <a href="{{ route('login') }}"><i class="fa fa-user"></i> Đăng nhập</a>
            </div>
        </div>
        @else
        <div class="humberger__menu__widget">
            <div class="header__top__right__language header__top__right__auth">
                 <a href="{{ route('information') }}"><i class="fa fa-user"></i> {{ Auth::user()->name }}</a>
            </div>
            <div class="header__top__right__auth">
                <a href="{{ route('logout') }}"></i> Đăng xuất</a>
            </div>
        </div>
        @endif
        <nav class="humberger__menu__nav mobile-menu">
           @include('client.menu.header_menu');
        </nav>
        <div id="mobile-menu-wrap"></div>
        <div class="header__top__right__social">
            <a href="#"><i class="fa fa-facebook"></i></a>
            <a href="#"><i class="fa fa-twitter"></i></a>
            <a href="#"><i class="fa fa-linkedin"></i></a>
            <a href="#"><i class="fa fa-pinterest-p"></i></a>
        </div>
        <div class="humberger__menu__contact">
            <ul>
                <li><i class="fa fa-envelope"></i> hello@colorlib.com</li>
                <li>Free Shipping for all Order of $99</li>
            </ul>
        </div>
    </div>
    <!-- Humberger End -->
    <!-- Offcanvas cart -->
    @if(Auth::check())
    <div class="offcanvas" id="offcanvasExample">

        <h4 class="text-center py-3">Giỏ hàng của bạn</h4>
        <div class="table-responsive">
    
          <table class="table table-borderless">
            <tbody class="cart_table_offcanvas">
            </tbody>
          </table>
          <div class="d-flex justify-content-end w-100">
            <a class="btn btn-dark" href="{{ route('cart') }}">Xem giỏ hàng</a>
        </div>  
        </div>
      </div>
    
    <div class="offcanvas-backdrop" id="offcanvasBackdrop"></div>
  @endif
<!-- Offcanvas end -->