@php
    $object = 'page';
    $object_title = 'Page';
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
                                    <th>Tiêu đề</th>
                                    <th>Slug</th>
                                    <th>Số Section</th>
                                    <th>Meta Title</th>
                                    <th>Meta Description</th>
                                    <th>Trạng thái</th>
                                    <th>Ngày tạo</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($pages as $page)
                                    <tr>
                                        <td>{{ $page->title }}</td>
                                        <td>{{ $page->slug }}</td>
                                        <td>{{ $page->sections->count() }}</td>
                                        <td>{{ Str::limit($page->meta_title, 30) }}</td>
                                        <td>{{ Str::limit($page->meta_description, 40) }}</td>
                                        <td>
                                            @if ($page->status)
                                                <span class="badge bg-success">Hiển thị</span>
                                            @else
                                                <span class="badge bg-secondary">Ẩn</span>
                                            @endif
                                        </td>
                                        <td>{{ $page->created_at ? $page->created_at->format('d/m/Y') : '' }}</td>
                                        <td>
                                            <div class="d-flex justify-content-end">
                                                <a href="{{ route($object . '.edit', ['id' => $page->id]) }}"
                                                    title="Sửa">
                                                    <i class="bi bi-pencil-square fs-5 me-3 text-warning"></i>
                                                </a>
                                                <a href="{{ route($object . '.delete', ['id' => $page->id]) }}"
                                                    title="Xóa"
                                                    onclick="return confirm('Bạn chắc chắn muốn xóa page này?')">
                                                    <i class="bi bi-trash-fill fs-5 text-danger"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted">Chưa có page nào.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        {{ $pages->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
