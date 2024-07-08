@php
   $object='product';
   $object_title='sản phẩm';
@endphp
@extends('admin.layout.master')
@section('breadcrumb')
<ol class="breadcrumb d-md-flex d-none">
    <li class="breadcrumb-item">
        <i class="bi bi-house"></i>
        <a href="{{ route($object) }}">{{ ucfirst($object) }}</a>
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
<form action="{{ route($object.'.store') }}" enctype="multipart/form-data" method="post">
    @csrf
    <div class="row">
        <div class="col-sm-12 col-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Thông tin sản phẩm</div>
                </div>
                <div class="card-body">

                    <div class="row">
                        <div class="col-sm-12 col-12">
                            <div class="card-border">
                                <div class="card-border-title">Thông tin</div>
                                <div class="card-border-body">

                                    <div class="row">
                                        <div class="col-sm-12 col-12">
                                            <div class="mb-3">
                                                <label class="form-label">Tên sản phẩm<span class="text-red">*</span></label>
                                                <input name="name" type="text" class="form-control" placeholder="Nhập tên sản phẩm" autocomplete="off">
                                                @error('name')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-12">
                                            <div class="mb-3">
                                                <label class="form-label">Thương hiệu<span class="text-red">*</span></label>
                                                <select class="form-control" name="brand_id" id="">
                                                    <option value="">Chọn thương hiệu</option>
                                                    @foreach($brands as $brand)
                                                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('brand_id')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-12">
                                            <div class="mb-3">
                                                <label class="form-label">Giá sản phẩm<span class="text-red">*</span></label>
                                                <div class="input-group">
                                                <input name="price" type="text" class="form-control" placeholder="Nhập giá sản phẩm 1000đ - 10.000.000đ" autocomplete="off">
                                                <span class="input-group-text">đ</span>
                                                </div>
                                                @error('price')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror                                            
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-12">
                                            <div class=" mb-3">
                                                <label class="form-label">Mức giảm giá</label>
                                                <div class="input-group">
                                                    <input value="0" type="text" name="sale_percent" class="form-control" placeholder="Nhập % giảm giá" autocomplete="off">
                                                    <span class="input-group-text">%</span>
                                                </div>
                                                @error('sale_percent')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-12">
                                            <div class="mb-0">
                                                <label class="form-label">Danh mục<span class="text-red">*</span></label>
                                                <select class="form-control" name="category_id[]" id="" multiple>
                                                    {!! $option !!}
                                                </select>
                                                @error('category_id')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-12">
                            <div class="card-border">
                                <div class="card-border-title">Đặc tính</div>
                                <div class="card-border-body">

                                    <div class="row">
                                       
                                        <div class="col-sm-12 col-12">
                                            <div class="mb-3">
                                                <label class="form-label">Trạng thái<span class="text-red">*</span></label>
                                                <select class="form-control" name="uploaded" id="">
                                                    <option value="1">Đăng ngay</option>
                                                    <option value="0">Chưa đăng</option>
                                                </select>
                                                @error('uploaded')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-12">
                                            <div class="mb-3">
                                                <label class="form-label">Số lượng tồn kho<span class="text-red">*</span></label>
                                                <input name="quantity" type="text" class="form-control" placeholder="Nhập số lượng tồn kho" autocomplete="off">
                                                @error('quantity')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                        </div> 
                                        <div class="col-sm-12 col-12">
                                            <div class="mb-3">
                                                <label class="form-label">Mô tả chung<span class="text-red">*</span></label>
                                                <textarea name="description" rows="4" class="form-control"
                                                    placeholder="Điền mô tả chung sản phẩm"></textarea>
                                                    @error('description')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-12">
                                            <div class="mb-0">
                                                <label class="form-label">Mô tả chi tiết<span class="text-red">*</span></label>
                                                <textarea id="my-editor" name="longdescription" rows="4" class="form-control"
                                                    placeholder="Nhập mô tả chi tiết"></textarea>
                                                    @error('longdescription')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-12">
                            <div class="card-border">
                                <div class="card-border-title">Hình ảnh</div>
                                <div class="card-border-body">
                                    <label for="image">Ảnh sản phẩm</label>
                                    <input type="file" class="form-control" name="image">
                                    @error('image')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <br>
                                    <label for="thump">Ảnh mô tả</label>
                                    <input type="file" class="form-control" name="thump[]" multiple>
                                    @error('thump')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-12">
                            <div class="custom-btn-group flex-end">
                                <button type="submit" class="btn btn-success">Thêm</button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

</form>

@endsection