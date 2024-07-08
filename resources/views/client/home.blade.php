@extends('client.layout.master_layout')
@section('content')
        <section class="categories">

            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-title">
                            <h2>Sale Off</h2>
                        </div>
                    </div>
                    <div class="categories__slider owl-carousel">
                        @foreach($sale_products as $product)
                        <div class="col-lg-3">
                            <div class="product__discount__item"> 
                                @foreach($images as $image)
                                   @if($image->product_id == $product->id)
                                  
                                       <div class="product__discount__item__pic set-bg"
                                   data-setbg="{{ asset($image->url) }}">
                                   
                                   @endif
                                   @endforeach
                                   <div class="product__discount__percent">-{{ 100-$product->sale_percent*100 }}%</div>
                                   <ul class="product__item__pic__hover"> 
                                    <form method="POST">
                                       
                                        @csrf
                                        @if(Auth::check())<input value="{{ auth::user()->id }}" type="text" name="user_id_cart_{{ $product->id }}" id="user_id_cart_{{ $product->id }}" hidden>
                                        @else
                                        <input value="" type="text" name="user_id_cart_{{ $product->id }}" id="user_id_cart_{{ $product->id }}" hidden>
                                        @endif
                                    <li><a href="{{ route('getdetail',['id'=>$product->id]) }}"><i class="icon_ul"></i></a></li>
                                   
                                    <li><button type="button" data-id="{{ $product->id }}" class="add-to-cart" ><i class="fa fa-shopping-cart"></i></button></li>
                                    </form>
                                </ul>
                               </div>
                               <div class="product__discount__item__text">
                                   <span>{{ $product->brand->name }}</span>
                                   <h5><a href="#">{{ $product->name }}</a></h5>
                                   <div class="product__item__price">{{ number_format($product->price*$product->sale_percent, 0, ',', '.').'đ' }}<span>{{ number_format($product->price, 0, ',', '.').'đ' }}</span></div>
                               </div>
                           </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
        <!-- Featured Section Begin -->
        <section class="featured spad">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-title">
                            <h2>Featured Product</h2>
                        </div>
                        <div class="featured__controls">
                            <ul>
                               <li  data-filter="*">All</li>
                               @foreach($brands as $brand)
                               <li class="{{ ($loop->iteration==1)?'active':'' }}" data-filter=".{{ strtolower($brand->name) }}">{{ $brand->name }}</li>
                                @endforeach
                                
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row featured__filter">
                    @foreach($brands as $brand)
                        @php
                        $interation =0;
                        @endphp
                        @foreach ($non_sale_products as $product)
                            @if($product->brand->id==$brand->id && $interation <2)
                                <a href="{{ route('getdetail',['id'=>$product->id]) }}"><div class="col-lg-3 col-md-4 col-sm-6 mix {{ strtolower($product->brand->name) }}">
                                    <div class="featured__item">
                                        @foreach($images as $image)
                                            @if($image->product_id == $product->id)
                                        
                                                <div class="product__discount__item__pic set-bg"
                                            data-setbg="{{ asset($image->url) }}">
                                            
                                            @endif
                                        @endforeach
                                        </div>
                                        <div class="featured__item__text">
                                            <h6><a href="{{ route('getdetail',['id'=>$product->id]) }}">{{ $product->name }}</a></h6>
                                            <h5>{{ number_format($product->price*$product->sale_percent, 0, ',', '.').'đ' }}</h5>
                                        </div>
                                    </div>
                                </div></a>
                                
                                @php
                                    $interation ++;
                                @endphp
                            @endif
                        @endforeach
                    @endforeach
                </div>
                <div class="d-flex justify-content-end w-100">
                    <a class="btn btn-dark" href="{{ route('shop') }}"><b>Xem tiếp >></b></a>
                </div>
            </div>
        </section>
        <!-- Featured Section End -->
    
        <!-- Banner Begin -->
        <div class="banner">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="banner__pic">
                            <img src="client/client/img/banner/banner-1.jpg" alt="">
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="banner__pic">
                            <img src="client/client/img/banner/banner-2.jpg" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Banner End -->
    
    
    
        <!-- Blog Section Begin -->
        <section class="from-blog spad">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-title from-blog__title">
                            <h2>From The Blog</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    @php
                        use Carbon\Carbon;
                    @endphp
                    @foreach($posts as $post)
                    <div class="col-lg-4 col-md-4 col-sm-6">
                        <a href="{{ route('getbypostid',['id'=>$post->id]) }}">
                            <div class="blog__item">
                                <div class="blog__item__pic">
                                    <img src="{{ asset($post->image) }}" alt="">
                                </div>
                                <div class="blog__item__text">
                                    <ul>
                                        <li><i class="fa fa-calendar-o"></i>{{ Carbon::parse($post->public_date)->format('d/m/Y') }}</li>
                                        <li><i class="fa fa-comment-o"></i> 5</li>
                                    </ul>
                                    <h5><a href="{{ route('getbypostid',['id'=>$post->id]) }}">{{ $post->title }}</a></h5>
                                    <p>{{ $post->subtitle }}</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
                <div class="d-flex justify-content-end w-100">
                    <a class="btn btn-dark" href="{{ route('blog') }}"><b>Xem tiếp >></b></a>
                </div>
            </div>
        </section>
        <!-- Blog Section End -->
@endsection

