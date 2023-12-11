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
        .bg-gray {
            background-color: rgb(220, 219, 219); 
        }
    </style>
@endpush
@section('content')
    <div class="container">
        <div class="row mt-5 mb-5 justify-content-end row-gap-5 gap-2">
            <div class="col-12 col-md-8">
                @if (count($cartItems) == 0)
                    <h1 class="fw-bold ms-md-4 text-center text-md-start"> Bag</h1>
                    <p class="ms-md-5 fs-md-3 text-center text-md-start">There Are No items in Bag</p>
                @else
                    <h1 class="fw-bold ms-md-4 text-center text-md-start"> Bag - {{ count($cartItems) }} items</h1>
                    <div class="card mt-4 bg-none border-0">
                        @foreach ($cartItems as $key => $item)
                            @php $product = $products[$item->id]; @endphp
                            @php $productSize = $product->sizes->where('size', $item->options?->size)->first() @endphp
                            
                            <div class="card-body shadow-lg m-2 rounded-lg border border-2 @if ($productSize->quantity <= 0) bg-gray @else bg-light @endif">
                                <div class="row">
                                    <div class="col-lg-3 col-md-12 mb-4 mb-lg-0">
                                        <!-- Image -->
                                        <div class="bg-image hover-overlay hover-zoom ripple rounded"
                                            data-mdb-ripple-color="light">
                                            <img src="{{ asset($item?->options?->image) }}"
                                                class="w-100" alt="Blue Jeans Jacket" style="height: 150px"/>
                                            <a href="#!">
                                                <div class="mask" style="background-color: rgba(251, 251, 251, 0.2)"></div>
                                            </a>
                                        </div>
                                        <!-- Image -->
                                    </div>

                                    <div class="col-lg-5 col-md-6 mb-4 mb-lg-0">
                                        <!-- Data -->
                                        <p><strong>{{ $item->name }}</strong></p>
                                        @if (!empty($product->color))
                                            <p>Color: {{ $product->color}}</p>
                                        @endif
                                        <p>Size: {{ $item->options?->size }}</p>
                                        <form action="{{ route('cart.update') }}" class="d-inline" method="POST">
                                            @csrf
                                            <input type="hidden" value="{{ $key }}" name="id">
                                            <input type="hidden" name="quantity" value="0"/>
                                            <button type="submit" class="border-0 fs-3" data-mdb-toggle="tooltip" title="Remove item"> 
                                                <i class="bi bi-trash text-danger"></i>
                                            </button>
                                        </form>
                                        <button type="button" class="border-0 fs-3" data-mdb-toggle="tooltip"
                                            title="Move to the wish list">
                                            <i class="bi bi-heart"></i>
                                        </button>
                                    </div>

                                    <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
                                        <form class="d-flex my-4" action="{{ route('cart.update') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $key}}">
                                            <button class="border-0 fs-3 text-center mb-2 me-1" style="width: 40px; height: 40px; border-radius: 50%"
                                                onclick="this.parentNode.querySelector('input[type=number]').stepDown()">
                                                <i class="bi bi-dash"></i>
                                            </button>

                                            <div class="form-outline">
                                                <input type="number" name="quantity" min="0" max="{{ $productSize->quantity}}" value="{{ $item->qty }}" type="number" class="form-control text-center" style="width: 50px; height: 40px;" />
                                            </div>

                                            <button class="border-0 fs-3 text-center mb-2 me-1" style="width: 40px; height: 40px; border-radius: 50%"
                                                onclick="this.parentNode.querySelector('input[type=number]').stepUp()">
                                                <i class="bi bi-plus"></i>
                                            </button>
                                        </form>
                                        <p class="text-start text-md-center">
                                            <strong>{{ number_format(($item->price * $item->qty), 2) }} rs.</strong>
                                        </p>
                                        @if ($productSize->quantity <= 0)
                                            <span class="ps-4 fs-5 mt-3 d-block">Product Not Available</span>
                                        @elseif ($item->qty > $productSize->quantity)
                                            <span class="ps-4 fs-5 mt-3 d-block">Only {{ $productSize->quantity }} quantity is left</span>
                                        @endif

                                        @if ($productSize->quantity <= 10 and !($item->qty > $productSize->quantity))
                                            <span class="ps-4 text-danger fs-5 mt-3 d-block text-nowrap">!Hurry Only {{ $productSize->quantity }} quantity is left</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

            </div>
            <div class="col-12 col-md-3 px-4">
                <h2 class="fw-bold">Summary</h2>
                <div class="d-flex justify-content-between">
                    <span>Subtotal</span>
                    <span>{{ count($cartItems) > 0 ? $totalOriginalPrice : '-' }}</span>
                </div>
                <div class="d-flex justify-content-between">
                    <span>Delivery Charges</span>
                    <span>{{ count($cartItems) > 0 ? $deliveryCharges : '-' }}</span>
                </div>
                <div class="d-flex justify-content-between">
                    <span>Discount</span>
                    <span>{{ count($cartItems) > 0 ? $totalDiscount : '-' }}</span>
                </div>
                <hr>
                <div class="d-flex justify-content-between">
                    <span>Total</span>
                    <span>
                        {{ count($cartItems) > 0 ? $totalOriginalPrice - $totalDiscount + $deliveryCharges : '-' }}</span>
                </div>
                <hr>
                <form action="{{ route('checkout') }}" class="d-inline" method="get">
                    <input type="submit" value="Place Order" class="bg-dark text-white px-3 py-1 mt-md-4 rounded-5">
                </form>
            </div>
        </div>
    </div>
@endsection
