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
        <li class="breadcrumb-item breadcrumb-active" aria-current="page">Chỉnh sửa</li>
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

    <form action="{{ route($object . '.update', $attribute->id) }}" method="POST" id="attribute-form">
        @csrf
        @method('PUT')
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="card-title">Chỉnh sửa {{ $object_title }}</div>
                <a class="btn btn-secondary" href="{{ route($object) }}">Quay lại</a>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="name" class="form-label">Tên thuộc tính</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $attribute->name) }}"
                        required>
                </div>

                <label class="form-label">Giá trị thuộc tính</label>
                <div id="value-container">
                    @foreach ($attribute->values as $value)
                        <div class="input-group mb-2 value-group">
                            <input type="text" name="values[]" class="form-control" value="{{ $value->value }}" required>
                            <button type="button" class="btn btn-danger remove-btn" title="Xoá"><i
                                    class="bi bi-x-circle"></i></button>
                        </div>
                    @endforeach
                    @if ($attribute->values->isEmpty())
                        <div class="input-group mb-2 value-group">
                            <input type="text" name="values[]" class="form-control" placeholder="VD: M, L, XL" required>
                            <button type="button" class="btn btn-danger remove-btn"><i class="bi bi-x-circle"></i></button>
                        </div>
                    @endif
                </div>

                <button type="button" id="add-value" class="btn btn-outline-primary mb-3">
                    <i class="bi bi-plus-circle"></i> Thêm giá trị
                </button>
            </div>
            <div class="card-footer text-end">
                <button class="btn btn-primary" type="submit"><i class="bi bi-check-circle"></i> Cập nhật</button>
            </div>
        </div>
    </form>
@endsection

@section('scripts')
    <script>
        document.getElementById('add-value').addEventListener('click', function() {
            const container = document.getElementById('value-container');
            const group = document.createElement('div');
            group.classList.add('input-group', 'mb-2', 'value-group');
            group.innerHTML = `
            <input type="text" name="values[]" class="form-control" placeholder="VD: Mới" required>
            <button type="button" class="btn btn-danger remove-btn"><i class="bi bi-x-circle"></i></button>
        `;
            container.appendChild(group);
        });

        document.addEventListener('click', function(e) {
            if (e.target.closest('.remove-btn')) {
                const group = e.target.closest('.value-group');
                if (document.querySelectorAll('.value-group').length > 1) {
                    group.remove();
                } else {
                    alert('Phải có ít nhất một giá trị.');
                }
            }
        });

        // Optional client-side validation
        document.getElementById('attribute-form').addEventListener('submit', function(e) {
            const inputs = document.querySelectorAll('input[name="values[]"]');
            let valid = true;
            inputs.forEach(input => {
                if (input.value.trim() === '') {
                    input.classList.add('is-invalid');
                    valid = false;
                } else {
                    input.classList.remove('is-invalid');
                }
            });
            if (!valid) {
                e.preventDefault();
                alert('Vui lòng nhập đầy đủ giá trị thuộc tính!');
            }
        });
    </script>
@endsection
