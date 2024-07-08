@php
   $object='coupon';
   $object_title='mã giảm giá';
   use Carbon\Carbon;
@endphp
@extends('admin.layout.master')
@section('breadcrumb')
<ol class="breadcrumb d-md-flex d-none">
    <li class="breadcrumb-item">
        <i class="bi bi-house"></i>
        <a href="index.html">Sản phẩm</a>
    </li>
    <li class="breadcrumb-item breadcrumb-active" aria-current="page">{{ ucfirst($object_title) }}</li>
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
                <a class="btn btn-info" href="{{ route($object.'.create') }}"><i class="bi bi-plus-square"></i> Thêm</a>
            </div>
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table v-middle">
                        <thead>
                            <tr>
                                <th>Tên {{ $object_title }}</th>
                                <th>Loại {{ $object_title }}</th>
                                <th>Giá trị</th>
                                <th>Ngày hết hạn</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($coupons as $coupon)
                            <tr>
                                <td>{{ $coupon->name }}</td>
                                <td>{{ ($coupon->type==1)?'Giảm giá %':'Giảm giá tiền' }}</td>
                                <td>{{ ($coupon->type==1)?($coupon->value.'%'):(number_format($coupon->value, 0, ',', '.').'đ')}}</td>
                                <td>{{ Carbon::parse($coupon->expiration_date)->format('d/m/Y') }}</td>
                                <td>
                                    <div class="d-flex justify-content-end">
                                        <a href="{{ route($object.'.edit',['id'=>$coupon->id]) }}"><i class="bi bi-pencil-square fs-5 me-3 text-warning"></i></a>
                                        <a href="{{ route($object.'.delete',['id'=>$coupon->id]) }}"><i class="bi bi-trash-fill fs-5"></i></a>
                                    </div>
                                </td>
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