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
        <div class="row mt-5 mb-5 justify-content-end row-gap-5 gap-2 cart-contents">
            <div class="col-12 col-md-8 bag-items">
                @if (count($cartItems) == 0)
                    <h1 class="fw-bold ms-md-4 text-center text-md-start"> Bag</h1>
                    <p class="ms-md-5 fs-md-3 text-center text-md-start">There Are No items in Bag</p>
                @else
                    <h1 class="fw-bold ms-md-4 text-center text-md-start"> Bag - {{ count($cartItems) }} items</h1>
                    <div class="card mt-4 bg-none border-0">
                        @foreach ($cartItems as $key => $item)
                            @php $product = $products[$item->id]; @endphp
                            @php $productSize = $product?->sizes?->where('size', $item->options?->size)->first() @endphp
                            @php $quantity = $productSize?->quantity @endphp
                            
                            <div class="card-body cart-items shadow-lg m-2 rounded-lg border border-2 @if ($quantity <= 0) bg-gray @else bg-light @endif">
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
                                        <form action="{{ route('cart.update') }}" class="cart-remove-form d-inline" method="POST">
                                            @csrf
                                            <input type="hidden" value="{{ $key }}" name="id">
                                            <input type="hidden" name="quantity" value="0"/>
                                            <button type="submit" class="border-0 fs-3" data-mdb-toggle="tooltip" title="Remove item"> 
                                                <i class="bi bi-trash text-danger"></i>
                                            </button>
                                        </form>
                                        
                                        <i class="bi  @if(in_array($product->id, $productIds)) bi-heart-fill text-danger @else bi-heart  @endif  fs-3 me-4 add-to-wishlist" data-add-route="{{ route('wishlist.add-wishlist', $product->id) }}" data-remove-route="{{ route('wishlist.remove-wishlist', $product->id) }}"></i>
                                    </div>
            
                                    <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
                                        <form class="cart-update-form d-flex my-4" action="{{ route('cart.update') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $key}}">
                                            <button type="submit" class="border-0 fs-3 text-center mb-2 me-1" style="width: 40px; height: 40px; border-radius: 50%"
                                                onclick="this.parentNode.querySelector('input[type=number]').stepDown()">
                                                <i class="bi bi-dash"></i>
                                            </button>
            
                                            <div class="form-outline">
                                                <input type="number" name="quantity" min="1" max="{{ $quantity}}" value="{{ $item->qty }}" type="number" class="form-control text-center" style="width: 50px; height: 40px;" />
                                            </div>
            
                                            <button type="submit" class="border-0 fs-3 text-center mb-2 me-1" style="width: 40px; height: 40px; border-radius: 50%"
                                                onclick="this.parentNode.querySelector('input[type=number]').stepUp()">
                                                <i class="bi bi-plus"></i>
                                            </button>
                                        </form>
                                        <p class="text-start text-md-center">
                                            <strong> ₹<span id="itemPrice-{{$item->id}}"> {{ number_format(($item->price * $item->qty), 2) }} </span></strong>
                                        </p>
                                        @if ($quantity <= 0)
                                            <span class="ps-4 fs-5 mt-3 d-block">Product Not Available</span>
                                        @elseif ($item->qty > $quantity)
                                            <span class="ps-4 fs-5 mt-3 d-block">Only {{ $quantity }} quantity is left</span>
                                        @endif
            
                                        @if ($quantity <= 10 and !($item->qty > $quantity))
                                            <span class="ps-4 text-danger fs-5 mt-3 d-block text-nowrap">!Hurry Only {{ $quantity }} quantity is left</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            
            </div>
            <div class="col-12 col-md-3 px-4">
                @php $cartCount = count($cartItems);  @endphp

                <h2 class="fw-bold">Summary</h2>
                <div class="d-flex justify-content-between">
                    <span>Subtotal</span>
                    <span id="subTotal"><i class="bi bi-currency-rupee"></i>{{ $cartCount > 0 ? $totalOriginalPrice : '0' }}</span>
                </div>
                <div class="d-flex justify-content-between">
                    <span>Delivery Charges</span>
                    <span id="deliveryCharges"><i class="bi bi-currency-rupee"></i>{{ $cartCount > 0 ? $deliveryCharges : '0' }}</span>
                </div>
                <div class="d-flex justify-content-between">
                    <span>Discount</span>
                    <span id="totalDiscount"><i class="bi bi-currency-rupee"></i>{{ $cartCount > 0 ? $totalDiscount : '0' }}</span>
                </div>
                <div class="d-flex justify-content-between">
                    <span>Platform fee</span>
                    <span id="totalDiscount"><i class="bi bi-currency-rupee"></i>{{ env('PLATFORM_FEE') }}</span>
                </div>
                <hr>
                <div class="d-flex justify-content-between">
                    <span>Total</span>
                    <span id="totalAmount"> <i class="bi bi-currency-rupee"></i>{{ $cartCount > 0 ? $totalOriginalPrice - $totalDiscount + $deliveryCharges + env('PLATFORM_FEE') : '0' }}</span>
                </div>
                <hr>
                <form action="{{ route('checkout') }}" class="d-inline" method="get">
                    <input type="submit" value="Place Order" class="bg-dark text-white px-3 py-1 mt-md-4 rounded-5">
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="module">
        $(function() {

            let debounceTimer;

            $(document).on('submit', '.cart-update-form', function(event) {
                event.preventDefault();
                let data = $(this).serialize();
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(function() {
                    updateQuantity(data);
                }, 500); 
            });

            $(document).on('submit','.cart-remove-form', function(event) {
                event.preventDefault();
                let data = $(this).serialize();
                let cardBody = $(this).closest('.card-body');
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'This item will removed from the cart',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, cancel',
                }).then((result) => {
                    
                    if (result.isConfirmed) { 
                        updateQuantity(data);
                        cardBody.remove();
                        if($('.cart-items').length == 0) {
                            $('.bag-items').html('<h1 class="fw-bold ms-md-4 text-center text-md-start"> Bag</h1>' +
                            '<p class="ms-md-5 fs-md-3 text-center text-md-start">There Are No items in Bag</p>');
                        }
                    }
                    
                });
                
            })
        })

        function updateQuantity(data) {
            $.ajax({
                method:"post",
                url: "{{ route('cart.update')}}",
                data: data,
                beforeSend: () => {
                    $('#popup-overlay').removeClass('d-none')
                    $('.spinner').removeClass('d-none')
                },
                success: (res) => {
                    let item = res.updatedItem;
                    $('#totalDiscount').html('<i class="bi bi-currency-rupee"></i>'+res.totalDiscount == 0 ? '0' : '<i class="bi bi-currency-rupee"></i>'+res.totalDiscount);
                    $('#deliveryCharges').html('<i class="bi bi-currency-rupee"></i>'+res.deliveryCharges == 0 ? '0' : '<i class="bi bi-currency-rupee"></i>'+res.deliveryCharges);
                    $('#totalAmount').html((res.totalOriginalPrice - res.totalDiscount + res.deliveryCharges + res.platformFee) == 0 ? '0' : '<i class="bi bi-currency-rupee"></i>'+(res.totalOriginalPrice - res.totalDiscount + res.deliveryCharges + res.platformFee));
                    $('#subTotal').html(res.totalOriginalPrice == 0 ? '0' : '<i class="bi bi-currency-rupee"></i>'+res.totalOriginalPrice);
                    if(item) {
                        $('#itemPrice-'+ item.id).html((item.price * item.qty));
                    }
                    
                },
                error: (err) => {
                    
                },
                complete: () => {
                    $('#popup-overlay').addClass('d-none')
                    $('.spinner').addClass('d-none')
                }
            });
        }

    </script>
@endsection