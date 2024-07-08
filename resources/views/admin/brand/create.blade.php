@php
    $object='brand';
    $object_title='thương hiệu';
@endphp
@extends('admin.layout.master')
@section('breadcrumb')
<ol class="breadcrumb d-md-flex d-none">
    <li class="breadcrumb-item">
        <i class="bi bi-house"></i>
        <a href="{{ route($object) }}">{{ ucfirst($object_title) }}</a>
    </li>
    <li class="breadcrumb-item breadcrumb-active" aria-current="page">Thêm</li>
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
<form action="{{ route($object.'.store') }}" enctype="multipart/form-data" method="post">
    @csrf
    <div class="col-sm-12 col-12">
        <div class="card-border">
            <div class="card-border-title">Thêm {{ $object_title }}</div>
            <div class="card-border-body">

    
                <div class="row">
                    <div class="col-sm-6 col-12">
                        <div class="mb-3">
                            <label class="form-label">Tên {{ $object_title }}<span class="text-red">*</span></label>
                            <input name="name" type="text" class="form-control" placeholder="Nhập tên {{ $object_title }}" autocomplete="off">
                            @error('name')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-12 col-12">
                        <div class="mb-0">
                            <label class="form-label">Email</label>
                            <input type="text" name="email" rows="4" class="form-control" placeholder="Nhập emal NCC" autocomplete="off">
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-12 col-12">
                        <div class="mb-0">
                            <label class="form-label">Số điện thoại</label>
                            <input type="text" name="phone" rows="4" class="form-control" placeholder="Nhập số điện thoại NCC" autocomplete="off">
                            @error('phone')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror   
                        </div>
                    </div>
                    <div class="col-sm-12 col-12">
                        <div class="mb-0">
                            <label class="form-label">Địa chỉ</label>
                            <textarea  name="address" rows="4" class="form-control" placeholder="Nhập Địa chỉ NCC" autocomplete="off"></textarea>
                            @error('address')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror   
                        </div>
                    </div>
                    <div class="col-sm-12 col-12">
                        <div class="mb-0">
                            <label class="form-label">Chọn ảnh {{ ucfirst($object) }}<span class="text-red">*</span></label>
                            <input type="file" class="form-control" name="image">
                            @error('image')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-12">
        <div class="custom-btn-group flex-end">
            <button type="submit" class="btn btn-success">Thêm</button>
        </div>
    </div>

</form>

@endsection