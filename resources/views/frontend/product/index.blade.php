@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row mt-5 mb-5">
        <div class="col-md-12">
            <h3 class="ps-4"><b>{{ ucfirst($category->category)}}</b></h3>
        </div>
        <div class="col-md-12 ms-4">
            <span class="dropdown-toggle me-5" data-bs-toggle="dropdown">
                SHORT BY
            </span>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">ASSENDING</a></li>
                <li><a class="dropdown-item" href="#">DECENDING</a></li>
            </ul>
            <span class="dropdown-toggle me-5" data-bs-toggle="dropdown">
                SIZE
            </span>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">SMALL</a></li>
                <li><a class="dropdown-item" href="#">LARGE</a></li>
                <li><a class="dropdown-item" href="#">EXTRA LARGE</a></li>
            </ul>
            <span class="dropdown-toggle me-5" data-bs-toggle="dropdown">
                PATTERN
            </span>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">STRIPE</a></li>
                <li><a class="dropdown-item" href="#">CHECKS</a></li>
                <li><a class="dropdown-item" href="#">LINE</a></li>
            </ul>
            <span class="dropdown-toggle me-5" data-bs-toggle="dropdown">
                COLOR
            </span>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">BLACK</a></li>
                <li><a class="dropdown-item" href="#">RED</a></li>
                <li><a class="dropdown-item" href="#">BLUE</a></li>
                <li><a class="dropdown-item" href="#">GREEN</a></li>
                <li><a class="dropdown-item" href="#">YELLOW</a></li>
                <li><a class="dropdown-item" href="#">PINK</a></li>
            </ul>
            <span class="dropdown-toggle me-5" data-bs-toggle="dropdown">
                NECK
            </span>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">ROUND</a></li>
                <li><a class="dropdown-item" href="#">V</a></li>
                <li><a class="dropdown-item" href="#">DEEP</a></li>
            </ul>
            <span class="float-end">{{ $products->count() }} ITEMS</span>
        </div>
    </div>
    <div class="row mt-5 mb-5">
        @if($products->count() > 0 )
            @foreach ($products as $product)
                <div class="col-md-3">
                    <div class="card shadow rounded mb-5">
                        <a href="{{ route('products.show',$product->slug) }}">
                            <img class="card-img-top small-banner" src="{{ asset($product->images->first()->image_path) }}" alt="Card image">
                        </a>
                        <div class="card-body">
                            <span class="ps-4 fs-5"><b>{{ ucfirst($product->brand)  }}</b></span>
                            <i class="bi  @if(in_array($product->id, $productIds)) bi-heart-fill text-danger @else bi-heart  @endif  fs-4 me-4 float-end add-to-wishlist" data-route="{{ route('wishlist.add-remove-wishlist', $product->id) }}"></i>
                            <span class="ps-4 fs-6 d-block"> <a href="{{ route('products.show',$product->slug) }}" class="text-decoration-none">{{ ucfirst($product->title) }}</a></span>
                            {{-- <form class="d-inline float-end" action="{{ route('cart.store')}}" method="post">
                                @csrf
                                <input type="hidden" value="{{ $product->slug }}" name="slug">
                                <input type="hidden" name="already_exist" value="{{ in_array($product->slug, $addItems) ? '1' : '0' }}">
                                <button type="submit">
                                    <i class="bi fs-4 me-4 float-end @if(in_array($product->slug, $addItems)) bi-bag-check-fill @else bi-bag @endif" ></i>
                                </button>
                            </form> --}}
                            <span class="ps-4 fs-6 d-block"><strike>{{ $product->price}}</strike><span class="text-danger ms-2">{{ $product->discount}}% OFF</span></span>
                            @php $discountedPrice = $product->price - ($product->price * ($product->discount / 100));@endphp
                            <span class="ps-4 fs-5"><b>RS. {{ $discountedPrice }}</b></span>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <p class="ms-md-5 fs-md-3 text-center text-md-start">There Are No Product under this category</p>
        @endif
    </div>
</div>
@endsection
