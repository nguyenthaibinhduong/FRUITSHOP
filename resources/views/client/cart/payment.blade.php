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
                                <a href="{{ route('cart') }}">Checkout</a>
                                <span>Payment</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Breadcrumb Section End -->
           <!-- Checkout Section Begin -->
    <section class="checkout spad p-5">
        <div class="row">
            <div class="col-xl-3 col-lg-3 col-sm-12 col-md-12 mt-2">
                <form action="{{ route('vn-pay') }}" method="post">
                    @csrf
                    <input type="text" name="order_id" value={{ $order->id }} hidden>
                    <button type="submit" name="redirect" class="btn btn-outline-dark w-100">Thanh toán VNPAY <img width="80px" height="40px" src="https://stcd02206177151.cloud.edgevnpay.vn/assets/images/logo-icon/logo-primary.svg"  alt=""></button>
                </form>
            </div>
           
            <div  class="col-xl-3 col-lg-3 col-sm-12 col-md-12 mt-2">
                <form action="{{ route('mm-pay') }}" method="post">
                @csrf
                <input type="text" name="order_id" value={{ $order->id }} hidden>
                <button type="submit" class="btn btn-outline-dark w-100">Thanh toán MOMO <img width="80px" height="40px" src="{{ asset('img/logo/momo_icon_square_pinkbg.svg') }}"  alt=""></button>
            </form>
            </div>
            
        </div>
    </section>
    <!-- Checkout Section End -->
@endsection