@php
    $object='product';
    $object_title='sản phẩm';
    use Illuminate\Support\Collection;
@endphp
@extends('admin.layout.master')
@section('breadcrumb')
<ol class="breadcrumb d-md-flex d-none">
    <li class="breadcrumb-item">
        <i class="bi bi-house"></i>
        <a href="{{ route($object) }}">{{ ucfirst($object) }}</a>
    </li>
    <li class="breadcrumb-item breadcrumb-active" aria-current="page">Chỉnh sửa</li>
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
<form action="{{ route($object.'.update',['id'=>$product->id]) }}" enctype="multipart/form-data" method="post">
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
                                                <input value="{{ $product->name }}" name="name" type="text" class="form-control" placeholder="Nhập tên sản phẩm" autocomplete="off">
                                                @error('name')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-12">
                                            <div class="mb-3">
                                                <label class="form-label">Thương hiệu<span class="text-red">*</span></label>
                                                <select class="form-control" name="brand_id" id="">
                                                    @foreach($brands as $brand)
                                                        @if($product->brand_id== $brand->id)
                                                            <option selected value="{{ $brand->id }}">{{ $brand->name }}</option>
                                                        @else
                                                            <option  value="{{ $brand->id }}">{{ $brand->name }}</option>
                                                        @endif
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
                                                <input value="{{ $product->price }}" name="price" type="text" class="form-control" placeholder="Nhập giá sản phẩm 1000đ - 10.000.000đ" autocomplete="off">
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
                                                    <input value="{{ ($product->sale_percent==1)?'':((1-$product->sale_percent)*100) }}" value="0" type="text" name="sale_percent" class="form-control" placeholder="Nhập % giảm giá" autocomplete="off">
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
                                                  @foreach($categories as $category)
                                                    @if(in_array($category->id, $selected_categories))
                                                    <option selected value="{{ $category->id }}">{{ $category->name }}</option>
                                                    @else
                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                    @endif
                                                  @endforeach
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
                                                <input value="{{ $product->quantity }}" name="quantity" type="text" class="form-control" placeholder="Nhập số lượng tồn kho" autocomplete="off">
                                                @error('quantity')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                        </div> 
                                        <div class="col-sm-12 col-12">
                                            <div class="mb-3">
                                                <label class="form-label">Mô tả chung<span class="text-red">*</span></label>
                                                <textarea name="description" rows="4" class="form-control"
                                                    placeholder="Điền mô tả chung sản phẩm">{{ $product->description }}</textarea>
                                                    @error('description')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-12">
                                            <div class="mb-0">
                                                <label class="form-label">Mô tả chi tiết<span class="text-red">*</span></label>
                                                <textarea id="my-editor" name="longdescription" rows="4" class="form-control"
                                                    placeholder="Nhập mô tả chi tiết">{{ $product->longdescription }}</textarea>
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
                                    <div class="w-100 d-flex justify-content-between mt-3">
                                        @foreach($images as $image)
                                            @if($image->image_type==0)
                                            <img width="100px" height="100px" src="{{ asset($image->url) }}" alt="">
                                            @endif
                                        @endforeach
                                    </div>
                                    <br>
                                    
                                    <label for="thump">Ảnh mô tả</label>
                                    <select name="type_update" class="form-control-sm ms-3 mb-3">
                                        <option value="">Chọn chức năng thêm ảnh</option>
                                        <option value="add">Thêm tiếp ảnh</option>
                                        <option value="delete">Xóa hết</option>
                                        <option value="delete-add">Xóa hết rồi thêm</option>
                                        @php
                                            $iteration=1;
                                        @endphp
                                        @foreach($images as $image)
                                            @if($image->image_type==1)
                                            <option value="{{ $image->id }}">Xóa ảnh số {{ $iteration}}</option>
                                            @php
                                            $iteration++;
                                            @endphp
                                            @endif
                                        @endforeach
                                    </select>
                                    <input type="file" class="form-control" name="thump[]" multiple>
                                    @error('thump')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <div class="w-100 d-flex justify-content-start mt-3">
                                        @foreach($images as $image)
                                            @if($image->image_type==1)
                                            <img width="100px" height="100px" class="me-1" src="{{ asset($image->url) }}" alt="">
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-12">
                            <div class="custom-btn-group flex-end">
                                <button type="submit" class="btn btn-success">Lưu</button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

</form>

@endsection