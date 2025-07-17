@extends('client.layout.blank_layout')

@section('content')
    <section class="breadcrumb-section set-bg" data-setbg="{{ asset('client/img/breadcrumb.jpg') }}">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2>{{ $page->title }}</h2>
                        <div class="breadcrumb__option">
                            <a href="{{ url($page->slug) }}">{{ $page->title }}</a>
                            <span>{{ $page->title }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="container py-4">
        @foreach ($page->sections as $section)
            <div class="row">
                @foreach ($section->blocks as $block)
                    @php
                        $position = $block->position;
                        $colClass = 'col';
                        if ($position) {
                            $colClass = "col-{$position->width} col-sm-{$position->width_sm} col-md-{$position->width_md} col-lg-{$position->width_lg}";
                            $align = $position->align ? "text-{$position->align}" : '';
                            $order = $position->order ? "order-{$position->order}" : '';
                        }
                    @endphp

                    <div class="{{ $colClass }} mb-4 {{ $align ?? '' }} {{ $order ?? '' }}">
                        <div class="block p-3 border rounded shadow-sm">
                            <h4>{{ $block->title }}</h4>
                            <div>{!! $block->content !!}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
@endsection
