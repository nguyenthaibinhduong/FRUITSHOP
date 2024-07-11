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
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                            </div>
                        @elseif(session('danger'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('danger') }}
                            </div>
                        @endif
                        <div class="checkout__form">
                            <h4>Đổi mật khẩu </h4>
                            <form action="{{ route('post-password') }}" method="POST" >
                                @csrf
                                <input class="text-dark" value="{{ Auth::user()->email }}" name="email" type="text" hidden>
                                <div class="row">
                                    <div class="col-lg-8 col-md-6">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="checkout__input">
                                                    <p>Mật khẩu cũ<span>*</span></p>
                                                    <input class="text-dark" name="oldpassword" type="password">
                                                    @error('oldpassword')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                
                                            </div>
                                        </div>
                                         <div class="row">
                                            <div class="col-lg-12">
                                                <div class="checkout__input">
                                                    <p>Mật khẩu mới<span>*</span></p>
                                                    <input class="text-dark" name="password" type="password">
                                                    @error('password')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                
                                            </div>
                                        </div>
                                         <div class="row">
                                            <div class="col-lg-12">
                                                <div class="checkout__input">
                                                    <p>Nhập lại mật khẩu mới<span>*</span></p>
                                                    <input class="text-dark" name="password_confirmation" type="password">
                                                    @error('password_confirmation')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Đổi mật khẩu</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Product Section End -->
@endsection