@php
    $object='product';
    $object_title='sản phẩm';
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
                <div class="card-title">Danh sách {{  $object_title }} </div>
                <a class="btn btn-info" href="{{ route($object.'.create') }}"><i class="bi bi-plus-square"></i> Thêm</a>
            </div>
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table v-middle">
                        <thead>
                            <tr>
                                <th>Ảnh</th>
                                <th>Tên {{ $object_title }}</th>
                                <th>Giá gốc</th>
                                <th>Giá giảm</th>
                                <th>Mô tả</th>
                                <th>Số lượng</th>
                                <th>Danh mục</th>
                                <th>Thương hiệu</th>
                                <th>Trạng thái</th>
                                <th></th>
                               
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    @foreach($images as $image)
                                        @if($image->product_id == $product->id)
                                        <td>
                                            <img width="50px" height="50px" src="{{ asset($image->url) }}" alt="">
                                        </td>
                                        @endif
                                    @endforeach
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->price }}</td>
                                    <td>{{ $product->price*$product->sale_percent }}</td>
                                    <td>{{ $product->description }}</td>
                                    <td>{{ $product->quantity }}</td>
                                    <td>
                                        @foreach($selected_categories as $selected_category)
                                            @if($selected_category->product_id==$product->id)
                                                @foreach($categories as $category)
                                                    @if($category->id == $selected_category->category_id)
                                                        <i class="me-1 ms-1">{{ $category->name }}</i>
                                                    @endif
                                                @endforeach
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        {{ $product->brand->name }}
                                    </td>
                                    <td>
                                        {{ ($product->uploaded==1)?'Đã đăng':'Chưa đăng' }}
                                    </td>
                                    
                                    <td>
                                        <div class="d-flex justify-content-end">
                                            <a href="{{ route($object.'.edit',['id'=>$product->id]) }}"><i class="bi bi-pencil-square fs-5 me-3 text-warning"></i></a>
                                            <a href="{{ route($object.'.delete',['id'=>$product->id]) }}"><i class="bi bi-trash-fill me-3 fs-5"></i></a>
                                            <a href="{{ route($object.'.comment',['id'=>$product->id]) }}"><i class="bi bi-chat-left-dots-fill fs-5  text-primary"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-center w-100">
            @if(count($products)>=5)
            {{ $products->links() }}
            @endif
        </div>
    </div>
</div>
@endsection