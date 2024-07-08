

<section class="hero {{ Request::is('/') ?'':'hero-normal' }}">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="hero__categories">
                    <div class="hero__categories__all">
                        <i class="fa fa-bars"></i>
                        <span>All Category</span>
                    </div>
                    <ul>
                        @include('client.category.category_hero')
                    </ul>
                </div>
            </div>
            <div class="col-lg-9">
                @include('client.template.search_form')
                @if(Request::is('/'))
                @include('client.banner.banner_hero')
                @endif
            </div>
        </div>
    </div>
</section>
