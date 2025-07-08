<div class="row ">
    @foreach ($products as $product)
        <div class="col-lg-4 col-md-6 col-sm-6 ">
            <div class="product__discount__item">
                @php
                    $img = 'https://placehold.co/400x400?text=No+Image';
                    foreach ($images as $image) {
                        if ($image->product_id == $product->id) {
                            $img = asset($image->url);
                            break;
                        }
                    }

                @endphp
                <div class="product__discount__item__pic set-bg" data-setbg="{{ $img }}">
                    @if ($product->sale_percent != 1)
                        <div class="product__discount__percent">-{{ 100 - $product->sale_percent * 100 }}%</div>
                    @endif
                    <ul class="product__item__pic__hover">
                        <form method="POST">

                            @csrf
                            @if (Auth::check())
                                <input value="{{ auth::user()->id }}" type="text"
                                    name="user_id_cart_{{ $product->id }}" id="user_id_cart_{{ $product->id }}"
                                    hidden>
                            @else
                                <input value="" type="text" name="user_id_cart_{{ $product->id }}"
                                    id="user_id_cart_{{ $product->id }}" hidden>
                            @endif
                            <li><a href="{{ route('getdetail', ['id' => $product->id]) }}"><i class="icon_ul"></i></a>
                            </li>

                            <li><button type="button" data-id="{{ $product->id }}"
                                    class="add-to-cart add-pro-{{ $product->id }}"><i
                                        class="fa fa-shopping-cart"></i></button></li>
                        </form>
                    </ul>
                </div>

                @if ($product->has_variants == 1)
                    <div class="product__discount__item__text">
                        <span>{{ $product->brand->name }}</span>
                        <h5><a href="{{ route('getdetail', ['id' => $product->id]) }}">{{ $product->name }}</a></h5>
                        <div class="product__item__price">
                            {{ number_format($product->variants->min('price'), 0, ',', '.') . 'đ' }} -
                            {{ number_format($product->variants->max('price'), 0, ',', '.') . 'đ' }}
                        </div>
                    </div>
                @else
                    @if ($product->sale_percent == 1)
                        <div class="product__discount__item__text">
                            <span>{{ $product->brand->name }}</span>
                            <h5><a href="{{ route('getdetail', ['id' => $product->id]) }}">{{ $product->name }}</a>
                            </h5>
                            <div class="product__item__price">
                                {{ number_format($product->price * $product->sale_percent, 0, ',', '.') . 'đ' }}</div>

                        </div>
                    @else
                        <div class="product__discount__item__text">
                            <span>{{ $product->brand->name }}</span>
                            <h5><a href="{{ route('getdetail', ['id' => $product->id]) }}">{{ $product->name }}</a>
                            </h5>
                            <div class="product__item__price">
                                {{ number_format($product->price * $product->sale_percent, 0, ',', '.') . 'đ' }}<span>{{ number_format($product->price * $product->sale_percent, 0, ',', '.') . 'đ' }}</span>
                            </div>
                        </div>
                    @endif
                @endif
            </div>
        </div>
    @endforeach
</div>
<div class="d-flex justify-content-center mt-5">
    @if (count($products) >= 9)
        {{ $products->links() }}
    @endif
</div>
