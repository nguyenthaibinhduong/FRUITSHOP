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
    <li class="breadcrumb-item breadcrumb-active" aria-current="page">{{ ucfirst($object_title) }}</li>
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
                <div class="card-title">Danh sách {{  $object_title }} </div>
            </div>
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table v-middle">
                        <thead>
                            <tr>
                                <th>Tiêu đề {{ $object_title }}</th>
                                <th>Loại </th>
                                <th>Email gửi</th>
                                <th>Email nhận</th>
                                <th>Thời gian nhận/gửi </th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($mails as $mail)
                                <tr>
                                    <td>{{ $mail->subject }}</td>
                                    <td>{!! ($mail->type==1)?'<span class="text-success">Nhận</span>':'<span class="text-warning">Gửi</span>' !!}</td>
                                    <td>{{ $mail->sender_email }}</td>
                                    <td>{{ $mail->recipient_email }}</td>
                                    <td>{{ $mail->created_at->format('d/m/Y h:i:s A') }}</td>
                                    <td>
                                        <div class="d-flex justify-content-end">
                                            <a href="{{ route($object.'.detail',['id'=>$mail->id]) }}"><i class="bi bi-envelope fs-5 me-3 text-warning"></i></a>
                                            <a href="{{ route($object.'.delete',['id'=>$mail->id]) }}"><i class="bi bi-trash-fill  fs-5"></i></a>
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