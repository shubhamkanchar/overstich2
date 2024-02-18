@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row mt-5 mb-2">
        <div class="col-md-6">
            <h3><b>Addresses</b></h3>
        </div>
        <div class="col-md-6 text-end">
            <a class="btn btn-dark" href="{{ route('addresses.create', ['change_address' => 1 ]) }}">Add</a>
        </div>
    </div>
    <div class="row mt-4 mb-5">
        @foreach($addresses as $address)
        <div class="col-12 col-md-6 col-lg-4 mb-3">
            <div class="card shadow">
                <div class="card-header">
                    @if($address->default)
                        <span class="badge bg-primary fs-6 mt-2">Default</span>
                    @endif
                    <a title="Edit Address" href="{{ route('checkout', ['address' => $address->id ]) }}" class="btn btn-success float-end m-1">Deliver Here</a>
                    </a>
                </div>
                <div class="card-body fs-6">
                    {{ $address->address }}<br>
                    {{ $address->locality }}<br>
                    {{ $address->city }}, {{ $address->state }} {{ $address->pincode }}<br>
                    India<br>
                    Pin Code: {{ $address->pincode }}<br>
                    Phone Number: {{ $address->phone }}
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
