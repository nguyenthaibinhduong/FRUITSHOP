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
        <li class="breadcrumb-item">
            <a href="{{ route($object) }}">{{ ucfirst($object_title) }}</a>
        </li>
        <li class="breadcrumb-item breadcrumb-active" aria-current="page">Tạo mới</li>
    </ol>
@endsection

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route($object . '.store') }}" method="POST">
        @csrf
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="card-title">Tạo mới {{ $object_title }}</div>
                <a class="btn btn-secondary" href="{{ route($object) }}">Quay lại</a>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="name" class="form-label">Tên thuộc tính</label>
                    <input type="text" name="name" class="form-control" placeholder="VD: Màu sắc, Kích thước"
                        required>
                </div>

                <label class="form-label">Giá trị thuộc tính</label>
                <div id="attr-value-container">
                    <div class="attr-input-group input-group mb-2">
                        <input type="text" name="values[]" class="form-control attr-value-input"
                            placeholder="VD: Đỏ, Xanh, M, L" required>
                        <button type="button" class="btn btn-danger attr-remove-btn"><i
                                class="bi bi-x-circle"></i></button>
                    </div>
                </div>

                <button type="button" id="attr-add-value" class="btn btn-outline-primary mb-3">
                    <i class="bi bi-plus-circle"></i> Thêm giá trị
                </button>
            </div>
            <div class="card-footer text-end">
                <button class="btn btn-primary" type="submit"><i class="bi bi-check-circle"></i> Lưu</button>
            </div>
        </div>
    </form>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const addButton = document.getElementById('attr-add-value');
            const container = document.getElementById('attr-value-container');

            addButton.addEventListener('click', function() {
                const group = document.createElement('div');
                group.classList.add('attr-input-group', 'input-group', 'mb-2');
                group.innerHTML = `
                    <input type="text" name="values[]" class="form-control attr-value-input" placeholder="VD: Đỏ, Xanh, M, L" required>
                    <button type="button" class="btn btn-danger attr-remove-btn"><i class="bi bi-x-circle"></i></button>
                `;
                container.appendChild(group);
            });

            container.addEventListener('click', function(e) {
                if (e.target.closest('.attr-remove-btn')) {
                    e.target.closest('.attr-input-group').remove();
                }
            });
        });
    </script>
@endsection
