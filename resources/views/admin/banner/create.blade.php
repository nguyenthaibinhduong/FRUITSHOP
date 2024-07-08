@php
    $object='banner'
@endphp
@extends('admin.layout.master')
@section('breadcrumb')
<ol class="breadcrumb d-md-flex d-none">
    <li class="breadcrumb-item">
        <i class="bi bi-house"></i>
        <a href="{{ route($object) }}">{{ ucfirst($object) }}</a>
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
            <div class="card-border-title">Thêm {{ ucfirst($object) }}</div>
            <div class="card-border-body">

    
                <div class="row">
                    <div class="col-sm-6 col-12">
                        <div class="mb-3">
                            <label class="form-label">Tên {{ ucfirst($object) }}<span class="text-red">*</span></label>
                            <input name="name" type="text" class="form-control" placeholder="Nhập tên {{ ucfirst($object) }}" autocomplete="off">
                            @error('name')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-12 col-12">
                        <div class="mb-0">
                            <label class="form-label">Tiêu đề chính</label>
                            <textarea name="title" rows="4" class="form-control"placeholder="Nhập tiêu đề chính"></textarea>
                            @error('title')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-12 col-12">
                        <div class="mb-0">
                            <label class="form-label">Tiêu đề phụ</label>
                            <textarea name="sub_title" rows="4" class="form-control" placeholder="Nhập tiêu đề phụ"></textarea>
                            @error('sub_title')
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
                    <div class="col-sm-12 col-12">
                        <div class="mb-0">
                            <label class="form-label">Trạng thái - Mặc định : Chưa Upload</span></label>
                            <select name="uploaded" class="form-control">
                                <option value="0">Chưa Upload</option>
                                <option value="1">Upload ngay</option>
                            </select>
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