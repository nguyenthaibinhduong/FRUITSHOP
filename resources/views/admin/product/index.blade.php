@php
    $object = 'product';
    $object_title = 'sản phẩm';
@endphp
@extends('admin.layout.master')
@section('breadcrumb')
    <ol class="breadcrumb d-md-flex d-none">
        <li class="breadcrumb-item">
            <i class="bi bi-house"></i>
            <a href="index.html">Sản phẩm</a>
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
                    <div class="card-title">Danh sách {{ $object_title }} </div>
                    <a class="btn btn-info" href="{{ route($object . '.create') }}"><i class="bi bi-plus-square"></i>
                        Thêm</a>
                </div>
                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table v-middle">
                            <thead>
                                <tr>
                                    <th>Ảnh</th>
                                    <th>Tên {{ $object_title }}</th>
                                    <th>Danh mục</th>
                                    <th>Thương hiệu</th>
                                    <th>Giá gốc</th>
                                    <th>Giá giảm</th>
                                    {{-- <th>Mô tả</th> --}}
                                    <th>Số lượng</th>
                                    <th>Trạng thái</th>
                                    <th></th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                    @if (!$product->has_variants)
                                        <tr>
                                            <td>
                                                @foreach ($images as $image)
                                                    @if ($image->product_id == $product->id)
                                                        <img width="50px" height="50px" src="{{ asset($image->url) }}"
                                                            alt="">
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>{{ $product->name ?? 'Không có tên' }}</td>
                                            <td>
                                                @foreach ($selected_categories->where('product_id', $product->id) as $selected_category)
                                                    {{ $categories->firstWhere('id', $selected_category->category_id)->name ?? '' }}<br>
                                                @endforeach
                                            </td>
                                            <td>{{ $product->brand->name ?? '' }}</td>
                                            <td>{{ number_format($product->price ?? 0) }}₫</td>
                                            <td>{{ number_format((($product->price ?? 0) * ($product->sale_percent ?? 0)) / 100) }}₫
                                            </td>
                                            {{-- <td>{{ $product->description ?? '' }}</td> --}}
                                            <td>{{ $product->quantity ?? 0 }}</td>
                                            <td>{{ $product->uploaded ? 'Đã đăng' : 'Chưa đăng' }}</td>
                                            <td>
                                                <div class="d-flex justify-content-end">
                                                    <a href="{{ route($object . '.edit', ['id' => $product->id]) }}"><i
                                                            class="bi bi-pencil-square fs-5 me-3 text-warning"></i></a>
                                                    <a href="{{ route($object . '.delete', ['id' => $product->id]) }}"><i
                                                            class="bi bi-trash-fill me-3 fs-5"></i></a>
                                                    <a href="{{ route($object . '.comment', ['id' => $product->id]) }}"><i
                                                            class="bi bi-chat-left-dots-fill fs-5 text-primary"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    @else
                                        @foreach ($product->variants as $i => $variant)
                                            <tr>
                                                @if ($i === 0)
                                                    <td rowspan="{{ $product->variants->count() }}">
                                                        @foreach ($images as $image)
                                                            @if ($image->product_id == $product->id)
                                                                <img width="50px" height="50px"
                                                                    src="{{ asset($image->url) }}" alt="">
                                                            @endif
                                                        @endforeach
                                                    </td>
                                                    <td rowspan="{{ $product->variants->count() }}">
                                                        {{ $product->name ?? 'Không có tên' }}</td>
                                                    <td rowspan="{{ $product->variants->count() }}">
                                                        @foreach ($selected_categories->where('product_id', $product->id) as $selected_category)
                                                            {{ $categories->firstWhere('id', $selected_category->category_id)->name ?? '' }}<br>
                                                        @endforeach
                                                    </td>
                                                    <td rowspan="{{ $product->variants->count() }}">
                                                        {{ $product->brand->name ?? '' }}</td>
                                                    <td>{{ number_format($variant->price ?? 0) }}₫</td>
                                                    <td>{{ number_format((($variant->price ?? 0) * ($variant->sale_percent ?? 0)) / 100) }}₫
                                                    </td>
                                                    {{-- <td rowspan="{{ $product->variants->count() }}">
                                                        {{ $product->description ?? '' }}</td> --}}
                                                    <td>{{ $variant->stock ?? 0 }}</td>
                                                    <td>{{ $variant->uploaded ? 'Đã đăng' : 'Chưa đăng' }}</td>
                                                    <td rowspan="{{ $product->variants->count() }}">
                                                        <div class="d-flex justify-content-end">
                                                            <a
                                                                href="{{ route($object . '.edit', ['id' => $product->id]) }}"><i
                                                                    class="bi bi-pencil-square fs-5 me-3 text-warning"></i></a>
                                                            <a
                                                                href="{{ route($object . '.delete', ['id' => $product->id]) }}"><i
                                                                    class="bi bi-trash-fill me-3 fs-5"></i></a>
                                                            <a
                                                                href="{{ route($object . '.comment', ['id' => $product->id]) }}"><i
                                                                    class="bi bi-chat-left-dots-fill fs-5 text-primary"></i></a>
                                                        </div>
                                                    </td>
                                                @else
                                                    <td>{{ number_format($variant->price ?? 0) }}₫</td>
                                                    <td>{{ number_format((($variant->price ?? 0) * ($variant->sale_percent ?? 0)) / 100) }}₫
                                                    </td>
                                                    <td>{{ $variant->stock ?? 0 }}</td>
                                                    <td>{{ $variant->uploaded ? 'Đã đăng' : 'Chưa đăng' }}</td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    @endif
                                @endforeach
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-center w-100">
                @if (count($products) >= 5)
                    {{ $products->links() }}
                @endif
            </div>
        </div>
    </div>
@endsection
