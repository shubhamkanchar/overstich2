@extends('backend.seller.layouts.app')

@section('content')
    <div class="grey-bg container seller-product">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-header">Update Warehouse</div>
                        <form id="warehouseForm" method="POST" action="{{ route('seller.warehouses.update',$warehouse->id) }}">
                            <div class="card-body">
                                @csrf
                                @method('PUT')
                                <div class="form-group row">
                                    <div class="col-12 col-md-4 mb-3">
                                        <label for="name" class="form-label">Warehouse Name</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            placeholder="Warehouse Name" id="name" name="name" required value="{{ $warehouse->name }}">
                                        @error('name')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-12 col-md-4 mb-3">
                                        <label for="mobile" class="form-label">Mobile Number</label>
                                        <input type="text" class="form-control @error('mobile') is-invalid @enderror"
                                            placeholder="Mobile Number"  id="mobile" name="mobile"
                                            value="{{ $warehouse->mobile }}">
                                        @error('mobile')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-12 col-md-4 mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="text" class="form-control @error('email') is-invalid @enderror"
                                            placeholder="Email" id="email" name="email" value="{{ $warehouse->email }}">
                                        @error('email')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-12 col-md-4 mb-3">
                                        <label for="address" class="form-label">Address</label>
                                        <input type="text" step="0.01" placeholder="Address"
                                            class="form-control @error('address') is-invalid @enderror" id="address"
                                            name="address" value="{{ $warehouse->address }}" required>
                                        @error('address')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-12 col-md-4 mb-3">
                                        <label for="pincode" class="form-label">Pincode</label>
                                        <input type="number" placeholder="123456"
                                            class="form-control @error('pincode') is-invalid @enderror" id="pincode"
                                            name="pincode" value="{{ $warehouse->pincode }}">
                                        @error('pincode')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-12 col-md-4 mb-3">
                                        <label for="city" class="form-label">City</label>
                                        <input type="text" placeholder="City"
                                            class="form-control @error('city') is-invalid @enderror" id="city"
                                            name="city" value="{{ $warehouse->city }}">
                                        @error('city')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-12 col-md-4 mb-3">
                                        <label for="state" class="form-label">State</label>
                                        <input type="text" placeholder="State"
                                            class="form-control @error('state') is-invalid @enderror" id="state"
                                            name="state" value="{{ $warehouse->state }}">
                                        @error('state')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-12 col-md-4 mb-3">
                                        <label for="country" class="form-label">Country</label>
                                        <input type="text" placeholder="Country"
                                            class="form-control @error('country') is-invalid @enderror" id="country"
                                            name="country" value="{{ $warehouse->country }}">
                                        @error('country')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-12 mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="1" id="defaultAddress" @if($warehouse->default == 1) checked @endif name="default_address">
                                            <label class="form-check-label" for="defaultAddress">
                                                Default Warehouse
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-12 mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="1" id="returnAddress" checked name="return_check">
                                            <label class="form-check-label" for="returnAddress">
                                                Return address is the same as Pickup Address
                                            </label>
                                        </div>
                                    </div>
                                    
                                    <div class="col-12 return-stage d-none col-md-4 mb-3">
                                        <label for="return_address" class="form-label">Return Address</label>
                                        <input type="text" step="0.01" placeholder="Return Address"
                                            class="form-control return-input @error('return_address') is-invalid @enderror" id="return_address"
                                            name="return_address" value="{{ $warehouse->return_address }}" >
                                        @error('return_address')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-12 return-stage d-none col-md-4 mb-3">
                                        <label for="return_pincode" class="form-label">Return Pincode</label>
                                        <input type="number" placeholder="123456"
                                            class="form-control return-input @error('return_pincode') is-invalid @enderror" id="return_pincode"
                                            name="return_pincode" value="{{ $warehouse->return_pincode }}">
                                        @error('return_pincode')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-12 return-stage d-none col-md-4 mb-3">
                                        <label for="return_city" class="form-label">Return City</label>
                                        <input type="text" placeholder="Return City"
                                            class="form-control return-input @error('return_city') is-invalid @enderror" id="return_city"
                                            name="return_city" value="{{ $warehouse->return_city }}">
                                        @error('return_city')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-12 return-stage d-none col-md-4 mb-3">
                                        <label for="return_state" class="form-label">Return State</label>
                                        <input type="text" placeholder="Return State"
                                            class="form-control return-input @error('return_state') is-invalid @enderror" id="return_state"
                                            name="return_state" value="{{ $warehouse->return_state }}">
                                        @error('return_state')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-12 return-stage d-none col-md-4 mb-3">
                                        <label for="return_country" class="form-label">Return Country</label>
                                        <input type="text" placeholder="Return Country"
                                            class="form-control return-input @error('return_country') is-invalid @enderror" id="return_country"
                                            name="return_country" value="{{ $warehouse->return_country }}">
                                        @error('return_country')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-success">Update Warehouse</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
