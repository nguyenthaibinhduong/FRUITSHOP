@extends('admin.layout.master')

@php
    $object = 'section';
    $object_title = 'section';
@endphp

@section('breadcrumb')
    <ol class="breadcrumb d-md-flex d-none">
        <li class="breadcrumb-item"><a href="{{ route('section') }}">Section</a></li>
        <li class="breadcrumb-item breadcrumb-active">Chỉnh sửa</li>
    </ol>
@endsection

@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('section.update', $section->id) }}">
        @csrf
        @method('PUT')

        <div class="card-border mb-4 bg-white">
            <div class="card-border-title">Thông tin Section</div>
            <div class="card-border-body">
                <div class="mb-3">
                    <label class="form-label">Tên Section</label>
                    <input name="name" class="form-control" value="{{ $section->name }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Slug</label>
                    <input name="slug" class="form-control" value="{{ $section->slug }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Mô tả</label>
                    <textarea name="description" class="form-control" rows="3">{{ $section->description }}</textarea>
                </div>
            </div>
        </div>

        <div class="card-border mb-4">
            <div class="card-border-title d-flex justify-content-between">
                <span>Danh sách Block</span>
                <button type="button" class="btn btn-sm btn-primary" onclick="addBlock()">+ Thêm Block</button>
            </div>
            <div class="card-border-body" id="blocks-wrapper">
                @foreach ($section->blocks as $index => $block)
                    @php $blockIndex = $index; @endphp
                    <script>
                        let blockIndex = {{ $blockIndex + 1 }};
                    </script>
                    @include('admin.section.form-block', ['block' => $block, 'index' => $blockIndex])
                @endforeach
            </div>
        </div>

        <div class="text-end">
            <button type="submit" class="btn btn-success">Cập nhật Section</button>
        </div>
    </form>

    <script>
        function addBlock() {
            const wrapper = document.getElementById('blocks-wrapper');
            const html = `@include('admin.section.form-block')`;
            wrapper.insertAdjacentHTML('beforeend', html.replaceAll('__INDEX__', blockIndex));
            blockIndex++;
        }

        function toggleCustom(index, selectEl) {
            const customForm = document.getElementById(`block-${index}-custom`);
            const hiddenInput = document.getElementById(`block-${index}-position-id`);
            if (selectEl.value === 'custom') {
                customForm.classList.remove('d-none');
                hiddenInput.value = '';
            } else {
                customForm.classList.add('d-none');
                hiddenInput.value = selectEl.value;
            }
        }
    </script>
@endsection
