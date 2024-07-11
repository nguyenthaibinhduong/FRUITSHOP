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
                            <h2>Checkout</h2>
                            <div class="breadcrumb__option">
                                <a href="{{ route('cart') }}">Cart</a>
                                <span>Checkout</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Breadcrumb Section End -->
           <!-- Checkout Section Begin -->
    <section class="checkout spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h6><span class="icon_tag_alt"></span> Have a coupon? <a href="#">Click here</a> to enter your code
                    </h6>
                </div>
            </div>
            <div class="checkout__form">
                <h4>Billing Details</h4>
                <form action="{{ route('cart.order.create') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-lg-8 col-md-6">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="checkout__input">
                                        <p>Họ và Tên<span>*</span></p>
                                        <input class="text-dark" value="{{ $customer->name }}" name="name" type="text">
                                        @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p>Số điện thoại<span>*</span></p>
                                        <input class="text-dark" value="{{ $customer->phone_number }}" name="phone_number"  type="text">
                                        @error('phone_number')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                   
                                </div>
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p>Email<span>*</span></p>
                                        <input class="text-dark" value="{{ $customer->email }}" name="email" type="text">
                                        @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="checkout__input">
                                <p>Địa chỉ<span>*</span></p>
                                <textarea  name="address" type="text" class="form-control" placeholder="Street Address" class="checkout__input__add">{{ $customer->address }}</textarea>
                                @error('address')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="checkout__order">
                                <h4>Your Order</h4>
                                <div class="checkout__order__products">Products <span>Total</span></div>
                                <ul>
                                    @foreach ($cartproduct as $cart)
                                        <li>{{ $cart->product_name }} <span>{{ number_format($cart->product_price*$cart->quantity, 0, ',', '.').'đ' }}</span></li>
                                    @endforeach
                                    
                                </ul>
                                <div class="checkout__order__subtotal">Subtotal <span>{{ number_format($oldtotal, 0, ',', '.').'đ' }}</span></div>
                                <div class="checkout__order__total">Discount <span class="text-dark">-{{ number_format(session('discount'), 0, ',', '.').'đ' }}</span></div>
                                <div class="checkout__order__total">Total <span>{{ number_format($subtotal, 0, ',', '.').'đ' }}</span></div>
                                <div class="checkout__input__checkbox">
                                    <label for="payment">
                                        Tiền mặt
                                        <input checked  value="1" name="payment_method" type="radio" id="payment">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="checkout__input__checkbox">
                                    <label for="paypal">
                                        Thanh toán online
                                        <input  value="0" name="payment_method" type="radio" id="paypal">
                                        <span class="checkmark">
                                            
                                        </span>
                                    </label>
                                    <br>
                                    <img width="80px" height="40px" src="https://stcd02206177151.cloud.edgevnpay.vn/assets/images/logo-icon/logo-primary.svg"  alt="">
                                    <img width="80px" height="40px" src="{{ asset('img/logo/momo_icon_square_pinkbg.svg') }}"  alt="">
                                </div>
                                <input  type="number" name="cart_id" value="{{ $cart_id }}" hidden>
                                <input  type="text" name="discount" value="{{ session('discount') }}" hidden>
                                <input  type="text" name="total" value="{{ $oldtotal }}" hidden>
                                <input type="text" value="{{ $subtotal }}" name="subtotal" hidden>
                                <button type="submit" class="site-btn">PLACE ORDER</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!-- Checkout Section End -->
@endsection