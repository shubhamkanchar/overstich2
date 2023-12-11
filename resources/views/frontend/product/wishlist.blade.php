@extends('layouts.app')
@push('styles')

@endpush
@section('content')
    <div class="container">
        <div class="row mt-5 mb-5 justify-content-end row-gap-5 gap-2">
            <div class="col-12">
                @if (count($products) == 0)
                    <h1 class="fw-bold ms-md-4 text-center text-md-start">Wishlist</h1>
                    <p class="ms-md-5 fs-md-3 text-center text-md-start">There Are No item in Wishlist</p>
                @else
                    @if (request()->route()->getName() == 'wishlist.index')
                        <h1 class="fw-bold ms-md-4 text-center text-md-start">Wishlist</h1>
                    @endif
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
                @endif
            </div>
        </div>   
    </div>
@endsection
