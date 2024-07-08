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
        <section class="product spad">
            <div class="container">
                <div class="row">
                    @include('client.template.usersidebar')
                    <div class="col-lg-9 col-md-7">
                        <table class="table table-striped table-hover">
                            <thead>
                              <tr>
                                <th scope="col">Thứ tự</th>
                                <th scope="col">Mã đơn hàng</th>
                                <th scope="col">Giá trị</th>
                                <th scope="col">Trạng thái</th>
                                <th scope="col">Thời gian đặt</th>
                                <th></th>
                              </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $order->order_code }}</td>
                                    <td>{{ number_format($order->total_price, 0, ',', '.').'đ' }}</td>
                                    <td><i class="font-weight-bold">{{ $order->statuses->name }}</i></td>
                                    <td>{{ $order->created_at->format('d/m/Y h:i:s A')}}</td>
                                    <td>
                                        <a class="text-primary" href="{{ route('orders.detail',['id'=>$order->id]) }}">Xem chi tiết >></a>
                                    </td>
                                </tr>
                              @endforeach
                            </tbody>
                          </table>
                    </div>
                </div>
            </div>
        </section>
        <!-- Product Section End -->
@endsection