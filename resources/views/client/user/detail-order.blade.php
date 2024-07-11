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
                            <h2>Order List</h2>
                            <div class="breadcrumb__option">
                                <a href="{{ route('home') }}">Home</a>
                                <span>Order List</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Breadcrumb Section End -->
    
        <!-- Product Section Begin -->
        <section class="order_details section_gap">
            <div class="container">
                @if($order->status == 9)
                    <h4 class="text-center text-danger py-3 font-weight-bold">You haven't pair for order !</h4>
                    <hr>
                    <div class="d-flex w-100 justify-content-center">
                        <a href="{{ route('payment',['code'=>$order->order_code]) }}" class="btn btn-dark">THANH TOÁN</a>
                    </div>
                @else
                <h3 class="text-center text-success py-3 font-weight-bold">Thank you. Your order has been received !</h3>
                @endif
                <div class="row  pt-4 ">
                    
                    <div class="col-lg-5">
                        <h4 class="py-2 text-center">Thông tin đặt hàng</h4>
                        <div class="bg-success text-white p-4">                            
                            <div class="">
                                <div class="row my-1">
                                    <div class="col-5 font-italic">ID Đơn hàng:</div>
                                    <div class="col-7">{{ $order->order_code }}</div>
                                </div>
                                <div class="row my-1">
                                    <div class="col-5 font-italic">Ngày:</div>
                                    <div class="col-7">{{ Carbon::parse($order->created_at)->format('d/m/Y') }}</div>
                                </div>
                                <div class="row my-1">
                                    <div class="col-5 font-italic">Tổng hóa đơn:</div>
                                    <div class="col-7">{{ number_format($order->total_price, 0, ',', '.').'đ' }}</div>
                                </div>
                                <div class="row my-1">
                                    <div class="col-5 font-italic">Thanh toán: </div>
                                    <div class="col-7">{{ ($order->payment_method==1)?'Tiền mặt':'Thanh toán online' }}</div>
                                </div>
                                <div class="row my-1">
                                    <div class="col-5 font-italic">Tên khách hàng: </div>
                                    <div class="col-7">{{ $order->customer_name }}</div>
                                </div>
                                <div class="row my-1">
                                    <div class="col-5 font-italic">Số điện thoại: </div>
                                    <div class="col-7">{{ $order->customer_tel }}</div>
                                </div>
                                <div class="row my-1">
                                    <div class="col-5 font-italic">Email: </div>
                                    <div class="col-7">{{ $order->customer_email }}</div>
                                </div>
                                <div class="row my-1">
                                    <div class="col-5 font-italic">Địa chỉ giao hàng: </div>
                                    <div class="col-7">{{ $order->customer_address }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <h4 class=" text-center py-2 ">Chi tiết đơn hàng</h4>
                        <div class="order_details_table">
                            <table class="table table-borderless">
                                <thead class="table-dark">
                                    <tr>
                                        <th scope="col">Sản phẩm</th>
                                        <th scope="col">Số lượng</th>
                                        <th scope="col">Thành tiền</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order_detail as $orders)
                                    <tr>
                                        <td>
                                            <p class="text-success font-weight-bold">{{ $orders->product->name }}</p>
                                        </td>
                                        <td>
                                            <h5 class="text-success font-weight-bold">x {{ $orders->quantity }}</h5>
                                        </td>
                                        <td>
                                            <p class="text-success font-weight-bold">${{ number_format($orders->price, 0, ',', '.').'đ' }}</p>
                                        </td>
                                    </tr>
                                    @endforeach
                                    <tr>
                                        <td>
                                            <p>Tổng tiền</p>
                                            <p><i>Giảm giá</i></p>
                                            <p class="font-weight-bold">Tổng thanh toán:</p>
                                        </td>
                                        <td>
                                        </td>
                                        <td> 
                                            <p>{{ number_format($order->total, 0, ',', '.').'đ' }}</p>
                                            <p><i>-{{ number_format($order->discount, 0, ',', '.').'đ' }}</i></p>
                                            <p  class=" font-weight-bold" >${{ number_format($order->total_price, 0, ',', '.').'đ' }}</p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </section>
        <!-- Product Section End -->
@endsection