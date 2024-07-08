@php
    $object='post';
    $object_title='bài viết';
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
                    <div class="col-sm-12 col-12">
                        <div class="mb-3">
                            <label class="form-label">Tiêu đề chính {{ $object_title }}<span class="text-red">*</span></label>
                            <input name="title" type="text" class="form-control" placeholder="Nhập tên {{ $object_title }}" autocomplete="off">
                            @error('title')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-12 col-12">
                        <div class="mb-3">
                            <label class="form-label">Mô tả {{ $object_title }}<span class="text-red">*</span></label>
                            <input name="subtitle" type="text" class="form-control" placeholder="Nhập mô tả {{ $object_title }}" autocomplete="off">
                            @error('subtitle')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-6 col-12">
                        <div class="mb-3">
                            <label class="form-label">Tác giả {{ $object_title }}<span class="text-red">*</span></label>
                            <input name="author" type="text" class="form-control" placeholder="Nhập tác giả {{ $object_title }}" autocomplete="off">
                            @error('author')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-6 col-12">
                        <div class="mb-0">
                            <label class="form-label">Trạng thái<span class="text-red">*</span></label>
                            <select class="form-control" name="uploaded" id="">
                                <option value="1">Đăng ngay</option>
                                <option value="0">Chưa đăng</option>
                            </select>
                            @error('uploaded')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-12 col-12">
                        <div class="mb-0">
                            <label class="form-label">Danh mục {{ $object_title }}<span class="text-red">*</span></label>
                            <select class="form-control" name="type_id[]" id="" multiple>
                                {!! $option !!}
                            </select>
                            @error('type_id')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-12 col-12">
                        <div class="mb-0">
                            <label class="form-label">Chọn ảnh {{ $object_title }}<span class="text-red">*</span></label>
                            <input type="file" class="form-control" name="image">
                            @error('image')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                    </div>

                    <div class="col-sm-12 col-12">
                        <div class="mb-0">
                            <label class="form-label">Nội dung</label>
                            <textarea id="my-editor" name="content" rows="20" class="form-control" placeholder="Nhập tiêu nội dung"></textarea>
                            @error('content')
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