@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row mt-5 mb-2">
        <div class="col-md-12">
            <h3 class="ps-4"><b>Checkout</b></h3>
        </div>
    </div>
    <form method="POST" id="checkoutForm" action="{{ route('order.store')}}">
        <div class="row justify-content-center mt-5 mb-5">
            <div class="col-12 col-md-8 mb-3">
                @csrf
                @php
                    $name = explode(' ', auth()->user()?->name);
                @endphp
                <div class="card">
                    <div class="card-header bg-light">Basic Details</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-6 p-3">
                                <div class="form-group">
                                    <label>First name</label>
                                    <input name="first_name" type="text"
                                        class="form-control @error('first_name') is-invalid @enderror"
                                        value="{{ old('first_name', $name[0] ?? '') }}">
                                    @error('first_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6 p-3">
                                <div class="form-group">
                                    <label>Last name</label>
                                    <input name="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror"
                                        value="{{ old('last_name', $name[1] ?? '') }}">
                                    @error('last_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6 p-3">
                                <label>Mobile</label>
                                <input type="text" class="form-control @error('mobile') is-invalid @enderror" name="mobile"
                                    value="{{ old('mobile',auth()->user()->number ?? '') }}">
                                @error('mobile')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6 p-3">
                                <label>Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                                    value="{{ old('email', auth()->user()->email ?? '') }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-12 p-3">
                                <label>Address (House no, building, street, area)</label>
                                <input type="text" class="form-control @error('address') is-invalid @enderror" name="address"
                                    value="{{ auth()->user()->defaultAddress?->address }}">
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6 p-3">
                                <label>Pin code</label>
                                <input type="text" class="form-control @error('pincode') is-invalid @enderror" name="pincode"
                                    value="{{ auth()->user()->defaultAddress?->pincode }}">
                                @error('pincode')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6 p-3">
                                <label>Locality / Town</label>
                                <input type="text" class="form-control @error('locality') is-invalid @enderror" name="locality"
                                    value="{{ auth()->user()->defaultAddress?->locality }}">
                                @error('locality')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6 p-3">
                                <label>City / district</label>
                                <input type="text" class="form-control @error('city') is-invalid @enderror" name="city"
                                    value="{{ auth()->user()->defaultAddress?->city }}">
                                @error('city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6 p-3">
                                <label>State</label>
                                <input type="text" class="form-control @error('state') is-invalid @enderror" name="state"
                                    value="{{ auth()->user()->defaultAddress?->state }}">
                                @error('state')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="card">
                    <div class="card-header bg-light">
                        Order Details
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-bordered">
                            <tr>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Quantity</th>
                            </tr>
                            @foreach ($cartItems as $item)
                                <tr>
                                    <td>{{ $item->name }}({{ $item->options?->size }})</td>
                                    <td>{{ $item->price }}</td>
                                    <td>{{ $item->qty }}</td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="3" class="text-center">Other Charges</td>
                            </tr>
                            @if ($appliedCoupons->count())
                                <tr>
                                    <td>Coupon Discount</td>
                                    <td></td>
                                    <td>{{ $totalCouponDiscounts }}</td>
                                </tr>
                            @endif
                            
                            <tr>
                                <td>Platform Fee</td>
                                <td></td>
                                <td>{{ env('PLATFORM_FEE') }}</td>
                            </tr>
                            <tr>
                                <td>Total Amount</td>
                                <td></td>
                                <td>{{ $totalPrice}}</td>
                            </tr>
                        </table>
                        <span class="text-success">You saved Rs.{{$totalStrikedPrice - $totalPrice}} on this order</span>
                        <div class="mb-3">
                            <label for="paymentMethod" class="form-label">Select Payment Method</label>
                            <select class="form-control" id="paymentMethod" name="payment_method" required>
                                <option value="cod" data-target="#codFields">Cash on Delivery (COD)</option>
                                <option value="phone_pe" data-target="#PhonePay">Pay online (UPI, Card, netbanking)</option>
                            </select>
                        </div>
        
                        <div id="codFields" class="payment-fields">
                            <p>Cash on Delivery will be available</p>
                        </div>
                        
                        <div class="col-12 text-center mt-5">
                            <button class="btn btn-primary">Proceed</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
