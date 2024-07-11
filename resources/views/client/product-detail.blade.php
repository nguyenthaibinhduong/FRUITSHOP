@extends('client.layout.master_layout')
@section('content')
        <!-- Breadcrumb Section Begin -->
        <section class="breadcrumb-section set-bg" data-setbg="{{ asset('client/img/breadcrumb.jpg') }}">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <div class="breadcrumb__text">
                            <h2>{{ $product->name }}</h2>
                            <div class="breadcrumb__option">
                                <a href="./index.html">Shop</a>
                                <span>Chi tiết sản phẩm</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Breadcrumb Section End -->
    
        <section class="product-details spad">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="product__details__pic">
                            <div class="product__details__pic__item">
                                <img class="product__details__pic__item--large"
                                    src="{{ asset($image->url) }}" alt="">
                            </div>
                            <div class="product__details__pic__slider owl-carousel">
                                @foreach($thumps as $image)
                                <img data-imgbigurl="{{ asset($image->url) }}"
                                    src="{{ asset($image->url) }}" alt="">
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="product__details__text">
                            <h3>{{ $product->name }}</h3>
                            <div class="product__details__rating">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star-half-o"></i>
                                <span>(18 reviews)</span>
                            </div>
                            <div class="d-flex">
                            @if($product->sale_percent!=1)
                            
                                <div style="color: black; margin-right:15px;" class="product__details__price">Giá:</div>
                                <div class="product__details__price">{{ number_format($product->price*$product->sale_percent, 0, ',', '.').'đ' }}</div>
                                <div style="color: black; text-decoration: line-through ; margin-left:30px;" class="product__details__price">{{ number_format($product->price, 0, ',', '.').'đ' }}</div>
                            
                            @else
                            <div style="color: black; margin-right:15px;" class="product__details__price">Giá:</div>
                            <div class="product__details__price">${{ number_format($product->price*$product->sale_percent, 0, ',', '.').'đ' }}</div>
                            @endif
                            </div>
                            <p>{{ ($product->description==null)?'Chưa có mô tả':$product->description }}</p>
                             <form action="{{ route('cart.store') }}" method="POST">
                                @csrf
                            <input value="{{ $product->id }}" type="text" name="id" hidden>
                            <div class="product__details__quantity">
                                <div class="quantity">   
                                    <div class="pro-qty">
                                        <input  type="text" value="1" name="quantity">
                                    </div>
                                </div>
                            </div>
                            <button type="submit"  class="primary-btn border-0">THÊM GIỎ HÀNG</button>
                            </form>
                            <ul>
                                <li><b>Tình trạng</b> <span>{{ ($product->quantity>0)?'Còn hàng':'Hết hàng' }}</span></li>
                                <li><b>Shipping</b> <span>01 day shipping. <samp>Free pickup today</samp></span></li>
                                <li><b>Weight</b> <span>0.5 kg</span></li>
                                <li><b>Share on</b>
                                    <div class="share">
                                        <a href="#"><i class="fa fa-facebook"></i></a>
                                        <a href="#"><i class="fa fa-twitter"></i></a>
                                        <a href="#"><i class="fa fa-instagram"></i></a>
                                        <a href="#"><i class="fa fa-pinterest"></i></a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="product__details__tab">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab"
                                        aria-selected="true">Description</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="tabs-1" role="tabpanel">
                                    <div class="product__details__tab__desc">
                                        <h6>Thông tin sản phẩm</h6>
                                        @if($product->longdescription==null)
                                        <p>Chưa có thông tin</p>
                                        @else
                                        {!! $product->longdescription !!}
                                        @endif
                                    </div>
                                </div>
                               
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="product__details__tab">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab"
                                        aria-selected="true">Comment</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div id="commentsList">
                                        @include('client.comment.index')
                                </div>
                        
                                <form id="commentForm" class="comment-form" method="get">
                                    @csrf
                                    <div class="comment-avatar">
                                        @if(Auth::check())
                                        <img src="{{ (Auth::user()->image_url!=null)?asset(Auth::user()->image_url):asset('img/logo/user.png') }}" alt="User Avatar">
                                        @else
                                        <img src="https://via.placeholder.com/40" alt="User Avatar">
                                        @endif
                                        
                                    </div>
                                    <div class="input-group mb-3">
                                        @if(Auth::check())<input value="{{ auth::user()->id }}" type="text" name="user_id" hidden>
                                        @else
                                        <input value="" type="text" name="user_id" hidden>
                                        @endif
                                        <input value="1" type="text" name="commentable_type" hidden>
                                        <input value="{{ $product->id }}" type="text" name="commentable_id" hidden>
                                        <input value="0" type="text" name="option" hidden>
                                        <input name ="body" type="text" class="form-control" placeholder="Comment..." aria-label="Comment..." aria-describedby="button-addon2">
                                        <div class="input-group-append">
                                          <button class="btn btn-primary" type="submit" id="button-comment">Comment</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            </div>
                        </div>
                    </div>
                    {{-- Comment --}}
                </div>
            </div>
        </section>
@endsection


   


