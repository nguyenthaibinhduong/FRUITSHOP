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

    <form action="{{ route($object . '.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="card-title">Tạo mới {{ $object_title }}</div>
                <a class="btn btn-secondary" href="{{ route($object) }}">Quay lại</a>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="name" class="form-label">Tên thuộc tính</label>
                    <input type="text" name="name" class="form-control" placeholder="VD: Màu sắc, Kích thước">
                </div>
                <div class="mb-3 ">
                    <label for="display_type" class="form-label">Kiểu hiển thị thuộc tính</label>
                    <select name="display_type" id="display_type" class="form-select">
                        <option value="text" selected>Văn bản</option>
                        <option value="color">Màu sắc</option>
                        <option value="image">Hình ảnh</option>
                    </select>
                </div>

                <label class="form-label">Giá trị thuộc tính</label>
                <div id="attr-value-container">
                    <div class="attr-input-group input-group mb-2">
                        <input type="text" name="values[]" class="form-control attr-value-input"
                            placeholder="Nhập giá trị...">
                        <input type="color" class="form-control form-control-color d-none attr-color-input"
                            name="colors[]">
                        <input type="file" accept="image/*" class="form-control d-none attr-image-input" name="images[]">
                        <input type="text" name="value_labels[]" class="form-control d-none attr-label-input"
                            placeholder="Tên hiển thị">
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
            const typeSelect = document.getElementById('display_type');

            function createInputGroup(displayType = 'text') {
                const group = document.createElement('div');
                group.classList.add('attr-input-group', 'input-group', 'mb-2');

                group.innerHTML = `
            <input type="text" name="values[]" class="form-control attr-value-input" placeholder="Nhập giá trị...">
            <input type="color" class="form-control form-control-color d-none attr-color-input" name="colors[]">
            <input type="file" accept="image/*" class="form-control d-none attr-image-input" name="images[]">
            <input type="text" name="value_labels[]" class="form-control d-none attr-label-input" placeholder="Tên hiển thị">
            <button type="button" class="btn btn-danger attr-remove-btn"><i class="bi bi-x-circle"></i></button>
        `;
                updateInputGroupByType(group, displayType);
                container.appendChild(group);
            }

            function updateInputGroupByType(group, type) {
                const textInput = group.querySelector('.attr-value-input');
                const colorInput = group.querySelector('.attr-color-input');
                const imageInput = group.querySelector('.attr-image-input');
                const labelInput = group.querySelector('.attr-label-input');

                textInput.classList.add('d-none');
                colorInput.classList.add('d-none');
                imageInput.classList.add('d-none');
                labelInput.classList.add('d-none');

                if (type === 'text') {
                    textInput.classList.remove('d-none');
                } else if (type === 'color') {
                    colorInput.classList.remove('d-none');
                    labelInput.classList.remove('d-none');
                } else if (type === 'image') {
                    imageInput.classList.remove('d-none');
                    labelInput.classList.remove('d-none');
                }
            }

            addButton.addEventListener('click', () => {
                const currentType = typeSelect.value;
                createInputGroup(currentType);
            });

            container.addEventListener('click', function(e) {
                if (e.target.closest('.attr-remove-btn')) {
                    e.target.closest('.attr-input-group').remove();
                }
            });

            typeSelect.addEventListener('change', () => {
                const selectedType = typeSelect.value;
                document.querySelectorAll('.attr-input-group').forEach(group => {
                    updateInputGroupByType(group, selectedType);
                });
            });

            // Gọi khi load lần đầu
            updateInputGroupByType(container.querySelector('.attr-input-group'), typeSelect.value);
        });
    </script>
@endsection
