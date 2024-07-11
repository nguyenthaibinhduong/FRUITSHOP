<div class="col-lg-3 col-md-5">
    <div class="sidebar">                            
        <div class="sidebar__item">
            <ul>
                <li><a class="{{ Request::is('information')?'text-success font-weight-bold':''}}" href="{{ route('information') }}">Thông tin cá nhân</a></li>
                <li><a class="{{ Request::is('information/orders')?'text-success font-weight-bold':''}}" href="{{ route('orders') }}">Thông tin đơn hàng</a></li>
                <li><a class="" href="">Sản phẩm yêu thích</a></li>
                <li><a class="{{ Request::is('information/new-password')?'text-success font-weight-bold':''}}" href="{{ route('new-password') }}">Đổi mật khẩu</a></li>
                <li><a class="" href="">Đăng xuất</a></li>
            </ul>
        </div>
    </div>
</div>