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
    <li class="breadcrumb-item breadcrumb-active" aria-current="page"> Chi tiết {{ ucfirst($object_title) }}</li>
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
        <div class="card-body ">
            <h6 class="m-0 font-weight-bold text-primary">Thông tin chi tiết Mail</h6><br>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <tbody>
                        <tr>
                            <td>Từ Email</td>
                            <td>{{ $mail->sender_email }}</td>
                        </tr>
                        <tr>
                            <td>Đến Email</td>
                            <td>{{ $mail->recipient_email }}</td>
                        </tr>
                        <tr>
                            <td>Thời gian</td>
                            <td>{{ $mail->created_at->format('d/m/Y h:i:s A') }}</td>
                        </tr>
                        <tr>
                            <td>Tiêu đề</td>
                            <td>{{ $mail->subject }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-body">
            <h6 class="m-0 font-weight-bold text-primary">Nội dung Mail</h6><br>
        </div>
        <div class="card-body bg-white p-3">
            
            {!! $mail->body !!}
        </div>
    </div>
</div>
@endsection