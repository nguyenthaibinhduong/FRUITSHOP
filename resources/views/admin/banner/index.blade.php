@php
    $object='banner'
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
                <div class="card-title">Danh sách {{ ucfirst($object) }} </div>
                <a class="btn btn-info" href="{{ route($object.'.create') }}"><i class="bi bi-plus-square"></i> Thêm</a>
            </div>
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table v-middle">
                        <thead>
                            <tr>
                                <th>Tên {{ $object }}</th>
                                <th>Tiêu đề chính</th>
                                <th>Tiêu đề phụ </th>
                                <th>Trạng thái</th>
                                <th>Ảnh</th>
                                <th></th>
                               
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($banners as $banner)
                                <tr>
                                    <td>{{ $banner->name }}</td>
                                    <td>{{ $banner->title }}</td>
                                    <td>{{ $banner->sub_title }}</td>
                                    <td>{{ ($banner->uploaded==1)?'Đã đăng':'' }}</td>
                                    <td><img width="100px" height="50px" src="{{ asset($banner->image) }}" alt=""></td>
                                    <td>
                                        <div class="d-flex justify-content-end">
                                            <a href="{{ route($object.'.edit',['id'=>$banner->id]) }}"><i class="bi bi-pencil-square fs-5 me-3 text-warning"></i></a>
                                            <a href="{{ route($object.'.delete',['id'=>$banner->id]) }}"><i class="bi bi-trash-fill fs-5"></i></a>
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