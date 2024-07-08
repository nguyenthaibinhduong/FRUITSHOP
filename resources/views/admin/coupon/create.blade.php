@php
    $object='coupon';
    $object_title='mã giảm giá';
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
                            <label class="form-label">{{ ucfirst($object_title) }}<span class="text-red">*</span></label>
                            <input name="name" type="text" class="form-control" placeholder="Nhập tên {{ $object_title }}" autocomplete="off">
                            @error('name')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-6 col-12">
                        <div class="mb-3">
                            <label class="form-label">Nhóm {{ $object_title }}<span class="text-red">*</span></label>
                            <select class="form-control" name="type"  placeholder="Chọn Nhóm {{ $object_title }}">
                                <option value="">Chọn loại giảm giá</option>
                                <option value="1">Giảm giá %</option>
                                <option value="0">Giảm giá tiền</option>
                            </select>
                            @error('type')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-6 col-12">
                        <div class="mb-3">
                            <label class="form-label">Giá trị<span class="text-red">*</span></label>
                            <input name="value" type="text" class="form-control" placeholder="Nhập giá trị {{ $object_title }}" autocomplete="off">
                            @error('value')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-6 col-12">
                        <div class="mb-3">
                            <label class="form-label">Ngày hết hạn<span class="text-red">*</span></label>
                            <input  type="datetime-local" class="form-control" id="expiration_date" name="expiration_date"  >
                            @error('expiration_date')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
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