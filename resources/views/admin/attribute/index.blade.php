@php
    $object = 'attribute';
    $object_title = 'thuộc tính sản phẩm';
@endphp

@extends('admin.layout.master')

@section('breadcrumb')
    <ol class="breadcrumb d-md-flex d-none">
        <li class="breadcrumb-item">
            <i class="bi bi-house"></i>
            <a href="{{ route('admin') }}">Trang chủ</a>
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
                <div class="card-header d-flex justify-content-between">
                    <div class="card-title">Danh sách {{ $object_title }}</div>
                    <a class="btn btn-info" href="{{ route($object . '.create') }}"><i class="bi bi-plus-square"></i>
                        Thêm</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table v-middle">
                            <thead>
                                <tr>
                                    <th>Tên thuộc tính</th>
                                    <th>Giá trị</th>
                                    <th class="text-end">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($attributes as $attribute)
                                    <tr>
                                        <td>{{ $attribute->name }}</td>
                                        <td>
                                            @foreach ($attribute->values as $value)
                                                @if ($attribute->display_type === 'color')
                                                    <span class="badge me-1"
                                                        style="background-color: {{ $value->value }}; color: #fff;">
                                                        {{ $value->label ?? $value->value }}
                                                    </span>
                                                @elseif ($attribute->display_type === 'image')
                                                    <span class="me-1">
                                                        <img src="{{ asset($value->value) }}" alt="{{ $value->label }}"
                                                            style="width: 30px; height: 30px; object-fit: cover; border-radius: 4px;">
                                                        <small>{{ $value->label }}</small>
                                                    </span>
                                                @else
                                                    <span class="badge bg-secondary me-1">
                                                        {{ $value->value }}
                                                    </span>
                                                @endif
                                            @endforeach
                                        </td>
                                        <td class="text-end">
                                            <div class="d-flex justify-content-end">
                                                <a href="{{ route($object . '.edit', ['id' => $attribute->id]) }}"><i
                                                        class="bi bi-pencil-square fs-5 me-3 text-warning"></i></a>
                                                <a href="{{ route($object . '.delete', ['id' => $attribute->id]) }}"><i
                                                        class="bi bi-trash-fill fs-5"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                @if ($attributes->isEmpty())
                                    <tr>
                                        <td colspan="3" class="text-center text-muted">Chưa có thuộc tính nào.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
