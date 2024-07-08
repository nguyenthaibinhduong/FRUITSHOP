@php
    $object='post';
    $object_title='bài viết';
    use Carbon\Carbon;
@endphp
@extends('admin.layout.master')
@section('breadcrumb')
<ol class="breadcrumb d-md-flex d-none">
    <li class="breadcrumb-item">
        <i class="bi bi-house"></i>
        <a href="index.html">Bài viết</a>
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
                <div class="card-title">Danh sách {{ $object_title }} </div>
                <a class="btn btn-info" href="{{ route($object.'.create') }}"><i class="bi bi-plus-square"></i> Thêm</a>
            </div>
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table v-middle">
                        <thead>
                            <tr>
                                <th>Tiêu đề</th>
                                <th>Tác giả</th>
                                <th>Danh mục</th>
                                <th>Trạng thái</th>
                                <th>Người tạo </th>
                                <th>Ngày tạo </th>
                                <th>Ngày đăng </th>
                                <th>Ảnh {{ $object_title }}</th>
                                <th></th>
                               
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($posts as $post)
                                <tr>
                                    <td>{{ $post->title }}</td>
                                    <td>{{ $post->author }}</td>
                                    <td>
                                        @foreach($selected_types as $selected_type)
                                        @if($selected_type->post_id==$post->id)
                                            @foreach($types as $type)
                                                @if($type->id == $selected_type->type_id)
                                                    <i class="me-1 ms-1">{{ $type->name }}</i>
                                                @endif
                                            @endforeach
                                        @endif
                                        @endforeach 
                                    </td>
                                    <td>{{ ($post->uploaded==1)?'Đã đăng':'Bản nháp' }}</td>
                                    <td>{{ $post->user->name }}</td>
                                    <td>{{ $post->created_at->format('d/m/Y') }}</td>
                                    <td>{{ ($post->uploaded==1)?(Carbon::parse($post->public_date)->format('d/m/Y')):'' }}</td>
                                    <td><img width="100px" height="50px" src="{{ asset($post->image) }}" alt=""></td>
                                    <td>
                                        <div class="d-flex justify-content-end">
                                            <a href="{{ route($object.'.edit',['id'=>$post->id]) }}"><i class="bi bi-pencil-square fs-5 me-3 text-warning"></i></a>
                                            <a href="{{ route($object.'.delete',['id'=>$post->id]) }}"><i class="bi bi-trash-fill fs-5  me-3"></i></a>
                                            <a href="{{ route($object.'.comment',['id'=>$post->id]) }}"><i class="bi bi-chat-left-dots-fill fs-5  text-primary"></i></a>
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