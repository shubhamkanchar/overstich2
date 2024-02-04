@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row mt-5 mb-2">
        <div class="col-md-6">
            <h3><b>Addresses</b></h3>
        </div>
        <div class="col-md-6 text-end">
            <a class="btn btn-dark" href="{{ route('addresses.create') }}">Add</a>
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
                    <form class="d-inline" method="POST" action="{{ route('addresses.destroy',$address->uuid) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" title="Edit Address" class="btn btn-danger float-end m-1"><i class="bi bi-trash3-fill"></i></button>
                    </form>
                    <a title="Edit Address" href="{{ route('addresses.edit',$address->uuid) }}" class="btn btn-success float-end m-1"><i class="bi bi-pencil-square"></i></a>
                    </a>
                </div>
                <div class="card-body fs-6">
                    {{ $address->address }}<br>
                    {{ $address->locality }}<br>
                    {{ $address->city }}, {{ $address->state }} {{ $address->pincode }}<br>
                    India<br>
                    Pin Code: {{ $address->pincode }} 
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
