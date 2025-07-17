@php
    $object = 'page';
    $object_title = 'trang';
@endphp

@extends('admin.layout.master')

@section('breadcrumb')
    <ol class="breadcrumb d-md-flex d-none">
        <li class="breadcrumb-item">
            <i class="bi bi-house"></i>
            <a href="{{ route($object) }}">{{ ucfirst($object_title) }}</a>
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

    <form method="POST" action="{{ route($object . '.store') }}">
        @csrf

        <div class="col-sm-12 col-12">
            <div class="card-border bg-white">
                <div class="card-border-title px-2">Thêm {{ $object_title }}</div>
                <div class="card-border-body px-2">
                    <div class="row">
                        <div class="col-sm-6 col-12">
                            <div class="mb-3">
                                <label class="form-label">Tiêu đề {{ $object_title }} <span
                                        class="text-red">*</span></label>
                                <input name="title" type="text" class="form-control" placeholder="Nhập tiêu đề"
                                    required>
                                @error('title')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-6 col-12">
                            <div class="mb-3">
                                <label class="form-label">Slug <span class="text-red">*</span></label>
                                <input name="slug" type="text" class="form-control" placeholder="Nhập slug">
                                @error('slug')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-12 col-12">
                            <div class="mb-3">
                                <label class="form-label">Meta Title</label>
                                <input type="text" name="meta_title" class="form-control" placeholder="Nhập meta title">
                                @error('meta_title')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-12 col-12">
                            <div class="mb-3">
                                <label class="form-label">Meta Description</label>
                                <textarea name="meta_description" class="form-control" rows="3" placeholder="Nhập meta description"></textarea>
                                @error('meta_description')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-12 col-12">
                            <div class="mb-3">
                                <label class="form-label">Gắn Sections</label>
                                <select name="sections[]" class="form-select" multiple>
                                    @foreach ($sections as $section)
                                        <option value="{{ $section->id }}">[ section id = {{ $section->name }}]</option>
                                    @endforeach
                                </select>
                                @error('sections')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>

                    </div> <!-- /.row -->
                </div> <!-- /.card-body -->
            </div> <!-- /.card-border -->
        </div> <!-- /.col -->

        <div class="col-sm-12 col-12 mt-3">
            <div class="custom-btn-group flex-end">
                <button type="submit" class="btn btn-success">Thêm {{ $object_title }}</button>
            </div>
        </div>
    </form>
@endsection
