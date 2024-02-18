@extends('layouts.app')
@section('content')
<div class="container">
    <form method="POST" id="checkoutForm" action="{{ route('addresses.update',$address->uuid)}}">
        <div class="row justify-content-center mt-5 mb-5">
            <div class="col-12 col-md-8 mb-3">
                @csrf
                @method('PUT')
                <div class="card">
                    <div class="card-header bg-light"><h3><b>Edit Address</b></h3></div>
                    <div class="card-body">
                        <input type="hidden" name="uuid" value="{{ request()->address }}">
                        <div class="row">
                            <div class="col-md-12 p-3">
                                <label>Address (House no, building, street, area)</label>
                                <input type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ $address->address }}">
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-12 col-md-6 p-3">
                                <label>Locality / Town</label>
                                <input type="text" class="form-control @error('locality') is-invalid @enderror" name="locality" value="{{ $address->locality }}">
                                @error('locality')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6 p-3">
                                <label>City / district</label>
                                <input type="text" class="form-control @error('city') is-invalid @enderror" name="city"
                                    value="{{ $address->city }}">
                                @error('city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6 p-3">
                                <label>State</label>
                                <input type="text" class="form-control @error('state') is-invalid @enderror" name="state"
                                    value="{{ $address->state }}">
                                @error('state')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6 p-3">
                                <label>Pin code</label>
                                <input type="text" class="form-control @error('pincode') is-invalid @enderror" name="pincode"
                                    value="{{ $address->pincode }}">
                                @error('pincode')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6 p-3">
                                <label>Phone Number</label>
                                <input type="number" class="form-control @error('phone') is-invalid @enderror" name="phone"
                                    value="{{ $address->phone }}" maxlength="10">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12 mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1" id="defaultAddress" @if($address->default) checked @endif name="default_address">
                                    <label class="form-check-label" for="defaultAddress">
                                        Default Address
                                    </label>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 p-3">
                                <button type="submit" class="btn btn-dark">Update Address</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
