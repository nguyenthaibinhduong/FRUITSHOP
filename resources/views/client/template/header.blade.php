    <!-- Header Section Begin -->
    <header class="header">
        <div class="header__top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="header__top__left">
                            <ul>
                                <li><i class="fa fa-envelope"></i> hello@colorlib.com</li>
                                <li>{{ (Auth::check())?"Xin chào ".Auth::user()->name." !":"" }}</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="header__top__right">
                            <div class="header__top__right__social">
                                <a href="#"><i class="fa fa-facebook"></i></a>
                                <a href="#"><i class="fa fa-twitter"></i></a>
                                <a href="#"><i class="fa fa-linkedin"></i></a>
                                <a href="#"><i class="fa fa-pinterest-p"></i></a>
                            </div>
                            <div class="header__top__right__language">
                                <img src="{{ asset('client/img/language.png') }}" alt="">
                                <div>English</div>
                                <span class="arrow_carrot-down"></span>
                                <ul>
                                    <li><a href="#">Spanis</a></li>
                                    <li><a href="#">English</a></li>
                                </ul>
                            </div>
                            <div class="header__top__right__auth">
                                @if(Auth::check())
                                <a href="{{ route('information') }}"><i class="fa fa-user"></i>{{ Auth::user()->name }}</a>
                                @else
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="header__logo">
                        <a href="./index.html"><img src="{{ asset('client/img/logo.png') }}" alt=""></a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <nav class="header__menu">
                      @include('client.menu.header_menu') 
                    </nav>
                </div>
                <div class="col-lg-3">
                    @if(auth::check())
                    <input value="{{ auth::user()->id }}" type="text" id="user_id" hidden>
                    <div class="header__cart">
                        <ul>
                            <li><a href="#"><i class="fa fa-heart"></i> </a></li>
                            <li><a class="offcanvasToggle"><i class="fa fa-shopping-bag"></i> <span class="count_cart"></span></a></li>
                        </ul>
                        <div class="header__cart__price"><a class="btn btn-dark" href="{{ route('logout') }}">Đăng xuất</a></div>
                    </div>
                    @else
                        <div class="header__cart">
                            <ul>
                                <a class="text-dark" href="{{ route('register') }}"></i>Đăng ký</a>
                            </ul>
                            <div class="header__cart__price"><a class="btn btn-dark" href="{{ route('login') }}">Đăng nhập</a></div>
                        </div>
                    @endif
                </div>
            </div>
            <div class="humberger__open">
                <i class="fa fa-bars"></i>
            </div>
        </div>
    </header>
    <!-- Header Section End -->