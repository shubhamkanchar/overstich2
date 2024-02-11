@extends('layouts.app')

@section('content')
    <section class="splide mb-5" aria-label="Splide Basic HTML Example" >
        <div class="splide__track">
            <ul class="splide__list">
                @foreach ($sellers as $seller)
                    <li class="splide__slide">
                        <img src="{{ asset('image/seller/' . $seller->sellerInfoImage->first()->file) }}"
                            alt="{{ $seller->sellerInfo->brand }}" class="aspect-img" style="aspect-ratio: 3/2 !important;">
                    </li>
                @endforeach
            </ul>
        </div>
    </section>

    <h4 class="mt-5 mb-3 text-center"  style="font-weight: 900">IN THE SPOTLIGHT</h4>
    <section class="splide recent" aria-label="Splide Basic HTML Example">
        <div class="splide__track">
            <ul class="splide__list">
                @foreach ($newProducts as $newProduct)
                    <li class="splide__slide">
                        <a class="card m-lg-3 shadow" href="{{ route('products.show', $newProduct->slug) }}">
                            <img class="aspect-img" src="{{ asset($newProduct->images->first()->image_path) }}">
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </section>

    <h4 class="mt-5 mb-3 text-center" style="font-weight: 900">TOP RATED</h4>
    <section class="splide top" aria-label="Splide Basic HTML Example">
        <div class="splide__track">
            <ul class="splide__list">
                @foreach ($newProducts as $newProduct)
                    <li class="splide__slide">
                        <a class="card m-lg-3 shadow" href="{{ route('products.show', $newProduct->slug) }}">
                            <img class="aspect-img" src="{{ asset($newProduct->images->first()->image_path) }}">
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </section>

    <div class="container-fluid mt-5 mb-5">
        <div class="row">
            <div class="col-6">
                <section class="splide second-one" aria-label="Splide Basic HTML Example">
                    <div class="splide__track">
                        <ul class="splide__list">
                            @foreach ($sellers as $seller)
                                <li class="splide__slide">
                                    <img src="{{ asset('image/seller/' . $seller->sellerInfoImage->first()->file) }}"
                                        alt="{{ $seller->sellerInfo->brand }}" class="aspect-img" style="width:100%">
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
                            @foreach ($sellers as $seller)
                                <li class="splide__slide">
                                    <img src="{{ asset('image/seller/' . $seller->sellerInfoImage->first()->file) }}"
                                        alt="{{ $seller->sellerInfo->brand }}" class="aspect-img" style="width:100%">
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </section>
            </div>
        </div>
    </div>

    <section class="splide bottom" aria-label="Splide Basic HTML Example">
        <div class="splide__track">
            <ul class="splide__list">
                @foreach ($sellers as $seller)
                    <li class="splide__slide">
                        <img src="{{ asset('image/seller/' . $seller->sellerInfoImage->first()->file) }}"
                            alt="{{ $seller->sellerInfo->brand }}" class="aspect-img" style="width:100%;aspect-ratio: 3/2 !important;">
                    </li>
                @endforeach
            </ul>
        </div>
    </section>
    
@endsection
