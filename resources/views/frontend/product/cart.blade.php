@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row mt-5 mb-5 justify-content-end row-gap-5 gap-2">
            <div class="col-12 col-md-8">
                {{-- @dd(count($cartItems)) --}}
                @if (count($cartItems) == 0)
                    <h1 class="fw-bold ms-md-4 text-center text-md-start"> Bag</h1>
                    <p class="ms-md-5 fs-md-3 text-center text-md-start">There Are No items in Bag</p>
                @else
                    {{-- <h1 class="fw-bold ms-md-4 text-center text-md-start">Bag</h1>
                    <div class="ms-md-5 text-center text-md-start">
                        @foreach ($cartItems as $item)
                            <div class="d-flex justify-content-between align-items-center mt-3 p-2 items rounded">
                                @php $product = $products[$item->id]; @endphp
                                <div class="d-flex flex-row"><img class="rounded" src="{{ $product?->images?->first()->image_path }}" width="100">
                                    <div class="ms-2"><span class="font-weight-bold d-block">{{ $item->name}}</span></div>
                                </div>
                                <div class="d-flex flex-row align-items-center"><span class="d-block">{{ $item->quantity }}</span><span class="d-block ml-5 font-weight-bold">{{ $item->price}} </span><i class="fa fa-trash-o ml-3 text-black-50"></i></div>
                            </div>
                        @endforeach
                    </div> --}}
                    @foreach ($cartItems as $key => $item)
                        @php $product = $products[$item->id]; @endphp
                        @php $productSize = $product->sizes->where('size', $item->options?->size)->first() @endphp
                        <div class="card mt-4 shadow @if($productSize->quantity <= 0) bg-secondary @else bg-white @endif">
                            <div class="row card-body">
                                <div class="col-6 mt-2">
                                    <img class="small-banner" src="{{ asset($item?->options?->image) }}" width="50" alt="Card image">
                                    <h3>{{ $item->name }}</h3>
                                </div>
                                <div class="col-6 mt-2 text-right">
                                    <p>Update Quantity</p>
                                </div>
                                <div class="col-6 mt-2 ">
                                    <div class="fs-4 d-block">
                                        <strike>RS. {{ $item->options?->original_price }}</strike>
                                        <span class="text-danger ms-2">{{ $item->options?->discount_percentage }}% OFF</span>
                                    </div>
                                    <div class="fs-3 d-block"><b>RS. {{ $item->price }}</b></div>                                    
                                </div>
                                <div class="col-6 mt-2 text-right">
                                    <form class="text-right" action="{{ route('cart.update') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $key}}">
                                        <input type="number" name="quantity" min="0" max="{{ $productSize->quantity}}" value="{{ $item->qty }}" class="w-2 text-center border-2 bg-gray-300" style="width:50px" />
                                        @if ($productSize->quantity <= 0)
                                            <span class="ps-4 fs-4 mt-3 d-block">Product Not Available</span>
                                        @elseif ($item->qty > $productSize->quantity)
                                            <span class="ps-4 fs-4 mt-3 d-block">Only {{ $productSize->quantity }} quantity is left</span>
                                        @endif
                                        <button type="submit" class="btn btn-primary btn-sm" style="margin-top: -5px;">update</button>
                                    </form>
                                </div>
                                <div class="col-10 d-flex mt-2">
                                    <form action="{{ route('cart.update') }}" method="POST">
                                        @csrf
                                        <input type="hidden" value="{{ $key }}" name="id">
                                        <input type="hidden" name="quantity" value="0"/>
                                        <button type="submit" class="btn btn-danger btn-sm mb-2">Remove</button>
                                    </form>
                                    {{-- <form action="{{ route('favorite.move', $item->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm ml-2">Move to Wishlist</button>
                                    </form> --}}
                                </div>
                                <div class="col-2 mt-2 text-right">
                                    <p><strong>Size</strong>
                                        <span class="dot text-center">{{ $item->options?->size ?? ''}}</span>
                                    </p>
                                </div>
                            </div>  
                        </div>
                    @endforeach
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
                    <span>{{ count($cartItems) > 0 ? $totalDiscount : '-'}}</span>
                </div>
                <hr>
                <div class="d-flex justify-content-between">
                    <span>Total</span>
                    <span> {{ count($cartItems) > 0 ? ($totalOriginalPrice - $totalDiscount + $deliveryCharges) : '-' }}</span>
                </div>
                <hr>
                <form action="{{ route('checkout')}}" class="d-inline" method="get">
                    <input type="submit" value="Place Order" class="bg-dark text-white px-3 py-1 mt-md-4 rounded-5">
                </form>
            </div>
        </div>
    </div>
@endsection