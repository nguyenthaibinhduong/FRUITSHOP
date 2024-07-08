@php
    use Illuminate\Support\Str;
@endphp
<div id="carouselExampleFade" class="carousel slide carousel-fade" data-ride="carousel">
  <div class="carousel-inner">
    @foreach ($banners as $banner)
    
    <div class="carousel-item {{ ($loop->iteration==1)?'active':'' }}">
      <div class="hero__item set-bg" data-setbg="{{ asset($banner->image) }}">
        <div class="hero__text">
            <span>FRUIT FRESH</span>
            <h2>{{ ($banner->title!=null)?Str::before($banner->title, ' '):'' }}<br>{{ ($banner->title!=null)?Str::after($banner->title, Str::before($banner->title, ' ')):'' }}</h2>
            <p>{{ ($banner->sub_title!=null)?$banner->sub_title:'' }}</p>
            <a href="{{ route('shop') }}" class="primary-btn">SHOP NOW</a>
        </div>
      </div>
    </div> 
    @endforeach
  </div>
  <a class="carousel-control-prev" href="#carouselExampleFade" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleFade" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>
  <script>
    $(document).ready(function(){
      // Auto slide every 2 seconds
      $('#carouselExampleFade').carousel({
        interval: 1000
      });
    });
  </script>
