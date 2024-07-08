@php
   $object='mail';
   $object_title='mail';
   use Carbon\Carbon;
@endphp
@extends('admin.layout.master')
@section('breadcrumb')
<ol class="breadcrumb d-md-flex d-none">
    <li class="breadcrumb-item">
        <i class="bi bi-house"></i>
        <a href="index.html">Mail</a>
    </li>
    <li class="breadcrumb-item breadcrumb-active" aria-current="page">Soạn {{ ucfirst($object_title) }}</li>
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
    <form action="{{ route($object.'.send') }}" method="post">
        @csrf
    <div class="col-12">
        <div class="card-body ">
            <h6 class="m-0 font-weight-bold text-primary">Thông tin chi tiết Mail</h6><br>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <tbody>
                        <tr>
                            <td>Đến Email</td>
                            <td><input class="form-control border-0" type="text" name="recipient_email" autocomplete="off"></td>
                        </tr>
                        <tr>
                            <td>Tiêu đề</td>
                            <td><input class="form-control border-0" type="text" name="subject" autocomplete="off"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
        </div>
        <div class="card-body">
            <h6 class="m-0 font-weight-bold text-primary">Nội dung Mail</h6><br>
        </div>
        <div class="card-body bg-white p-3">
            
            <textarea id="my-editor" class="form-control" name="body" cols="30" rows="10"></textarea>
        </div>
        <div class="card-body">
            <button type="submit"  class="btn btn-warning">Gửi Mail</button>
        </div>
    </div>
    </form>
</div>
@endsection