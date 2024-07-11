@php
   $object='order';
   $object_title='đơn hàng';
@endphp
@extends('admin.layout.master')
@section('breadcrumb')
<ol class="breadcrumb d-md-flex d-none">
    <li class="breadcrumb-item">
        <i class="bi bi-house"></i>
        <a href="index.html">Giao diện</a>
    </li>
    <li class="breadcrumb-item breadcrumb-active" aria-current="page">{{ ucfirst($object) }}</li>
</ol>
@endsection
@section('content')
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@elseif(session('danger'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('danger') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="card-title">Danh sách {{  $object_title }} </div>
            </div>
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table v-middle">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Mã đơn hàng</th>
                                <th>Khách hàng</th>
                                <th>Giá trị</th>
                                <th>Phương thức thanh toán</th>
                                <th>Thời gian đặt</th>
                                <th>Trạng thái</th>
                                <th></th>   
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                use Carbon\Carbon;
                            @endphp
                            @foreach ($orders as $order)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $order->order_code }}</td>
                                <td>{{ $order->customer_name }}</td>
                                <td>{{ number_format($order->total_price, 0, ',', '.').'đ' }}</td>
                                <td>{{ ($order->payment_method==1)?'Tiền mặt':'Thanh toán online' }}</td>
                                <td>{{ Carbon::parse($order->created_at)->format('d/m/Y h:i:s A') }}</td>
                                <td ><i class="text-success">{{$order->statuses->name }}</i></td>
                                <td><a class="text-primary" href="{{ route('order.detail',['id'=>$order->id]) }}">Xem chi tiết</a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection