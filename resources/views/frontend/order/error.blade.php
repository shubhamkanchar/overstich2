@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row mt-5 mb-2 ">
        <div class="col-md-12 text-center justify-content-center">
            <h1 class="text-danger"><b>Sorry Payment Failed!</b></h1>
            <img class="mx-auto d-block w-25" src="{{ asset('loader/error.gif') }}">
            <h3 class="text-danger">Your order payment is please try again</h3>
            <a href="{{ route('welcome') }}" class="btn btn-dark m-3">Go to Home</a>
            <a href="{{ route('order.my-order') }}" class="btn btn-dark m-3">Go to Orders</a>
        </div>
    </div>
</div>
@endsection
