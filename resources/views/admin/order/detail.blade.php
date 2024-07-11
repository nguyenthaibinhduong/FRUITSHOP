@php
   $object='order';
   $object_title='đơn hàng';
@endphp
@extends('admin.layout.master')
@section('breadcrumb')
<ol class="breadcrumb d-md-flex d-none">
    <li class="breadcrumb-item">
        <i class="bi bi-house"></i>
        <a href="{{ route($object) }}">Chi tiết {{ $object_title }}</a>
    </li>
    <li class="breadcrumb-item breadcrumb-active" aria-current="page">Chỉnh sửa</li>
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
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h3 class="m-0 font-weight-bold text-primary text-center">Đơn hàng {{ $order->order_code }}</h3>
    </div>
    <div class="card-body">
        <h6 class="m-0 font-weight-bold text-primary">Cập nhật trạng thái</h6><br>
        
        <form action="{{ route($object.'.update',['id'=>$order->id]) }}" method="post">
            @csrf
            <div class="row">
                <div class="col-xl-10">
                    <select name="status" id="" class="form-control">
                        @foreach($status as $status)
                        @if($status->id==$order->status)
                        <option selected value="{{ $status->id }}">{{ $status->name }}</option>
                        @else
                        <option value="{{ $status->id }}">{{ $status->name }}</option>
                        @endif
                        @endforeach
                    </select>
                </div>
                <div class="col-xl-2 d-flex justify-content-end">
                    <button class="btn btn-primary" type="submit">Cập nhật</button>
                </div>
            </div>
            
        </form>
    </div>
    <div class="card-body">
        <h6 class="m-0 font-weight-bold text-primary">Thông tin mua hàng</h6><br>
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <tbody>
                    @php
                        use Carbon\Carbon;
                    @endphp
                    <tr>
                        <td>Mã đơn hàng</td>
                        <td>{{ $order->order_code }}</td>
                    </tr>
                    <tr>
                        <td>Thời gian đặt hàng </td>
                        <td>{{ Carbon::parse($order->created_at)->toDayDateTimeString() }}</td>
                    </tr>
                    <tr>
                        <td>Tên tài khoản</td>
                        <td>{{ $order->user->name }}</td>
                    </tr>
                    <tr>
                        <td>Tên khách hàng</td>
                        <td>{{ $order->customer_name }}</td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td>{{ $order->customer_email }}</td>
                    </tr>
                    <tr>
                        <td>Số điện thoại</td>
                        <td>{{ $order->customer_tel }}</td>
                    </tr>
                    <tr>
                        <td>Địa chỉ</td>
                        <td>{{ $order->customer_address }}</td>
                    </tr>
                    <tr>
                        <td>Hình thức thanh toán</td>
                        <td>{{ ($order->payment_method==1)?'Tiền mặt':'Thanh toán online' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-body">
        <h6 class="m-0 font-weight-bold text-primary">Sản phẩm mua</h6><br>
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Sản phẩm</th>
                        <th>Số lượng</th>
                        <th>Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order_detail as $orders)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $orders->product_name }}</td>
                        <td>{{ $orders->quantity }}</td>
                        <td>{{ number_format($orders->price, 0, ',', '.').'đ' }}</td>
                    </tr>
                    @endforeach
                    
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-body">
        <h6 class="m-0 font-weight-bold text-primary">Đơn giá</h6><br>
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <tbody>
                    <tr>
                       
                        <td>Tổng đơn giá</td>
                        <td>{{ number_format($order->total, 0, ',', '.').'đ' }}</td>
                    </tr>
                    <tr>
                        
                        <td>Khấu trừ</td>
                        <td>-{{ number_format($order->discount, 0, ',', '.').'đ' }}</td>
                    </tr>
                    <tr>
                        <td><p class="text-dark" style="font-weight: 800">Tổng hóa đơn</p></td>
                        <td><p class="text-dark" style="font-weight: 800">{{ number_format($order->total_price, 0, ',', '.').'đ' }}</p></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection