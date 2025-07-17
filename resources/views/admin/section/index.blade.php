@php
    $object = 'section';
    $object_title = 'Section';
    use Carbon\Carbon;
@endphp

@extends('admin.layout.master')

@section('breadcrumb')
    <ol class="breadcrumb d-md-flex d-none">
        <li class="breadcrumb-item">
            <i class="bi bi-house"></i>
            <a href="#">Trang chủ</a>
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
                    <a class="btn btn-info" href="{{ route($object . '.create') }}">
                        <i class="bi bi-plus-square"></i> Thêm
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table v-middle table-striped">
                            <thead>
                                <tr>
                                    <th>Tên Section</th>
                                    <th>Slug</th>
                                    <th>Số Block</th>
                                    <th>Mô tả</th>
                                    <th>Ngày tạo</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($sections as $section)
                                    <tr>
                                        <td>{{ $section->name }}</td>
                                        <td>{{ $section->slug }}</td>
                                        <td>{{ $section->blocks->count() }}</td>
                                        <td>{{ Str::limit($section->description, 40) }}</td>
                                        <td>{{ $section->created_at ? $section->created_at->format('d/m/Y') : '' }}</td>
                                        <td>
                                            <div class="d-flex justify-content-end">
                                                <a href="{{ route($object . '.edit', ['id' => $section->id]) }}"
                                                    title="Sửa">
                                                    <i class="bi bi-pencil-square fs-5 me-3 text-warning"></i>
                                                </a>
                                                <a href="{{ route($object . '.delete', ['id' => $section->id]) }}"
                                                    title="Xóa"
                                                    onclick="return confirm('Bạn chắc chắn muốn xóa section này?')">
                                                    <i class="bi bi-trash-fill fs-5 me-3 text-danger"></i>
                                                </a>
                                                {{-- <a href="{{ route($object . '.block', ['id' => $section->id]) }}"
                                                    title="Xem Block">
                                                    <i class="bi bi-box-seam fs-5 text-primary"></i>
                                                </a> --}}
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted">Chưa có section nào.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        {{-- Pagination nếu cần --}}
                        {{ $sections->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
