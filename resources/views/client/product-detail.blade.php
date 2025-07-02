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
                                src="{{ isset($image) ? asset($image->url) : asset('') }}" alt="">
                        </div>

                        <div class="product__details__pic__slider owl-carousel">
                            @foreach ($thumps as $image)
                                @if ($image && $image->url)
                                    <img data-imgbigurl="{{ asset($image->url) }}" src="{{ asset($image->url) }}"
                                        alt="">
                                @else
                                    <img data-imgbigurl="{{ asset('') }}" src="{{ asset('') }}" alt="">
                                @endif
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
                        <style>
                            .active-box,
                            .hover-box:hover {
                                background-color: #7fad39 !important;
                                /* màu xanh lá */
                                color: white !important;
                            }
                        </style>
                        @if ($product->has_variants && $product->variants->count())
                            <div id="variant-price" class="mt-3 font-weight-bold text-success"></div>
                            <div id="variant-stock" class="text-muted"></div>
                            <div class="product__details__variants mb-3">
                                <label><strong>Chọn biến thể:</strong></label>
                                <div class="btn-group btn-group-toggle d-flex" data-toggle="buttons">
                                    <div class="w-full d-flex flex-column" style="gap:10px:height:max-content">
                                        @foreach ($groupedAttributes as $attributeName => $data)
                                            <div class="w-full d-flex align-items-center mb-2" style="gap: 15px;">
                                                <strong>{{ $attributeName }}:</strong>

                                                @foreach ($data['values'] as $value)
                                                    <a class="hover-box variant-option"
                                                        data-attribute-id="{{ $value['product_attribute_id'] }}"
                                                        data-value-id="{{ $value['id'] }}"
                                                        style="padding:5px 10px; background-color:#f5f5f5; border-radius:5px;cursor:pointer;">
                                                        @if ($data['display_type'] === 'color')
                                                            <div class="text-center d-flex align-items-center"
                                                                style="gap:10px">
                                                                <div
                                                                    style="background-color: {{ $value['value'] }};
                                                                width: 20px;
                                                                height: 20px;
                                                                border-radius: 50%;
                                                                border: 1px solid #000;">
                                                                </div>
                                                                <div>{{ $value['label'] }}</div>
                                                            </div>
                                                        @else
                                                            <div>{{ $value['label'] }}</div>
                                                        @endif
                                                    </a>
                                                @endforeach
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="d-flex">
                                @if ($product->sale_percent != 1)
                                    <div style="color: black; margin-right:15px;" class="product__details__price">Giá:</div>
                                    <div class="product__details__price">
                                        {{ number_format($product->price * $product->sale_percent, 0, ',', '.') . 'đ' }}
                                    </div>
                                    <div style="color: black; text-decoration: line-through ; margin-left:30px;"
                                        class="product__details__price">
                                        {{ number_format($product->price, 0, ',', '.') . 'đ' }}
                                    </div>
                                @else
                                    <div style="color: black; margin-right:15px;" class="product__details__price">Giá:</div>
                                    <div class="product__details__price">
                                        ${{ number_format($product->price * $product->sale_percent, 0, ',', '.') . 'đ' }}
                                    </div>
                                @endif
                            </div>
                        @endif


                        <p>{{ $product->description == null ? 'Chưa có mô tả' : $product->description }}</p>
                        <form action="{{ route('cart.store') }}" method="POST">
                            @csrf
                            <input value="{{ $product->id }}" type="text" name="id" hidden>
                            <div class="product__details__quantity">
                                <div class="quantity">
                                    <div class="pro-qty">
                                        <input type="text" value="1" name="quantity">
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="primary-btn border-0">THÊM GIỎ HÀNG</button>
                        </form>
                        <ul>
                            <li><b>Tình trạng</b> <span>{{ $product->quantity > 0 ? 'Còn hàng' : 'Hết hàng' }}</span></li>
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
                                    @if ($product->longdescription == null)
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
                                    @if (Auth::check())
                                        <img src="{{ Auth::user()->image_url != null ? asset(Auth::user()->image_url) : asset('img/logo/user.png') }}"
                                            alt="User Avatar">
                                    @else
                                        <img src="https://via.placeholder.com/40" alt="User Avatar">
                                    @endif

                                </div>
                                <div class="input-group mb-3">
                                    @if (Auth::check())
                                        <input value="{{ auth::user()->id }}" type="text" name="user_id" hidden>
                                    @else
                                        <input value="" type="text" name="user_id" hidden>
                                    @endif
                                    <input value="1" type="text" name="commentable_type" hidden>
                                    <input value="{{ $product->id }}" type="text" name="commentable_id" hidden>
                                    <input value="0" type="text" name="option" hidden>
                                    <input name ="body" type="text" class="form-control" placeholder="Comment..."
                                        aria-label="Comment..." aria-describedby="button-addon2">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="submit"
                                            id="button-comment">Comment</button>
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
    <script>
        const variants = @json($product->variants); // lấy toàn bộ danh sách biến thể
        const selections = {};

        document.querySelectorAll('.variant-option').forEach(el => {
            el.addEventListener('click', function() {
                const attrId = this.dataset.attributeId;
                const valId = this.dataset.valueId;

                // Ghi nhận lựa chọn
                selections[attrId] = parseInt(valId);

                // Đánh dấu active (xóa class active cũ)
                document.querySelectorAll(`.variant-option[data-attribute-id="${attrId}"]`)
                    .forEach(btn => btn.classList.remove('active-box'));

                this.classList.add('active-box');

                // Nếu đã chọn đủ 2 thuộc tính
                if (Object.keys(selections).length === 2) {
                    let matched = null;

                    // Lặp qua biến thể để tìm đúng
                    variants.forEach(variant => {
                        const variantAttrs = variant.attributes;
                        let matchedCount = 0;

                        variantAttrs.forEach(attr => {
                            const aId = attr.attribute_id;
                            const vId = attr.value_id;

                            if (selections[aId] && selections[aId] === vId) {
                                matchedCount++;
                            }
                        });

                        if (matchedCount === 2) {
                            matched = variant;
                        }
                    });

                    // Nếu tìm được, hiển thị giá và stock
                    if (matched) {
                        document.getElementById('variant-price').innerText =
                            `Giá: ${Number(matched.price).toLocaleString()}đ`;
                        document.getElementById('variant-stock').innerText = `Tồn kho: ${matched.stock}`;
                    } else {
                        document.getElementById('variant-price').innerText =
                            'Không tìm thấy biến thể phù hợp';
                        document.getElementById('variant-stock').innerText = '';
                    }
                }
            });
        });
    </script>
@endsection
