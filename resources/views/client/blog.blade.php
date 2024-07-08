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
                            <h2>Blog</h2>
                            <div class="breadcrumb__option">
                                <a href="{{ route('home') }}">Home</a>
                                <span>Blog</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Breadcrumb Section End -->
        <section class="blog spad">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-5">
                        <div class="blog__sidebar">
                            <div class="blog__sidebar__search">
                                <form action="{{ route('searchblog') }}" method="get">
                                    @csrf
                                    <input name="key" type="text" placeholder="Tìm kiếm bài viết...">
                                    <button type="submit"><span class="icon_search"></span></button>
                                </form>
                            </div>
                            <div class="blog__sidebar__item">
                                <h4>Categories</h4>
                                <ul>
                                   @include('client.type.type-blog')
                                </ul>
                            </div>
                            {{-- <div class="blog__sidebar__item">
                                <h4>Recent News</h4>
                                <div class="blog__sidebar__recent">
                                    <a href="#" class="blog__sidebar__recent__item">
                                        <div class="blog__sidebar__recent__item__pic">
                                            <img src="img/blog/sidebar/sr-1.jpg" alt="">
                                        </div>
                                        <div class="blog__sidebar__recent__item__text">
                                            <h6>09 Kinds Of Vegetables<br /> Protect The Liver</h6>
                                            <span>MAR 05, 2019</span>
                                        </div>
                                    </a>
                                    <a href="#" class="blog__sidebar__recent__item">
                                        <div class="blog__sidebar__recent__item__pic">
                                            <img src="img/blog/sidebar/sr-2.jpg" alt="">
                                        </div>
                                        <div class="blog__sidebar__recent__item__text">
                                            <h6>Tips You To Balance<br /> Nutrition Meal Day</h6>
                                            <span>MAR 05, 2019</span>
                                        </div>
                                    </a>
                                    <a href="#" class="blog__sidebar__recent__item">
                                        <div class="blog__sidebar__recent__item__pic">
                                            <img src="img/blog/sidebar/sr-3.jpg" alt="">
                                        </div>
                                        <div class="blog__sidebar__recent__item__text">
                                            <h6>4 Principles Help You Lose <br />Weight With Vegetables</h6>
                                            <span>MAR 05, 2019</span>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="blog__sidebar__item">
                                <h4>Search By</h4>
                                <div class="blog__sidebar__item__tags">
                                    <a href="#">Apple</a>
                                    <a href="#">Beauty</a>
                                    <a href="#">Vegetables</a>
                                    <a href="#">Fruit</a>
                                    <a href="#">Healthy Food</a>
                                    <a href="#">Lifestyle</a>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-7">
                        <div class="row">
                            @foreach($posts as $post)
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="blog__item">
                                    <div class="blog__item__pic">
                                        <img src="{{ asset($post->image) }}" alt="">
                                    </div>
                                    <div class="blog__item__text">
                                        <ul>
                                            <li><i class="fa fa-calendar-o"></i>{{ Carbon::parse($post->public_date)->format('d/m/Y') }}</li>
                                            <li><i class="fa fa-comment-o"></i>{{ count($post->comments) }}</li>
                                        </ul>
                                        <h5><a href="{{ route('getbypostid',['id'=>$post->id]) }}">{{ $post->title }}</a></h5>
                                        <p>{{ $post->subtitle }}</p>
                                        <a href="{{ route('getbypostid',['id'=>$post->id]) }}" class="blog__btn">READ MORE <span class="arrow_right"></span></a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            <div class="col-lg-12">
                                <div class="d-flex justify-content-center mt-5">
                                    @if(count($posts)>4)
                                    {{ $posts->links() }}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
@endsection


   


