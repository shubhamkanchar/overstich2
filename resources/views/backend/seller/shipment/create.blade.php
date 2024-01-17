@extends('backend.seller.layouts.app')

@section('content')
<div class="grey-bg container seller-product">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-header">Shipment</div>
                    <form id="shipmentForm" method="GET" action="{{ route('seller.order.shipment',request()->id) }}">
                        <div class="card-body">
                            @csrf 
                            <div class="form-group row">
                                <div class="col-12 col-md-4 mb-3">
                                    <label for="length" class="form-label">Length (CM)</label>
                                    <input type="text" class="form-control @error('length') is-invalid @enderror" placeholder="Length" id="length" name="length" value="{{ old('length') }}" required>
                                    @error('length')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-12 col-md-4 mb-3">
                                    <label for="width" class="form-label">Width (CM)</label>
                                    <input type="text" class="form-control @error('width') is-invalid @enderror" placeholder="Width" id="width" name="width" value="{{ old('width') }}" required>
                                    @error('width')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-12 col-md-4 mb-3">
                                    <label for="height" class="form-label">Height (CM)</label>
                                    <input type="text" class="form-control @error('height') is-invalid @enderror" placeholder="Height" id="height" name="height" value="{{ old('height') }}" required>
                                    @error('height')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-12 col-md-4 mb-3">
                                    <label for="weight" class="form-label">Weight (GM)</label>
                                    <input type="text" class="form-control @error('weight') is-invalid @enderror" placeholder="weight" id="weight" name="weight" value="{{ old('weight') }}" required>
                                    @error('weight')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">                            
                            <button type="submit" class="btn btn-success">Create Shipment</button>
                        </div> 
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
