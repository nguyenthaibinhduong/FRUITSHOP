@extends('admin.layout.master')

@php
    $object = 'section';
    $object_title = 'section';
@endphp

@section('breadcrumb')
    <ol class="breadcrumb d-md-flex d-none">
        <li class="breadcrumb-item"><a href="{{ route('section.create') }}">Section</a></li>
        <li class="breadcrumb-item breadcrumb-active">Thêm</li>
    </ol>
@endsection

@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('section.store') }}">
        @csrf

        <div class="card-border mb-4 bg-white">
            <div class="card-border-title">Thông tin Section</div>
            <div class="card-border-body">
                <div class="mb-3">
                    <label class="form-label">Tên Section</label>
                    <input name="name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Slug</label>
                    <input name="slug" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Mô tả</label>
                    <textarea name="description" class="form-control" rows="3"></textarea>
                </div>
            </div>
        </div>

        <div class="card-border bg-white mb-4">
            <div class="card-border-title d-flex justify-content-between">
                <span>Danh sách Block</span>
                <button type="button" class="btn btn-sm btn-primary" onclick="addBlock()">+ Thêm Block</button>
            </div>
            <div class="card-border-body" id="blocks-wrapper">
                <!-- JS sẽ thêm các block ở đây -->
            </div>
        </div>

        <div class="text-end">
            <button type="submit" class="btn btn-success">Lưu Section</button>
        </div>
    </form>
    <script>
        let blockIndex = 0;

        function addBlock() {
            const wrapper = document.getElementById('blocks-wrapper');
            const html = `
            <div class="card p-4 mb-3 border position-relative ">
                <button type="button" class="btn-close position-absolute top-0 end-0" onclick="this.parentElement.remove()"></button>
                <div class="mb-2">
                    <label>Tiêu đề Block</label>
                    <input type="text" name="blocks[${blockIndex}][title]" class="form-control" required>
                </div>
                <div class="mb-2">
                    <label>Loại Block</label>
                    <select name="blocks[${blockIndex}][type]" class="form-select" required>
                        <option value="text">Text</option>
                        <option value="image">Image</option>
                        <option value="video">Video</option>
                        <option value="html">HTML</option>
                    </select>
                </div>
                <div class="mb-2">
                    <label>Nội dung</label>
                    <textarea name="blocks[${blockIndex}][content]" class="form-control" rows="3"></textarea>
                </div>
            </div>
        `;
            wrapper.insertAdjacentHTML('beforeend', html);
            blockIndex++;
        }
    </script>
@endsection
