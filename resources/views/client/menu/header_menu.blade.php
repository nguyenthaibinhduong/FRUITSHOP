<ul>
    <li class="{{ Request::is('/')? 'active' : ''}}"><a href="{{ route('home') }}">Home</a></li>
    <li class="{{ Request::is('shop')? 'active' : ''}}"><a href="{{ route('shop') }}">Shop</a></li>
    <li><a href="{{ route('blog') }}">Blog</a>
        <ul class="header__menu__dropdown">
            @foreach($types as $type)
            <li><a href="{{ route('getbytype',['id'=>$type->id]) }}">{{ $type->name }}</a></li>
            @endforeach
        </ul>
    </li>
    <li><a href="{{ route('contact') }}">Contact</a></li>
    <li><a href="{{ route('information') }}">Information</a>
        <ul class="header__menu__dropdown">
            <li><a href="{{ route('information') }}">User Information</a></li>
            <li><a href="{{ route('cart') }}">Shoping Cart</a></li>
            <li><a href="{{ route('orders') }}">Order</a></li>
        </ul>
    </li>
</ul>