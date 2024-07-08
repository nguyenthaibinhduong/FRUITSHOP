<div class="hero__search">
    <div class="hero__search__form">
        <form action="{{ route('search') }}" method="get">
            @csrf
            <input class="ajaxSearch" name="key" type="text" placeholder="Nhập sản phẩm tìm kiếm....">
            
            <button type="submit" class="site-btn">Search</button>
        </form>
        
    </div>
    <div class="list-group resultSearch">
    </div>
    <div class="hero__search__phone">
        <div class="hero__search__phone__icon">
            <i class="fa fa-phone"></i>
        </div>
        <div class="hero__search__phone__text">
            <h5>+65 11.188.888</h5>
            <span>support 24/7 time</span>
        </div>
    </div>
</div>

