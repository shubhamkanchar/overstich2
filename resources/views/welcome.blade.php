@extends('layouts.app')

@section('content')
<!-- <div class="container-fluid"> -->
<div id="demo" class="carousel slide" data-bs-ride="carousel">

    <!-- Indicators/dots -->
    <div class="carousel-indicators">
        @foreach ($sellers as $index => $seller)
            <button type="button" data-bs-target="#demo" data-bs-slide-to="{{ $index }}" class="{{ $index === 0 ? 'active' : '' }}"></button>
        @endforeach
    </div>

    <div class="carousel-inner">
        @foreach ($sellers as $seller)
            <div class="carousel-item {{ $loop->index == 0 ? 'active' : ''}}">
                <img src="{{ asset('image/seller/' . $seller->sellerInfoImage->first()->file) }}" alt="{{ $seller->sellerInfo->brand}}" class="d-block" style="width:100%">
                <div class="carousel-caption">
                    <h2>{{ ucfirst($seller->sellerInfo->brand) }}</h2>
                    <a type="button" href="{{ route('products.brand', $seller->sellerInfo->slug) }}" class="btn btn-lg btn-secondary">Shop</a>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Left and right controls/icons -->
    <button class="carousel-control-prev" type="button" data-bs-target="#demo" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#demo" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
    </button>
</div>

<!-- </div> -->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12 mt-5 mb-5">
            <img width="100%" src="{{ asset('image/banner/banner1.jpg') }}">
        </div>
        <div class="col-md-12 mt-5 mb-5">
            <img width="100%" src="{{ asset('image/banner/banner2.jpg') }}">
        </div>
    </div>
    <div class="row mt-md-5 mb-5">
        @foreach ($newProducts as $newProduct)
            <div class="col-md-2 col-3 col-3 ">
                <a href="{{ route('products.show',$newProduct->slug) }}">
                    <img class="small-banner" width="100%" src="{{ asset($newProduct->images->first()->image_path) }}">
                </a>
            </div>
        @endforeach
    </div>
    <div class="row mt-5 mb-5">
        @php $class = ['col-5', 'col-7']; @endphp
        @foreach ($hotProducts as $hotProduct)
            <div class="{{ $class[$loop->index % 2] }}">
                <a href="{{ route('products.show',$hotProduct->slug) }}">
                    <img class="small-banner" width="100%" src="{{ asset($hotProduct->images->first()->image_path) }}">
                </a>
            </div> 
        @endforeach
    </div>
    <div class="row justify-content-center mt-5 mb-5">
        @foreach ($products as $product)
            <div class="col-3">
                <a href="{{ route('products.show',$product->slug) }}">
                    <img class="small-banner" width="100%" src="{{ asset($product->images->first()->image_path) }}">
                </a>
            </div>
        @endforeach
    </div>
</div>
@endsection