@php
use Carbon\Carbon;   
@endphp
@extends('client.layout.master_layout')
@section('content')
        <!-- Breadcrumb Section Begin -->
        <section class="breadcrumb-section set-bg" data-setbg="{{ asset('client/img/breadcrumb.jpg') }}">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <div class="breadcrumb__text">
                            <h2>Cart</h2>
                            <div class="breadcrumb__option">
                                <a href="{{ route('shop') }}">Shop</a>
                                <span>Cart</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Breadcrumb Section End -->
        <!-- Shoping Cart Section Begin -->
        <section class="shoping-cart spad">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="shoping__cart__table">
                            <table>
                                <thead>
                                    <tr>
                                        <th class="shoping__product">Products</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Total</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <form action="{{ route('cart.update') }}" method="post">
                                    @csrf
                                    @foreach($cartproduct as $cart)
                                    <tr>
                                        <input type="text" name="product_id[]" value="{{ $cart->product_id }}" hidden>
                                        <td class="shoping__cart__item">
                                            @foreach($images as $image)
                                            @if($image->product_id==$cart->product_id)
                                            <img width="100px" height="100px" src="{{ asset($image->url) }}" alt="">
                                            @endif
                                            @endforeach
                                            <h5>{{ $cart->product_name }}</h5>
                                        </td>
                                        <td class="shoping__cart__price">
                                            {{ number_format($cart->product_price, 0, ',', '.').' đ' }}
                                        </td>
                                        <td class="shoping__cart__quantity">
                                            <div class="quantity">
                                                <div class="pro-qty">
                                                    <input name="quantity[]" type="text" value="{{ $cart->quantity }}">
                                                </div>
                                            </div>
                                        </td>
                                        <td class="shoping__cart__total">
                                            {{ number_format($cart->product_price*$cart->quantity, 0, ',', '.').'đ' }}
                                        </td>
                                        <td class="shoping__cart__item__close">
                                            <a href="{{ route('cart.delete',['id'=>$cart->product_id]) }}"><span class="icon_close"></span></a>
                                            
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="shoping__cart__btns">
                            <a href="{{ route('shop') }}" class="primary-btn cart-btn">CONTINUE SHOPPING</a>
                            <button type="submit" class="primary-btn cart-btn cart-btn-right border-0"><span class="icon_loading"></span>
                                Update Cart</button>
                        </div>
                    </form>
                    </div>
                    <div class="col-lg-6">
                        <div class="shoping__continue">
                            <div class="shoping__discount">
                                <h5>Discount Codes</h5>
                                <form action="{{ route('cart.coupon') }}" method="post">
                                    @csrf
                                    @if(session('coupon'))
                                    <a class="text-danger" href="{{ route('cart.coupon.delete') }}">Xóa </a>
                                    @endif
                                    <input {{ (session('coupon'))?'disabled':'' }} value="{{ (session('coupon'))?session('coupon'):'' }}" name="coupon" type="text" placeholder="Enter your coupon code">
                                    <button type="submit" class="site-btn">APPLY COUPON</button>
                                    
                                </form>

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="shoping__checkout">
                            <h5>Cart Total</h5>
                            <ul>
                                <li>Subtotal <span>{{ number_format($oldtotal, 0, ',', '.').'đ' }}</span></li>
                                <li>Discount <span style="color: black">-{{ number_format(session('discount'), 0, ',', '.').'đ' }}</span></li>
                                <li>Total <span>{{ number_format($subtotal, 0, ',', '.').'đ' }}</span></li>
                            </ul>
                            <a href="{{ route('cart.checkout') }}" class="primary-btn">PROCEED TO CHECKOUT</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Shoping Cart Section End -->
@endsection


   


