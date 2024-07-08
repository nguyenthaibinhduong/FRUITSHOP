@php
    $object='customer';
    $object_title='khách hàng';
    use Carbon\Carbon;
@endphp
@extends('admin.layout.master')
@section('breadcrumb')
<ol class="breadcrumb d-md-flex d-none">
    <li class="breadcrumb-item">
        <i class="bi bi-house"></i>
        <a href="index.html">Khách hàng</a>
    </li>
    <li class="breadcrumb-item breadcrumb-active" aria-current="page">Quản lý {{ $object_title }}</li>
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
            <div class="card-header d-flex justify-content-start">
                <div class="card-title">Danh sách {{  $object_title }} </div>
            </div>
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table v-middle">
                        <thead>
                            <tr>
                                <th></th>  
                                <th>Họ và tên</th>
                                <th>Email</th>
                                <th>Số điện thoại</th>
                                <th>Ngày sinh</th>
                                <th>Giới tính</th>
                                <th>Đơn hàng gần đây</th>
                                <th>Tổng chi tiêu</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    
                                    <td><img width="50px" height="50px" src="{{ ($user->image_url!=null)?asset($user->image_url):asset('img/logo/user-1.jpg') }}" alt=""></td>

                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->phone_number }}</td>
                                    <td>{{ ($user->birth_date!=null)?Carbon::parse($user->birth_date)->format('d/m/Y'):'' }}</td>
                                    <td>
                                        @if($user->gender===1)
                                        Nam
                                        @elseif($user->gender===0)
                                        Nữ
                                        @else
                                        Chưa xác định
                                        @endif
                                    </td>
                                    <td>
                                        {{ ($user->latest_order_date)?Carbon::parse($user->latest_order_date)->format('d/m/Y'):'Chưa có' }}
                                    </td>
                                    <td>
                                        ${{ $user->total }}
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-start">
                                            <a href="{{ route($object.'.detail',['id'=>$user->id]) }}"><i class="bi bi-list fs-5 me-3 "></i></a>
                                            @if($user->id != 1)
                                            <a href="{{ route($object.'.edit',['id'=>$user->id]) }}"><i class="bi bi-pencil-square fs-5 me-3 text-warning"></i></a>
                                            <a href="{{ route($object.'.delete',['id'=>$user->id]) }}"><i class="bi bi-trash-fill fs-5"></i></a>
                                            @endif
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