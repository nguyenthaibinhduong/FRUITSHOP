@php
   $object='role';
   $object_title='vai trò';
@endphp
@extends('admin.layout.master')
@section('breadcrumb')
<ol class="breadcrumb d-md-flex d-none">
    <li class="breadcrumb-item">
        <i class="bi bi-house"></i>
        <a href="{{ route($object) }}">{{ ucfirst($object) }}</a>
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
<form action="{{ route($object.'.update',['id'=>$role->id]) }}" enctype="multipart/form-data" method="post">
    @csrf
    <div class="col-sm-12 col-12">
        <div class="card-border">
            <div class="card-border-title">Thêm {{ $object_title }}</div>
            <div class="card-border-body">

    
                <div class="row">
                    <div class="col-sm-12 col-12">
                        <div class="mb-3">
                            <label class="form-label">Tên {{ $object_title }}<span class="text-red">*</span></label>
                            <input value="{{ $role->name }}" name="name" type="text" class="form-control" placeholder="Nhập tên {{ $object_title }}" autocomplete="off">
                            @error('name')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-12 col-12">
                        <div class="mb-3">
                            <label class="form-label">Tên hiển thị<span class="text-red">*</span></label>
                            <input value="{{ $role->display_name }}" name="display_name" type="text" class="form-control" placeholder="Nhập tên hiển thị" autocomplete="off">
                            @error('display_name')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-12 col-12">
                        <div class="mb-3">
                            <label class="form-label">Nhóm {{ $object_title }}<span class="text-red">*</span></label>
                            <select class="form-control" name="group"  placeholder="Chọn Nhóm {{ $object_title }}">
                                <option {{ ($role->group=="system")?'selected':'' }} value="system">Hệ thống</option>
                                <option {{ ($role->group=="system")?'':'selected' }} value="client">Khách hàng</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if($role->group=="system")
        <div class="card-border">
            <div class="card-border-title">Phân quyền {{ $object_title }}</div>
            <div class="card-border-body">
                <div class="row">
                    @foreach ($permissions as $groupName => $permission)
                        <div class="col-sm-6 col-12">
                            <h5>{{ ucfirst($groupName) }} Group</h5>

                            <div>
                                @foreach ($permission as $item)
                                    <div class="form-check ">
                                        <input {{ ($getAllPermissionOfRole->contains($item->id))?'checked':'' }} class="form-check-input me-2" name="permissions[]" type="checkbox"
                                            value="{{ $item->id }}" id="{{ $item->display_name }}">
                                        <label class="form-label"
                                            for="{{ $item->display_name }}">{{ $item->display_name }}</label>
                                    </div>
                                    @if($loop->iteration%4 ==0)
                                    <hr>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
    
                {{-- <div class="row">
                    <div class="col-sm-12 col-12">
                        
                    </div>
                </div> --}}
            </div>
        </div>
        @endif
    </div>
    <div class="col-sm-12 col-12">
        <div class="custom-btn-group flex-end">
            <button type="submit" class="btn btn-success">Lưu</button>
        </div>
    </div>

</form>

@endsection