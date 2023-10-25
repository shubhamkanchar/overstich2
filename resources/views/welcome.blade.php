@extends('layouts.app')

@section('content')
<!-- <div class="container-fluid"> -->
<div id="demo" class="carousel slide" data-bs-ride="carousel">

    <!-- Indicators/dots -->
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#demo" data-bs-slide-to="0" class="active"></button>
        <button type="button" data-bs-target="#demo" data-bs-slide-to="1"></button>
        <button type="button" data-bs-target="#demo" data-bs-slide-to="2"></button>
    </div>

    <!-- The slideshow/carousel -->
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="https://www.w3schools.com/bootstrap5/la.jpg" alt="Los Angeles" class="d-block" style="width:100%">
            <div class="carousel-caption">
                <h2>Brand Name</h2>
                <button type="button" class="btn btn-lg btn-secondary">Shop</button>
            </div>
        </div>
        <div class="carousel-item">
            <img src="https://www.w3schools.com/bootstrap5/chicago.jpg" alt="Chicago" class="d-block" style="width:100%">
            <div class="carousel-caption">
                <h2>Brand Name</h2>
                <button type="button" class="btn btn-lg btn-secondary">Shop</button>
            </div>
        </div>
        <div class="carousel-item">
            <img src="https://www.w3schools.com/bootstrap5/ny.jpg" alt="New York" class="d-block" style="width:100%">
            <div class="carousel-caption">
                <h2>Brand Name</h2>
                <button type="button" class="btn btn-lg btn-secondary">Shop</button>
            </div>
        </div>
    </div>

    <!-- Left and right controls/icons -->
    <button class="carousel-control-prev" type="button" data-bs-target="#demo" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#demo" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
    </button>
</div>

<!-- </div> -->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12 mt-5 mb-5">
            <img width="100%" src="{{ asset('image/banner/banner1.jpg') }}">
        </div>
        <div class="col-md-12 mt-5 mb-5">
            <img width="100%" src="{{ asset('image/banner/banner2.jpg') }}">
        </div>
    </div>
    <div class="row mt-md-5 mb-5">
        <div class="col-md-2 col-3 col-3 ">
            <img class="small-banner" width="100%" src="{{ asset('image/small/1.jpg') }}">
        </div>
        <div class="col-md-2 col-3">
            <img class="small-banner" width="100%" src="{{ asset('image/small/2.jpg') }}">
        </div>
        <div class="col-md-2 col-3">
            <img class="small-banner" width="100%" src="{{ asset('image/small/3.jpg') }}">
        </div>
        <div class="col-md-2 col-3">
            <img class="small-banner" width="100%" src="{{ asset('image/small/4.jpg') }}">
        </div>
        <div class="col-md-2 col-3">
            <img class="small-banner" width="100%" src="{{ asset('image/small/5.jpg') }}">
        </div>
        <div class="col-md-2 col-3">
            <img class="small-banner" width="100%" src="{{ asset('image/small/6.jpg') }}">
        </div>
        <div class="col-md-2 col-3">
            <img class="small-banner" width="100%" src="{{ asset('image/small/4.jpg') }}">
        </div>
        <div class="col-md-2 col-3">
            <img class="small-banner" width="100%" src="{{ asset('image/small/5.jpg') }}">
        </div>
        <div class="col-md-2 col-3">
            <img class="small-banner" width="100%" src="{{ asset('image/small/6.jpg') }}">
        </div>
        <div class="col-md-2 col-3">
            <img class="small-banner" width="100%" src="{{ asset('image/small/1.jpg') }}">
        </div>
        <div class="col-md-2 col-3">
            <img class="small-banner" width="100%" src="{{ asset('image/small/2.jpg') }}">
        </div>
        <div class="col-md-2 col-3">
            <img class="small-banner" width="100%" src="{{ asset('image/small/3.jpg') }}">
        </div>
        <div class="col-md-2 col-3">
            <img class="small-banner" width="100%" src="{{ asset('image/small/4.jpg') }}">
        </div>
        <div class="col-md-2 col-3">
            <img class="small-banner" width="100%" src="{{ asset('image/small/1.jpg') }}">
        </div>
        <div class="col-md-2 col-3">
            <img class="small-banner" width="100%" src="{{ asset('image/small/2.jpg') }}">
        </div>
        <div class="col-md-2 col-3">
            <img class="small-banner" width="100%" src="{{ asset('image/small/3.jpg') }}">
        </div>
        <div class="col-md-2 col-3">
            <img class="small-banner" width="100%" src="{{ asset('image/small/4.jpg') }}">
        </div>
        <div class="col-md-2 col-3">
            <img class="small-banner" width="100%" src="{{ asset('image/small/5.jpg') }}">
        </div>
        <div class="col-md-2 col-3">
            <img class="small-banner" width="100%" src="{{ asset('image/small/6.jpg') }}">
        </div>
        <div class="col-md-2 col-3">
            <img class="small-banner" width="100%" src="{{ asset('image/small/4.jpg') }}">
        </div>
        <div class="col-md-2 col-3">
            <img class="small-banner" width="100%" src="{{ asset('image/small/5.jpg') }}">
        </div>
        <div class="col-md-2 col-3">
            <img class="small-banner" width="100%" src="{{ asset('image/small/6.jpg') }}">
        </div>
        <div class="col-md-2 col-3">
            <img class="small-banner" width="100%" src="{{ asset('image/small/1.jpg') }}">
        </div>
        <div class="col-md-2 col-3">
            <img class="small-banner" width="100%" src="{{ asset('image/small/2.jpg') }}">
        </div>
    </div>
    <div class="row mt-5 mb-5">
        <div class="col-5">
            <img class="small-banner" width="100%" src="{{ asset('image/small/3.jpg') }}">
        </div>
        <div class="col-7">
            <img width="100%" src="{{ asset('image/banner/banner2.jpg') }}">
        </div>
    </div>
    <div class="row justify-content-center mt-5 mb-5">
        <div class="col-3">
            <img class="small-banner" width="100%" src="{{ asset('image/small/6.jpg') }}">
        </div>
        <div class="col-3">
            <img class="small-banner" width="100%" src="{{ asset('image/small/2.jpg') }}">
        </div>
        <div class="col-3">
            <img class="small-banner" width="100%" src="{{ asset('image/small/1.jpg') }}">
        </div>
    </div>
</div>
@endsection