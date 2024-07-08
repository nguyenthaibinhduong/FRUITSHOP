@php
   $object='user';
   $object_title='tài khoản';
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
            <div class="card-border-title">Thêm {{ $object_title }}</div>
            <div class="card-border-body">

    
                <div class="row">
                    <div class="col-sm-12 col-12">
                        <div class="mb-3">
                            <label class="form-label">Tên {{ $object_title }}<span class="text-red">*</span></label>
                            <input name="name" type="text" class="form-control" placeholder="Nhập tên {{ $object_title }}" autocomplete="off">
                            @error('name')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-12 col-12">
                        <div class="mb-3">
                            <label class="form-label">Email<span class="text-red">*</span></label>
                            <input name="email" type="text" class="form-control" placeholder="Nhập Email" autocomplete="off">
                            @error('email')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-12 col-12">
                        <div class="mb-3">
                            <label class="form-label">Mật khẩu<span class="text-red">*</span></label>
                            <input name="password" type="password" class="form-control" placeholder="Nhập mật khẩu" autocomplete="off">
                            @error('password')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-12 col-12">
                        <div class="mb-3">
                            <label class="form-label">Nhập lại mật khẩu<span class="text-red">*</span></label>
                            <input name="password_confirmation" type="password" class="form-control" placeholder="Nhập mật khẩu" autocomplete="off">
                            @error('password')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-12 col-12">
                        <div class="mb-3">
                            <label class="form-label">Vai trò<span class="text-red">*</span></label>
                            <select multiple class="form-control" size="{{ $roles->count() }}" name="role[]"  placeholder="Chọn vai trò {{ $object_title }}">
                                @foreach ($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
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