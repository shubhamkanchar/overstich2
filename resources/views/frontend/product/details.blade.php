@extends('layouts.app')
@push('styles')
    <style>
        input[type=number]::-webkit-inner-spin-button, 
        input[type=number]::-webkit-outer-spin-button { 
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            margin: 0; 
        }
        #fullPage {
            display: none;
            position: absolute;
            z-index: 9999;
            top: 90px;
            left: 0;
            width: 100vw;
            height: 100vh;
            background-size: contain;
            background-repeat: no-repeat no-repeat;
            background-position: center center;
            background-color: black;
        }
        .bg-gray {
            background-color: rgb(220, 219, 219); 
        }

        @media (max-width: 575.98px) {
            .image-height {
                height: 35vh;
            }

        }
    </style>
@endpush
@section('content')
    <div class="container">
        <div class="row mt-5 mb-5 justify-content-center">
            <div class="col-lg-4 col-md-6">
                <div class="row">
                    @foreach ($product->images as $image)
                        <div class="col-md-6 d-none d-md-block">
                            <img class="pb-4 product-image" width="100%" src="{{ asset($image->image_path) }}">
                        </div> 
                    @endforeach
                    <div id="carouselExample" class="col-12 carousel slide d-block d-md-none" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            @foreach ($product->images as $image)
                                <div class="carousel-item {{ $loop->index == 0 ? 'active' : '' }}" style="max-height: 35vh;">
                                    <img src="{{ asset($image->image_path) }}" class="d-block w-100" style="width: 100%; height: 100%;" alt="...">
                                </div> 
                            @endforeach  
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                        </button>
                    </div>

                    <div class="col-md-12 mt-2">
                        <p>SELLER INFORMATION  <span class="d-md-none d-inline bi bi-info fs-5 seller-info" data-bs-toggle="modal" data-bs-target="#sellerInfoModal"></span> </p>
                        <div class="seller-information d-md-block d-none">
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
            </div>
            <div class="col-lg-4 col-md-6 pb-5">
                <div class="fs-5"><b>{{ $product->brand }}</b></div>
                <!-- <i class="bi @if(in_array($product->id, $productIds)) bi-heart-fill text-danger @else bi-heart  @endif add-to-wishlist fs-2 me-4 float-end" data-add-route="{{ route('wishlist.add-wishlist', $product->id) }}" data-remove-route="{{ route('wishlist.remove-wishlist', $product->id) }}"></i> -->
                <div class="fs-6 d-block">{{ $product->title }}</div>
                <div class="fs-6 d-block">
                    @php $discountedPrice = $product->price - ($product->price * ($product->discount / 100));@endphp
                    <span class="fs-4">
                        <strong><i class="bi bi-currency-rupee"></i>{{ $discountedPrice }}
                        </strong>
                    </span>
                    <small>
                    <strike><i class="bi bi-currency-rupee"></i>{{ $product->price}}</strike>
                    </small>
                    <small class="text-danger">({{ $product->discount}}% OFF)</small>
                </div>
                <div class="fs-6 mt-3 d-block"><b>SELECT SIZE</b>
                @if (!empty($product->size_chart))
                    <span class="ms-2 text-danger" role="button" data-bs-toggle="modal" data-bs-target="#sizeChart">Sizes Chart</span></div>
                @endif
                <form class="d-inline" action="{{ route('cart.store')}}" method="post">
                    @csrf
                    <input type="hidden" value="{{ $product->slug }}" name="slug">
                    {{-- <input type="hidden" name="already_exist" value="{{ in_array($product->slug, $addItems) ? '1' : '0' }}"> --}}
                    <div class="pt-2">
                        @php $totalQuantity = 0; $checkFirst = true; $max = 0; @endphp
                        @foreach ($product->sizes as $size)
                            @if($size->quantity > 0)
                                {{-- <div class="form-check form-check-inline"> --}}
                                    <input class="d-none hidden" type="radio" name="size" id="size{{ $loop->index }}" value="{{ $size->size }}" @checked($checkFirst)>
                                    <button type="button" class="border-2 btn border @if ($checkFirst) border-2 border-black @endif mt-2 me-2 mb-2  py-2 px-4 size-label" data-max="{{$size->quantity}}" for="size{{ $loop->index }}">{{ $size->size }}</button>
                                    @php $checkFirst = false; $max=$size->quantity;  @endphp
                                {{-- </div> --}}
                            @else
                                <button class="disabled border-1 btn border m-2 py-2 px-4">{{ $size->size }}</button>
                            @endif
                                
                            @php $totalQuantity += $size->quantity; @endphp
                        @endforeach
                        <!-- <div class="col-lg-4 col-md-6 my-4 mb-lg-0 d-flex">
                            <button type="button" class="border-0 fs-3 d-inline text-center mb-2 me-1" style="width: 40px; height: 40px; border-radius: 50%"
                                onclick="this.parentNode.querySelector('input[type=number]').stepDown()">
                                <i class="bi bi-dash"></i>
                            </button>

                            <div class="form-outline">
                                <input type="number" name="quantity" min="1" max="{{ $max }}" value="1" type="number" class="form-control text-center" style="width: 50px; height: 40px;" />
                            </div>

                            <button type="button" class="border-0 fs-3 text-center mb-2 me-1" style="width: 40px; height: 40px; border-radius: 50%"
                                onclick="this.parentNode.querySelector('input[type=number]').stepUp();">
                                <i class="bi bi-plus"></i>
                            </button>
                        </div> -->
                    </div>
                    @if ($totalQuantity <= 0)
                        <span class="fs-4 mt-3 d-block">Product not available now</span>
                    @endif
                    <button class="fs-5 mt-2 mb-2 btn btn-dark col-md-6" @disabled($totalQuantity <= 0)><i class="bi bi-bag me-1"></i>ADD TO BAG</button>

                    <button type="button" class="fs-5 mt-2 mb-2 btn col-md-5 " @disabled($totalQuantity <= 0) >
                        <i class="bi @if(in_array($product->id, $productIds)) bi-heart-fill text-danger @else bi-heart  @endif me-1 add-to-wishlist" data-add-route="{{ route('wishlist.add-wishlist', $product->id) }}" data-remove-route="{{ route('wishlist.remove-wishlist', $product->id) }}"></i>WISHLIST
                    </button>
                </form>
                <ul class="p-0 mt-2">
                    <li>Standart Delivery in 5 - 9 days</li>
                    <li>Return/Exchange Available for 7 days</li>
                </ul>
                <span class="fs-4 mt-3 d-block">DELIVERY CHECK</span>
                <form class="d-flex mt-3 row" id="pincodeForm" action="{{ route('pinocde-check') }}">
                    {{-- <div class="row"> --}}
                        <div class="col-md-6">
                            <input class="form-control" placeholder="Pincode" type="text" name="pincode" id="pincode">
                            
                        </div>
                        <div class="col-md-6">
                            <button role="button" type="submit" class="text-danger ms-2 mt-2" id="checkPincode">CHECK</button>
                        </div>
                        <div class="col-md-12">
                        <span class="text-primary" id="pincodeMsg"></span>
                        </div>
                    {{-- </div> --}}
                </form>
                
                <span class="fs-4 mt-3 d-block">PRODUCT DETAILS</span>
                <ul class="ms-4">
                    <li>Colour : {{ $product->color }}</li>
                    <li>Round neck</li>
                    <li>Slim fit</li>
                    <li>Material : Cotton</li>
                    <li>Sleeveless</li>
                </ul>
                <span class="fs-4 mt-3 d-block">RATINGS</span>
                @if ($product->ratings_count)    
                    <h1 class="mt-3 d-block">{{ $averageStarRating ?? '0'}} <i class="bi bi-star-fill ms-2"></i></h1>
                    <ul class="ms-4">
                        <li>{{ $product->ratings_count }} BUYERS RATING</li>
                    </ul>
                    <label class="mt-3 ms-4">FIT</label>
                    <div class="progress ms-4" style="height:10px">
                        <div class="progress-bar @if($averageFitRating < 49) bg-danger @elseif($averageFitRating < 79) bg-primary @else bg-success @endif" role="progressbar" style="width: {{ $averageFitRating ?? '0'}}%" aria-valuenow="{{ $averageFitRating ?? '0'}}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <label class="mt-3 ms-4">TRANSPARENCY</label>
                    <div class="progress ms-4" style="height:10px">
                        <div class="progress-bar @if($averageTransparencyRating < 49) bg-danger @elseif($averageTransparencyRating < 79) bg-primary @else bg-success @endif" role="progressbar" style="width: {{ $averageTransparencyRating ?? '0'}}%" aria-valuenow="{{ $averageTransparencyRating ?? '0'}}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <label class="mt-3 ms-4">LENGTH</label>
                    <div class="progress ms-4" style="height:10px">
                        <div class="progress-bar @if($averageLengthRating < 49) bg-danger @elseif($averageLengthRating < 79) bg-primary @else bg-success @endif" role="progressbar" style="width: {{ $averageLengthRating ?? '0'}}%" aria-valuenow="{{ $averageLengthRating ?? '0'}}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <span class="fs-4 mt-4 d-block">REVIEWS</span>
                    @foreach ($product->ratings as $rating)
                        <div class="ratings mt-3">
                            <div class="d-flex">
                                <div class="d-block mt-2 col-2 fs-6">
                                    <span class="p-2 @if($rating->star <= 2) bg-danger @elseif($rating->star < 4) bg-primary @else bg-success @endif" style="border-radius: 5px;">
                                        <b>{{ $rating->star }}</b> <i class="bi bi-star-fill text-white"></i>
                                    </span>
                                </div>
                                <div class="d-block">
                                    <span>{{ $rating->review }}</span>
                                    @if ($rating->user_id == auth()->id())
                                        <form id="deleteRating" class="d-inline" action="{{ route('rating.destroy', $product->slug) }}" method="post">
                                            @csrf
                                            @method('delete')
                                            <button type="submit"><i class="bi bi-trash text-danger"></i></button>
                                        </form>
                                    @endif
                                    <span class="text-secondary d-block mt-2">{{ ucfirst($rating->user->name)}} | {{ $rating->updated_at->format('d/m/Y')}}</span>
                                </div>
                            </div>
                            <hr>
                            
                        </div>
                    @endforeach
                    
                @else
                    <Span class="fs-4 text-muted">No Ratings & Reviews Found</Span>
                @endif
                
            </div>
        </div>
    </div>
    <div class="modal fade" id="sellerInfoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog d-flex align-items-center">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Seller Information</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="seller-info">
                        <div class="row">
                            <div class="col">
                                <p><strong>Brand:</strong> {{ $product->brand }}</p>
                            </div>
                            <div class="col">
                                <p><strong>Legal Name:</strong> {{ $seller->name }}</p>
                            </div>
                            <div class="col-12">
                                @if ($sellerInfo)
                                    <span><strong>Address:</strong> {{ $sellerInfo->address }},</span>
                                    <span><strong>Locality:</strong> {{ $sellerInfo->locality }},</span>
                                    <span><strong>City:</strong> {{ $sellerInfo->city }},</span>
                                    <span><strong>State:</strong> {{ $sellerInfo->state }},</span>
                                    <span><strong>Pincode:</strong> {{ $sellerInfo->pincode }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="sizeChart" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"> 
        <div class="modal-dialog modal-dialog-centered"> 
            <div class="modal-content"> 
                <div class="modal-header"> 
                    <h5 class="modal-title"> 
                        Size Chart
                    </h5> 
                </div> 
                <div class="modal-body"> 
                    <div class="d-flex justify-content-center">
                        <img src="{{ asset($product->size_chart) }}" style="width: 100%; height: 100%;" alt="" srcset="">
                    </div>
                </div> 
            </div> 
        </div> 
    </div>
  
@endsection
@section('script')
    
@endsection