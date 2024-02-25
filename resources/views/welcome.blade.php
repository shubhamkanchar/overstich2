@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div id="topCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    @php
                        $index = 0;
                    @endphp
                    @foreach ($topAds as  $ad)
                        <button type="button" data-bs-target="#topCarousel" data-bs-slide-to="{{$index}}" class="@if($index == 0) active @endif"></button>
                        @php
                            $index++ ;
                        @endphp
                    @endforeach
                </div>
                <div class="carousel-inner">
                    @php
                    $index = 0;
                    @endphp
                    @foreach ($topAds as  $ad)
                        <div class="carousel-item  @if($index == 0) active @endif">
                            <a href="{{ $ad->link }}">
                                <img src="{{ asset('image/banner/' . $ad->file) }}" class="aspect-img br" alt="Los Angeles" style="aspect-ratio: 3/2 !important;">
                            </a>
                        </div>
                    @php
                    $index++ ;
                    @endphp
                    @endforeach
                </div>
                <button class="carousel-control-prev d-none d-lg-block" type="button" data-bs-target="#topCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </button>
                <button class="carousel-control-next d-none d-lg-block" type="button" data-bs-target="#topCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </button>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row mt-5 mb-5">
            <h4 style="font-weight: 600" class="text-secondary">IN THE SPOTLIGHT</h4>
            <section class="splide recent" aria-label="Splide Basic HTML Example">
                <div class="splide__track">
                    <ul class="splide__list">
                        @foreach ($newProducts as $newProduct)
                            <li class="splide__slide br-none m-lg-4 m-2">
                                <a class="card m-lg-2 shadow br-none"
                                    href="{{ route('products.show', $newProduct->slug) }}">
                                    <img class="aspect-img br-none" src="{{ asset($newProduct->images->first()->image_path) }}">
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </section>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row mt-5 mb-5">
            <h4 style="font-weight: 600" class="text-secondary">TOP RATED</h4>
            <section class="splide top" aria-label="Splide Basic HTML Example">
                <div class="splide__track">
                    <ul class="splide__list">
                        @foreach ($newProducts as $newProduct)
                            <li class="splide__slide br-none m-lg-4 m-2">
                                <a class="card card  shadow br-none" href="{{ route('products.show', $newProduct->slug) }}">
                                    <img class="aspect-img  br-none" src="{{ asset($newProduct->images->first()->image_path) }}">
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </section>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row mt-5 mb-5">
            <div class="col-6">
                <div id="leftCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        @php
                            $index = 0;
                        @endphp
                        @foreach ($leftAds as  $ad)
                            <button type="button" data-bs-target="#leftCarousel" data-bs-slide-to="{{$index}}" class="@if($index == 0) active @endif"></button>
                            @php
                                $index++ ;
                            @endphp
                        @endforeach
                    </div>
                    <div class="carousel-inner">
                        @php
                        $index = 0;
                        @endphp
                        @foreach ($leftAds as  $ad)
                            <div class="carousel-item  @if($index == 0) active @endif">
                                <a href="{{ $ad->link }}">
                                    <img src="{{ asset('image/banner/' . $ad->file) }}" class="aspect-img br" alt="Los Angeles" style="aspect-ratio: 3/2 !important;">
                                </a>
                            </div>
                        @php
                        $index++ ;
                        @endphp
                        @endforeach
                    </div>
                    <button class="carousel-control-prev d-none d-lg-block" type="button" data-bs-target="#leftCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>
                    <button class="carousel-control-next d-none d-lg-block" type="button" data-bs-target="#leftCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </button>
                </div>
            </div>
            <div class="col-6">
                <div id="rightCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        @php
                            $index = 0;
                        @endphp
                        @foreach ($rightAds as  $ad)
                            <button type="button" data-bs-target="#rightCarousel" data-bs-slide-to="{{$index}}" class="@if($index == 0) active @endif"></button>
                            @php
                                $index++ ;
                            @endphp
                        @endforeach
                    </div>
                    <div class="carousel-inner">
                        @php
                        $index = 0;
                        @endphp
                        @foreach ($rightAds as  $ad)
                            <div class="carousel-item  @if($index == 0) active @endif">
                                <a href="{{ $ad->link }}">
                                    <img src="{{ asset('image/banner/' . $ad->file) }}" class="aspect-img br" alt="Los Angeles" style="aspect-ratio: 3/2 !important;">
                                </a>
                            </div>
                        @php
                        $index++ ;
                        @endphp
                        @endforeach
                    </div>
                    <button class="carousel-control-prev d-none d-lg-block" type="button" data-bs-target="#rightCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>
                    <button class="carousel-control-next d-none d-lg-block" type="button" data-bs-target="#rightCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row mt-5 mb-5">
            <div id="bottomCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    @php
                        $index = 0;
                    @endphp
                    @foreach ($bottomAds as  $ad)
                        <button type="button" data-bs-target="#bottomCarousel" data-bs-slide-to="{{$index}}" class="@if($index == 0) active @endif"></button>
                        @php
                            $index++ ;
                        @endphp
                    @endforeach
                </div>
                <div class="carousel-inner">
                    @php
                    $index = 0;
                    @endphp
                    @foreach ($bottomAds as  $ad)
                        <div class="carousel-item  @if($index == 0) active @endif">
                            <a href="{{ $ad->link }}">
                                <img src="{{ asset('image/banner/' . $ad->file) }}" class="aspect-img br" alt="Los Angeles" style="aspect-ratio: 3/2 !important;">
                            </a>
                        </div>
                    @php
                    $index++ ;
                    @endphp
                    @endforeach
                </div>
                <button class="carousel-control-prev d-none d-lg-block" type="button" data-bs-target="#bottomCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </button>
                <button class="carousel-control-next d-none d-lg-block" type="button" data-bs-target="#bottomCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </button>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script
        src="https://cdn.jsdelivr.net/npm/@splidejs/splide-extension-auto-scroll@0.5.3/dist/js/splide-extension-auto-scroll.min.js">
    </script>
    <script type="module">

        var recent = new Splide('.recent', {
                type: 'loop',
                perPage: 4,
                focus: 'center',
                drag   : 'free',
                autoplay:true,
                autoScroll: {
                    speed: 1,
                },
            });

            recent.mount();

            var top = new Splide('.top', {
                type: 'loop',
                perPage: 4,
                focus: 'center',
                drag   : 'free',
                autoplay:true,
                autoScroll: {
                    speed: 1,
                },
            });
            top.mount();
    </script>
@endsection
