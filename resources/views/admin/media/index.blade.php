@php
    $object = 'media';
    $object_title = 'Đa phương tiện';
@endphp
@extends('admin.layout.master')
@section('breadcrumb')
    <ol class="breadcrumb d-md-flex d-none">
        <li class="breadcrumb-item">
            <i class="bi bi-house"></i>
            <a href="index.html">Đa phương tiện</a>
        </li>
        <li class="breadcrumb-item breadcrumb-active" aria-current="page">Quản lý {{ $object_title }}</li>
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
                    <div class="folder-current">
                        <ol class="breadcrumb d-md-flex d-none ">
                            <li class="breadcrumb-item">

                                <a href="javascript:void(0)" class="folder-link"
                                    data-path="{{ $folder }}">{{ $folder }}</a>
                            </li>

                        </ol>
                    </div>
                    <a class="btn btn-info" href=""><i class="bi bi-plus-square"></i>
                        Thêm</a>
                </div>
                <div class="card-body">
                    <div class="row row-cols-1 row-cols-md-6 g-2">

                        {{-- Hiển thị Folder --}}
                        @foreach ($folders as $folder)
                            <div class="col">
                                <div class="h-25 text-center">
                                    <a href="javascript:void(0)" class="text-decoration-none folder-link"
                                        data-path="{{ $folder['path'] }}">
                                        <div class="card-body">
                                            <img src="/img/folder-img.svg" class="img img-fluid" alt="">
                                            <p class="mt-2 fw-bold text-dark">{{ basename($folder['path']) }}</p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        @endforeach


                        {{-- Hiển thị File sau --}}
                        @foreach ($files as $file)
                            <div class="col">
                                <div class="h-25">
                                    <img src="{{ $file['secure_url'] }}" class="card-img-top"
                                        style="object-fit: cover; height: 200px;" alt="Ảnh">
                                    <div class="card-body text-center">
                                        <p class="mb-1">{{ $file['display_name'] ?? basename($file['public_id']) }}</p>
                                        <small class="text-muted">{{ $file['format'] }} •
                                            {{ round($file['bytes'] / 1024, 1) }} KB</small>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>


                </div>
            </div>

        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Gắn sự kiện click cho tất cả các folder link sau này
            document.addEventListener('click', function(event) {
                const folderLink = event.target.closest('.folder-link');

                if (folderLink) {
                    document.getElementById('loading-wrapper').style.display = 'flex';
                    document.getElementById('loading-wrapper').style.background = 'transparent';
                    const path = folderLink.getAttribute('data-path');
                    fetch(`/api/media-api/${path}`)
                        .then(response => {
                            return response.json();
                        })
                        .then(data => {
                            renderMedia(data.folders, data.files);
                            renderBreadcrumb(data.folder)
                        })
                        .catch(error => {
                            console.error('Lỗi tải thư mục:', error);
                        }).finally(() => {
                            // Ẩn loading sau khi xử lý xong
                            document.getElementById('loading-wrapper').style.display = 'none';
                        });
                }
            });

            // Hàm render dữ liệu
            function renderMedia(folders, files) {
                const container = document.querySelector('.card-body .row');
                if (!container) return;
                container.innerHTML = ''; // Clear nội dung cũ

                // Render folders
                folders.forEach(folder => {
                    const div = document.createElement('div');
                    div.className = 'col';
                    div.innerHTML = `
                    <div class="h-25 text-center">
                        <a href="javascript:void(0)" class="text-decoration-none folder-link" data-path="${folder.path}">
                            <div class="card-body">
                                <img src="/img/folder-img.svg" class="img img-fluid" alt="">
                                <p class="mt-2 fw-bold text-dark">${folder.name ?? folder.path.split('/').pop()}</p>
                            </div>
                        </a>
                    </div>
                `;
                    container.appendChild(div);
                });

                // Render files
                files.forEach(file => {
                    const div = document.createElement('div');
                    div.className = 'col';
                    div.innerHTML = `
                    <div class="h-25">
                        <img src="${file.secure_url}" class="card-img-top" style="object-fit: cover; height: 200px;" alt="Ảnh">
                        <div class="card-body text-center">
                            <p class="mb-1">${file.display_name ?? file.public_id}</p>
                            <small class="text-muted">${file.format} • ${Math.round(file.bytes / 1024)} KB</small>
                        </div>
                    </div>
                `;
                    container.appendChild(div);
                });

            }

            function renderBreadcrumb(folder) {
                const breadcrumbEl = document.querySelector('.folder-current');
                breadcrumbEl.innerHTML = ''; // Xóa nội dung cũ

                const ol = document.createElement('ol');
                ol.className = 'breadcrumb d-md-flex d-none';

                const parts = folder.replace(/\\/g, '').split('/');
                let accumulatedPath = '';

                parts.forEach((part, index) => {
                    accumulatedPath += (index > 0 ? '/' : '') + part;

                    const li = document.createElement('li');
                    li.className = 'breadcrumb-item';

                    // Phần tử cuối cùng là breadcrumb-active
                    if (index === parts.length - 1) {
                        li.className += ' breadcrumb-active';
                        li.setAttribute('aria-current', 'page');
                        li.textContent = part; // Hiển thị path đầy đủ
                    } else {
                        const a = document.createElement('a');
                        a.href = 'javascript:void(0)';
                        a.className = 'folder-link';
                        a.setAttribute('data-path', accumulatedPath);
                        a.textContent = part;
                        li.appendChild(a);
                    }

                    ol.appendChild(li);
                });

                breadcrumbEl.appendChild(ol);
            }

        });
    </script>
@endsection
