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
                                <span>Blog Detail</span>
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
                        <div class="blog__sidebar">.
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
                           
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-7 order-md-1 order-1">
                        <div class="blog__details__text px-3">
                            {!! $blog->content !!}
                        </div>
                        <div class="blog__details__content">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="blog__details__author">
                                        <div class="blog__details__author__pic">
                                            <img src="{{ asset("client/img/blog/details/details-author.jpg") }}" alt="">
                                        </div>
                                        <div class="blog__details__author__text">
                                            <h6>{{ $blog->author }}</h6>
                                            <span>Được đăng bởi : {{ $blog->user->name }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="blog__details__widget">
                                        {{-- <ul>
                                            <li><span>Categories:</span>{{  }}</li>
                                            <li><span>Tags:</span> All, Trending, Cooking, Healthy Food, Life Style</li>
                                        </ul> --}}
                                        <div class="blog__details__social">
                                            <a href="#"><i class="fa fa-facebook"></i></a>
                                            <a href="#"><i class="fa fa-twitter"></i></a>
                                            <a href="#"><i class="fa fa-google-plus"></i></a>
                                            <a href="#"><i class="fa fa-linkedin"></i></a>
                                            <a href="#"><i class="fa fa-envelope"></i></a>
                                        </div>
                                    </div>
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
                                    <input value="0" type="text" name="commentable_type" hidden>
                                    <input value="{{ $blog->id }}" type="text" name="commentable_id" hidden>
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
            </div>
        </section>
        <section class="related-blog spad">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-title related-blog-title">
                            <h2>Post You May Like</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    @php
                        use Carbon\Carbon;
                    @endphp
                    @foreach ($posts as $post)
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
            </div>
        </section>
@endsection