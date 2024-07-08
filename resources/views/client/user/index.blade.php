@php
    use Carbon\Carbon;
@endphp    
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
                                <a href="{{ route('home') }}">Home</a>
                                <span>User Information</span>
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
                            <div class="d-flex justify-content-between">
                                <h4>Thông tin cá nhân</h4>
                                <a href="{{ route('information.edit') }}" class="text-success">Chỉnh sửa thông tin</a>
                            </div>
                            
                            <form action="#">
                                <div class="row">
                                    <div class="col-lg-8 col-md-6">
                                        <div class="row mt-4">
                                            <div class="col-3">Họ và tên:</div>
                                            <div class="col-8">{{ $customer->name }}</div>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col-3">Giới tính</div>
                                            <div class="col-8">
                                                @if($customer->gender==1)
                                                Nam
                                                @elseif($customer->gender==2)
                                                Nữ
                                                @else
                                                <a  class="text-primary" href="{{ route('information.edit') }}"><i>cập nhật thông tin</i></a>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col-3">Ngày sinh</div>
                                            <div class="col-8">
                                                @if($customer->birth_date!=null)
                                                {{ Carbon::parse($customer->birth_date)->format('d/m/Y') }}
                                                @else
                                                <a  class="text-primary" href="{{ route('information.edit') }}"><i>cập nhật thông tin</i></a>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col-3">Số điện thoại</div>
                                            <div class="col-8">
                                                @if($customer->phone_number!=null)
                                                {{ $customer->phone_number }}
                                                @else
                                                <a  class="text-primary" href="{{ route('information.edit') }}"><i>cập nhật thông tin</i></a>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col-3">Email</div>
                                            <div class="col-8">{{ $customer->email }}</div>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col-3">Địa chỉ</div>
                                            <div class="col-8">
                                                @if($customer->address!=null)
                                                {{ $customer->address }}
                                                @else
                                                <a  class="text-primary" href="{{ route('information.edit') }}"><i>cập nhật thông tin</i></a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
           
                                    <div class="col-lg-4 col-md-6">
                                        <div class="checkout__order">
                                            <h4 class="text-center">Ảnh đại diện</h4>
                                                @if($customer->image_url!=null)
                                                <img width="100%" alt="" src="{{ asset($customer->image_url)}}">
                                                @else
                                                <a  class="text-primary" href="{{ route('information.edit') }}"><i>cập nhật ảnh đại diện</i></a>
                                                @endif     
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Product Section End -->
@endsection