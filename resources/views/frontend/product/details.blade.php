@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row mt-5 mb-5 justify-content-center">
        <div class="col-lg-4 col-md-6 pb-5">
            <div class="row">
                @foreach ($product->images as $image)
                    <div class="col-md-6">
                        <img class="pb-4" width="100%" src="{{ asset($image->image_path) }}">
                    </div>
                @endforeach
                <div class="col-md-12">
                    <p>SELLER INFORMATION :-</p>
                    <span class="d-block"><b>BRAND :-</b> {{ $product->brand }}</span>
                    <span class="d-block"><b>LEGAL NAME :-</b> {{ $seller->name }}</span>
                    @if ($sellerInfo)
                        <span class="d-block"><b>ADDRESS :-</b> {{ $sellerInfo->address }},</span>
                        <span class="d-block"><b>LOCALITY :-</b> {{ $sellerInfo->locality }},</span>
                        <span class="d-block"><b>CITY :-</b> {{ $sellerInfo->city }},</span>
                        <span class="d-block"><b>STATE :-</b> {{ $sellerInfo->state }},</span>
                        <span class="d-block"><b>PINCODE :-</b> {{ $sellerInfo->pincode }}</span>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 pb-5">
            <div class="ps-4 fs-3"><b>{{ $product->brand }}</b></div>
            <i class="bi bi-heart fs-2 me-4 float-end"></i>
            <div class="ps-4 fs-4 d-block">{{ $product->title }}</div>
            <div class="ps-4 fs-4 d-block">
                <strike>RS. {{ $product->price }}</strike>
                <span class="text-danger ms-2">{{ $product->discount }}% OFF</span>
            </div>
            @php $discountedPrice = $product->price - ($product->price * ($product->discount / 100));@endphp
            <div class="ps-4 fs-3 d-block"><b>RS. {{ $discountedPrice }}</b></div>
            {{-- <div class="ps-4 fs-3 mt-3 d-block"><b>Sizes</b></div> --}}
            <span class="ps-4 fs-3 mt-3 d-block">Sizes Chart</span>
            <form class="d-inline" action="{{ route('cart.store')}}" method="post">
                @csrf
                <input type="hidden" value="{{ $product->slug }}" name="slug">
                {{-- <input type="hidden" name="already_exist" value="{{ in_array($product->slug, $addItems) ? '1' : '0' }}"> --}}
                <div class="p-2">
                    @php $totalQuantity = 0; $checkFirst = true; @endphp
                    @foreach ($product->sizes as $size)
                        @if($size->quantity > 0)
                            {{-- <div class="form-check form-check-inline"> --}}
                                <input class="d-none hidden" type="radio" name="size" id="size{{ $loop->index }}" value="{{ $size->size }}" @checked($checkFirst)>
                                <button type="button" class="border-2 btn border @if ($checkFirst) border-2 border-black @endif m-2 py-2 px-4 size-label" for="size{{ $loop->index }}">{{ $size->size }}</button>
                                @php $checkFirst = false; @endphp
                            {{-- </div> --}}
                        @else
                            <button class="disabled border-1 btn border m-2 py-2 px-4">{{ $size->size }}</button>
                        @endif
                        @php $totalQuantity += $size->quantity; @endphp
                    @endforeach
                    
                </div>
                {{-- <span class="ps-4 fs-3 mt-3 d-block">Sizes Chart</span> --}}
                @if ($totalQuantity <= 0)
                    <span class="ps-4 fs-4 mt-3 d-block">Product not available now</span>
                @endif
                <button class="ms-4 fs-3 mt-5 mb-5 btn btn-dark" style="width:85%" @disabled($totalQuantity <= 0)><i class="bi bi-bag me-1"></i>Add</button>
            </form>
            <ul class="ms-4">
                <li>Standart Delivery in 5 - 9 days</li>
                <li>Return/Exchange Available for 7 days</li>
            </ul>
            <span class="ps-4 fs-4 mt-3 d-block">DELIVERY CHECK</span>
            <input class="ms-4 mt-4 w-50" type="text">
            <a class="text-danger ms-2">CHECK</a>
            <span class="ps-4 fs-4 mt-3 d-block">PRODUCT DETAILS</span>
            <ul class="ms-4">
                <li>Colour : {{ $product->color }}</li>
                <li>Round neck</li>
                <li>Slim fit</li>
                <li>Material : Cotton</li>
                <li>Sleeveless</li>
            </ul>
            <span class="ps-4 fs-4 mt-3 d-block">RATINGS</span>
            <h1 class="ps-4 mt-3 d-block">4.2 <i class="bi bi-star-fill ms-2"></i></h1>
            <ul class="ms-4">
                <li>102 BUYERS RATING</li>
            </ul>
            <label class="mt-3 ms-4">FIT</label>
            <div class="progress ms-4" style="height:10px">
                <div class="progress-bar bg-success" role="progressbar" style="width: 75%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <label class="mt-3 ms-4">TRANSPARENCY</label>
            <div class="progress ms-4" style="height:10px">
                <div class="progress-bar bg-danger" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <label class="mt-3 ms-4">LENGTH</label>
            <div class="progress ms-4" style="height:10px">
                <div class="progress-bar bg-primary" role="progressbar" style="width: 50%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <span class="ps-4 fs-4 mt-4 d-block">REVIEWS</span>
            <div class="ratings ps-4 mt-3">
                <span class="p-2 bg-primary" style="border-radius: 5px;"><b>5</b> <i class="bi bi-star-fill text-white"></i></span>
                <span>The material is pure cotton. Very comfortable to wear and looks beautiful❤</span>
            </div>
            
        </div>
    </div>
</div>
@endsection