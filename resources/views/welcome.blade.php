@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <section class="splide mb-5" aria-label="Splide Basic HTML Example">
                <div class="splide__track">
                    <ul class="splide__list">
                        @foreach ($ads as $ad)
                            <li class="splide__slide">
                                <a target="_blank" href="{{ $ad->link }}">
                                <img src="{{ asset('image/banner/' . $ad->file) }}" alt="" class="aspect-img br"
                                    style="aspect-ratio: 3/2 !important;">
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
            <h4 style="font-weight: 600" class="text-secondary">IN THE SPOTLIGHT</h4>
            <section class="splide recent" aria-label="Splide Basic HTML Example">
                <div class="splide__track">
                    <ul class="splide__list">
                        @foreach ($newProducts as $newProduct)
                            <li class="splide__slide br-none m-lg-4 m-2">
                                <a class="card m-lg-2 shadow br-none"
                                    href="{{ route('products.show', $newProduct->slug) }}">
                                    <img class="aspect-img br-none"
                                        src="{{ asset($newProduct->images->first()->image_path) }}" >
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
                                <a class="card card  shadow br-none"
                                    href="{{ route('products.show', $newProduct->slug) }}">
                                    <img class="aspect-img  br-none"
                                        src="{{ asset($newProduct->images->first()->image_path) }}">
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
                <section class="splide second-one" aria-label="Splide Basic HTML Example">
                    <div class="splide__track">
                        <ul class="splide__list">
                            @foreach ($ads as $ad)
                                <li class="splide__slide">
                                    <a target="_blank" href="{{ $ad->link }}">
                                    <img src="{{ asset('image/banner/' . $ad->file) }}" alt=""
                                        class="aspect-img br" style="aspect-ratio: 3/2 !important;">
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </section>
            </div>
            <div class="col-6">
                <section class="splide second-two" aria-label="Splide Basic HTML Example">
                    <div class="splide__track">
                        <ul class="splide__list">
                            @foreach ($ads as $ad)
                                <li class="splide__slide">
                                    <a target="_blank" href="{{ $ad->link }}">
                                    <img src="{{ asset('image/banner/' . $ad->file) }}" alt=""
                                        class="aspect-img br" style="aspect-ratio: 3/2 !important;">
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </section>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row mt-5 mb-5">
            <section class="splide bottom" aria-label="Splide Basic HTML Example">
                <div class="splide__track">
                    <ul class="splide__list">
                        @foreach ($ads as $ad)
                            <li class="splide__slide">
                                <a target="_blank" href="{{ $ad->link }}">
                                <img src="{{ asset('image/banner/' . $ad->file) }}" alt="" class="aspect-img br"
                                    style="width:100%;aspect-ratio: 3/2 !important;">
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </section>
        </div>
    </div>
@endsection
