@extends('client.layout.master_layout')
@section('content')
        <!-- Breadcrumb Section Begin -->
        <section class="breadcrumb-section set-bg" data-setbg="{{ asset('client/img/breadcrumb.jpg') }}">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <div class="breadcrumb__text">
                            <h2>User Information</h2>
                            <div class="breadcrumb__option">
                                <a href="{{ route('information') }}">User Info</a>
                                <span>Edit Information</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Breadcrumb Section End -->
    
        <!-- Product Section Begin -->
        <section class="product spad">
            <div class="container">
                <div class="row">
                    @include('client.template.usersidebar')
                    <div class="col-lg-9 col-md-7">
                        <div class="checkout__form">
                            <h4>Thông tin cá nhân</h4>
                            <form action="{{ route('information.update',['id'=>auth()->user()->id]) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-8 col-md-6">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="checkout__input">
                                                    <p>Họ và Tên<span>*</span></p>
                                                    <input class="text-dark" value="{{ $customer->name }}" name="name" type="text">
                                                    @error('name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="checkout__input">
                                                    <p>Giới tính<span>*</span></p>
                                                    <select  name="gender" id="">
                                                        <option  value="" >Chọn giới tính</option>
                                                        <option {{ ($customer->gender===1)?'selected':'' }} value="1">Nam</option>
                                                        <option {{ ($customer->gender===0)?'selected':'' }} value="0">Nữ</option>
                                                    </select> 
                                                    @error('gender')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                               
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="checkout__input">
                                                    <p>Ngày sinh<span>*</span></p>
                                                    <input class="text-dark" value="{{ $customer->birth_date }}" name="birth_date" type="date">
                                                    @error('birth_date')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="checkout__input">
                                                    <p>Số điện thoại<span>*</span></p>
                                                    <input class="text-dark" value="{{ $customer->phone_number }}" name="phone_number"  type="text">
                                                    @error('phone_number')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                               
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="checkout__input">
                                                    <p>Email<span>*</span></p>
                                                    <input class="text-dark" value="{{ $customer->email }}" name="email" type="text">
                                                    @error('email')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                
                                            </div>
                                        </div>
                                        <div class="checkout__input">
                                            <p>Địa chỉ<span>*</span></p>
                                            <textarea  name="address" type="text" class="form-control" placeholder="Street Address" class="checkout__input__add">{{ $customer->address }}</textarea>
                                            @error('address')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="checkout__order">
                                            <h4>Ảnh đại diện</h4>
                                            <img width="100%" alt="" src="{{ asset($customer->image_url)}}">
                                            <input  type="file" name="image_url">
                                            @error('image_url')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Lưu</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Product Section End -->
@endsection