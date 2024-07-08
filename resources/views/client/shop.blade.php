@extends('client.layout.master_layout')
@section('content')
        <!-- Breadcrumb Section Begin -->
        <section class="breadcrumb-section set-bg" data-setbg="{{ asset('client/img/breadcrumb.jpg') }}">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <div class="breadcrumb__text">
                            <h2>Organi Shop</h2>
                            <div class="breadcrumb__option">
                                <a href="./index.html">Home</a>
                                <span>Shop</span>
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
                    <div class="col-lg-3 col-md-5">
                        <div class="sidebar">                            
                            <div class="sidebar__item">
                                <h4>Giá</h4>
                                <div class="price-range-wrap">
                                    <div class="price-range ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content"
                                        data-min="10" data-max="540">
                                        <div class="ui-slider-range ui-corner-all ui-widget-header"></div>
                                        <span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default"></span>
                                        <span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default"></span>
                                    </div>
                                    <form action="" method="post">

                                    
                                    <div class="range-slider">
                                        <div class="price-input">
                                            <input type="text" class="slider-price" id="minamount" >
                                            <input type="text" class="slider-price" id="maxamount" >
                                        </div>
                                    </div>
                                    </form>
                                </div>
                            </div>
                            <div class="sidebar__item categories_sidebar">
                                <h4>Danh mục sản phẩm</h4>
                                <ul>
                                    @include('client.category.category_hero')
                                </ul>
                            </div>

                            <div class="sidebar__item">
                                <h4>Thương hiệu</h4>
                                @foreach($brands as $brand)
                                <div class="sidebar__item__size">
                                    <a class="btn btn-secondary" href="{{ route('getbybrand',['id'=>$brand->id]) }}">{{ $brand->name }}</a>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-9 col-md-7 product-list-pagginate">
                        @include('client.product.pagginate-list')
                    </div>
                </div>
            </div>
        </section>
        <!-- Product Section End -->
@endsection


   


