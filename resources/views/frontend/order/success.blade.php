@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row mt-5 mb-2 ">
        <div class="col-md-12 text-center justify-content-center">
            <h1 class="text-success"><b>Thanks</b></h1>
            <img class="mx-auto d-block" src="{{ asset('loader/final.gif') }}">
            <h3>Your order is placed successfully</h3>
            <a href="{{ route('welcome') }}" class="btn btn-dark m-3">Go to Home</a>
            <a href="{{ route('order.my-order') }}" class="btn btn-dark m-3">Go to Orders</a>
        </div>
    </div>
</div>
@endsection
