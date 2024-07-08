@php
    $object='comment';
    $object_title='bình luận';
    use Carbon\Carbon;
@endphp
@extends('admin.layout.master')
@section('breadcrumb')
<ol class="breadcrumb d-md-flex d-none">
    <li class="breadcrumb-item">
        <i class="bi bi-house"></i>
        <a href="index.html">Bài viết</a>
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
                <div class="card-title">{{  ucfirst($object_title) }} gần đây</div>
            </div>
            
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table v-middle">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Người bình luận</th>
                                <th>Nội dung</th>
                                <th>Ngày cập nhật</th>
                                <th></th>
                               
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($comments as $comment)
                               <tr>
                                    <td><img src="{{ asset($comment->user->image_url) }}" width="40px" height="40px" alt=""></td>
                                    <td>{{ $comment->user->name }}</td>
                                    <td style="max-width:200px;">{{ $comment->body }}</td>
                                    <td>{{ $comment->updated_at->toDateTimeString() }}</td>
                                    <td>
                                        <div class="d-flex justify-content-end">
                                            <a href="{{ route($object.'.delete',['id'=>$comment->id]) }}"><i class="bi bi-trash-fill me-3 fs-5"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-center w-100">
            @if(count($comments)>=5)
            {{ $comments->links() }}
            @endif
        </div>
    </div>
</div>
@endsection