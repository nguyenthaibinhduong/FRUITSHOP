@php
    $object='customer';
    $object_title='khách hàng';
    use Carbon\Carbon;
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
<form action="{{ route($object.'.update',['id'=>$user->id]) }}" method="post">
    @csrf
    <div class="col-sm-12 col-12">
								<!-- Card start -->
								<div class="card">
									<div class="card-body">

										<!-- Row start -->
										<div class="row">
											<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-6 col-sm-12 col-12">
												<div class="row">
													<div class="col-sm-6 col-12">
														<div class="d-flex flex-row">
															<img src="{{ ($user->image_url)?asset($user->image_url):asset('img/logo/user-1.jpg') }}" class="img-fluid change-img-avatar" alt="Image">
														</div>
													</div>
                                                    <div class="col-sm-6 col-12">
														<div class="d-flex justify-content-end">
                                                            <a class="btn btn-dark" href="{{ route('user.edit',['id'=>$user->id]) }}">Quản lý tài khoản đăng nhập</a>
														</div>
													</div>
												</div>
												<div class="row">
													<div class="col-xxl-4 col-sm-6 col-12">
														<!-- Form Field Start -->
														<div class="mb-3"> 
															<label for="name" class="form-label">Họ và tên</label>
															<input name="name" value="{{ $user->name }}" type="text" class="form-control" id="name" placeholder="Họ và tên" autocomplete="off">
                                                            @error('name')
                                                            <span class="text-danger">{{ $message }}</span>
                                                            @enderror
														</div>
													</div>
													<div class="col-xxl-4 col-sm-6 col-12">
														<!-- Form Field Start -->
														<div class="mb-3">
															<label for="email" class="form-label">Email</label>
															<input value="{{ $user->email }}" type="text" class="form-control" id="email" placeholder="Email" disabled>
                        
														</div>
													</div>
													<div class="col-xxl-4 col-sm-6 col-12">
														<!-- Form Field Start -->
														<div class="mb-3">
															<label for="phone_number" class="form-label">Số điện thoại</label>
															<input value="{{ $user->phone_number }}" name="phone_number" type="number" class="form-control" id="phone_number" placeholder="Số điện thoại">
                                                            @error('phone_number')
                                                            <span class="text-danger">{{ $message }}</span>
                                                            @enderror
														</div>
													</div>
													<div class="col-xxl-4 col-sm-6 col-12">
														<!-- Form Field Start -->
														<div class="mb-3">
															<label for="address"  class="form-label">Address</label>
															<input value="{{ $user->address }}" name="address" type="text" class="form-control" id="address" placeholder="Address">
                                                            @error('address')
                                                            <span class="text-danger">{{ $message }}</span>
                                                            @enderror
														</div>
													</div>
													<div class="col-xxl-4 col-sm-6 col-12">
														<!-- Form Field Start -->
														<div class="mb-3">
															<label for="birth_date"  class="form-label">Ngày sinh</label>
															<input value="{{ $user->birth_date }}" name="birth_date" type="date" class="form-control" id="bith_date">
                                                            @error('birth_date')
                                                            <span class="text-danger">{{ $message }}</span>
                                                            @enderror
														</div>
													</div>
													<div class="col-xxl-4 col-sm-6 col-12">
														<!-- Form Field Start -->
														<div class="mb-3">
															<label for="gender"  class="form-label">Giới tính</label>
															<select name="gender" class="form-control" id="gender">
                                                                <option  value="" >Chọn giới tính</option>
                                                                <option {{ ($user->gender===1)?'selected':'' }} value="1">Nam</option>
                                                                <option {{ ($user->gender===0)?'selected':'' }} value="0">Nữ</option>
															</select>
                                                            @error('gender')
                                                            <span class="text-danger">{{ $message }}</span>
                                                            @enderror
														</div>
													</div>
												</div>
											</div>
										</div>
										<!-- Row end -->

									</div>
								</div>
								<!-- Card end -->
    </div>
    <div class="col-sm-12 col-12">
        <div class="custom-btn-group flex-end">
            <button type="submit" class="btn btn-success">Lưu</button>
        </div>
    </div>

</form>

@endsection