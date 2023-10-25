@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row mt-5 mb-5">
        <div class="col-md-12">
            <h3 class="ps-4"><b>WOMEN TOPS</b></h3>
        </div>
        <div class="col-md-12 ms-4">
            <span class="dropdown-toggle me-5" data-bs-toggle="dropdown">
                SHORT BY
            </span>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">ASSENDING</a></li>
                <li><a class="dropdown-item" href="#">DECENDING</a></li>
            </ul>
            <span class="dropdown-toggle me-5" data-bs-toggle="dropdown">
                SIZE
            </span>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">SMALL</a></li>
                <li><a class="dropdown-item" href="#">LARGE</a></li>
                <li><a class="dropdown-item" href="#">EXTRA LARGE</a></li>
            </ul>
            <span class="dropdown-toggle me-5" data-bs-toggle="dropdown">
                PATTERN
            </span>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">STRIPE</a></li>
                <li><a class="dropdown-item" href="#">CHECKS</a></li>
                <li><a class="dropdown-item" href="#">LINE</a></li>
            </ul>
            <span class="dropdown-toggle me-5" data-bs-toggle="dropdown">
                COLOR
            </span>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">BLACK</a></li>
                <li><a class="dropdown-item" href="#">RED</a></li>
                <li><a class="dropdown-item" href="#">BLUE</a></li>
                <li><a class="dropdown-item" href="#">GREEN</a></li>
                <li><a class="dropdown-item" href="#">YELLOW</a></li>
                <li><a class="dropdown-item" href="#">PINK</a></li>
            </ul>
            <span class="dropdown-toggle me-5" data-bs-toggle="dropdown">
                NECK
            </span>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">ROUND</a></li>
                <li><a class="dropdown-item" href="#">V</a></li>
                <li><a class="dropdown-item" href="#">DEEP</a></li>
            </ul>
            <span class="float-end">500 ITEMS</span>
        </div>
    </div>
    <div class="row mt-5 mb-5">
        <div class="col-md-3">
            <div class="card shadow rounded mb-5">
                <img class="card-img-top small-banner" src="{{ asset('image/small/1.jpg') }}" alt="Card image">
                <div class="card-body">
                    <span class="ps-4 fs-5"><b>BRAND NAME</b></span>
                    <i class="bi bi-heart fs-4 me-4 float-end"></i>
                    <span class="ps-4 fs-6 d-block">XYZ WOMEN TOP</span>
                    <span class="ps-4 fs-6 d-block"><strike>RS. 1000</strike><span class="text-danger ms-2">50% OFF</span></span>
                    <span class="ps-4 fs-5"><b>RS. 500</b></span>
                </div>
            </div>
        </div>
        <div class="col-md-3 pb-5">
            <a href="{{ route('products.show',1) }}">
                <img class="small-banner pb-1" width="100%" src="{{ asset('image/small/1.jpg') }}">
            </a>
            <span class="ps-4 fs-5"><b>BRAND NAME</b></span>
            <i class="bi bi-heart fs-4 me-4 float-end"></i>
            <span class="ps-4 fs-6 d-block">XYZ WOMEN TOP</span>
            <span class="ps-4 fs-6 d-block"><strike>RS. 1000</strike><span class="text-danger ms-2">50% OFF</span></span>
            <span class="ps-4 fs-5"><b>RS. 500</b></span>
        </div>
        <div class="col-md-3 pb-5">
            <img class="small-banner" width="100%" src="{{ asset('image/small/2.jpg') }}">
            <span class="ps-4 fs-5"><b>BRAND NAME</b></span>
            <i class="bi bi-heart fs-4 me-4 float-end"></i>
            <span class="ps-4 fs-6 d-block">XYZ WOMEN TOP</span>
            <span class="ps-4 fs-6 d-block"><strike>RS. 1000</strike><span class="text-danger ms-2">50% OFF</span></span>
            <span class="ps-4 fs-5"><b>RS. 500</b></span>
        </div>
        <div class="col-md-3 pb-5">
            <img class="small-banner" width="100%" src="{{ asset('image/small/3.jpg') }}">
            <span class="ps-4 fs-5"><b>BRAND NAME</b></span>
            <i class="bi bi-heart fs-4 me-4 float-end"></i>
            <span class="ps-4 fs-6 d-block">XYZ WOMEN TOP</span>
            <span class="ps-4 fs-6 d-block"><strike>RS. 1000</strike><span class="text-danger ms-2">50% OFF</span></span>
            <span class="ps-4 fs-5"><b>RS. 500</b></span>
        </div>
        <div class="col-md-3 pb-5">
            <img class="small-banner" width="100%" src="{{ asset('image/small/4.jpg') }}">
            <span class="ps-4 fs-5"><b>BRAND NAME</b></span>
            <i class="bi bi-heart fs-4 me-4 float-end"></i>
            <span class="ps-4 fs-6 d-block">XYZ WOMEN TOP</span>
            <span class="ps-4 fs-6 d-block"><strike>RS. 1000</strike><span class="text-danger ms-2">50% OFF</span></span>
            <span class="ps-4 fs-5"><b>RS. 500</b></span>
        </div>
        <div class="col-md-3 pb-5">
            <img class="small-banner" width="100%" src="{{ asset('image/small/5.jpg') }}">
            <span class="ps-4 fs-5"><b>BRAND NAME</b></span>
            <i class="bi bi-heart fs-4 me-4 float-end"></i>
            <span class="ps-4 fs-6 d-block">XYZ WOMEN TOP</span>
            <span class="ps-4 fs-6 d-block"><strike>RS. 1000</strike><span class="text-danger ms-2">50% OFF</span></span>
            <span class="ps-4 fs-5"><b>RS. 500</b></span>
        </div>
        <div class="col-md-3 pb-5">
            <img class="small-banner" width="100%" src="{{ asset('image/small/6.jpg') }}">
            <span class="ps-4 fs-5"><b>BRAND NAME</b></span>
            <i class="bi bi-heart fs-4 me-4 float-end"></i>
            <span class="ps-4 fs-6 d-block">XYZ WOMEN TOP</span>
            <span class="ps-4 fs-6 d-block"><strike>RS. 1000</strike><span class="text-danger ms-2">50% OFF</span></span>
            <span class="ps-4 fs-5"><b>RS. 500</b></span>
        </div>
        <div class="col-md-3 pb-5">
            <img class="small-banner" width="100%" src="{{ asset('image/small/4.jpg') }}">
            <span class="ps-4 fs-5"><b>BRAND NAME</b></span>
            <i class="bi bi-heart fs-4 me-4 float-end"></i>
            <span class="ps-4 fs-6 d-block">XYZ WOMEN TOP</span>
            <span class="ps-4 fs-6 d-block"><strike>RS. 1000</strike><span class="text-danger ms-2">50% OFF</span></span>
            <span class="ps-4 fs-5"><b>RS. 500</b></span>
        </div>
        <div class="col-md-3 pb-5">
            <img class="small-banner" width="100%" src="{{ asset('image/small/5.jpg') }}">
            <span class="ps-4 fs-5"><b>BRAND NAME</b></span>
            <i class="bi bi-heart fs-4 me-4 float-end"></i>
            <span class="ps-4 fs-6 d-block">XYZ WOMEN TOP</span>
            <span class="ps-4 fs-6 d-block"><strike>RS. 1000</strike><span class="text-danger ms-2">50% OFF</span></span>
            <span class="ps-4 fs-5"><b>RS. 500</b></span>
        </div>
        <div class="col-md-3 pb-5">
            <img class="small-banner" width="100%" src="{{ asset('image/small/6.jpg') }}">
            <span class="ps-4 fs-5"><b>BRAND NAME</b></span>
            <i class="bi bi-heart fs-4 me-4 float-end"></i>
            <span class="ps-4 fs-6 d-block">XYZ WOMEN TOP</span>
            <span class="ps-4 fs-6 d-block"><strike>RS. 1000</strike><span class="text-danger ms-2">50% OFF</span></span>
            <span class="ps-4 fs-5"><b>RS. 500</b></span>
        </div>
        <div class="col-md-3 pb-5">
            <img class="small-banner" width="100%" src="{{ asset('image/small/1.jpg') }}">
            <span class="ps-4 fs-5"><b>BRAND NAME</b></span>
            <i class="bi bi-heart fs-4 me-4 float-end"></i>
            <span class="ps-4 fs-6 d-block">XYZ WOMEN TOP</span>
            <span class="ps-4 fs-6 d-block"><strike>RS. 1000</strike><span class="text-danger ms-2">50% OFF</span></span>
            <span class="ps-4 fs-5"><b>RS. 500</b></span>
        </div>
        <div class="col-md-3 pb-5">
            <img class="small-banner" width="100%" src="{{ asset('image/small/2.jpg') }}">
            <span class="ps-4 fs-5"><b>BRAND NAME</b></span>
            <i class="bi bi-heart fs-4 me-4 float-end"></i>
            <span class="ps-4 fs-6 d-block">XYZ WOMEN TOP</span>
            <span class="ps-4 fs-6 d-block"><strike>RS. 1000</strike><span class="text-danger ms-2">50% OFF</span></span>
            <span class="ps-4 fs-5"><b>RS. 500</b></span>
        </div>
        <div class="col-md-3 pb-5">
            <img class="small-banner" width="100%" src="{{ asset('image/small/3.jpg') }}">
            <span class="ps-4 fs-5"><b>BRAND NAME</b></span>
            <i class="bi bi-heart fs-4 me-4 float-end"></i>
            <span class="ps-4 fs-6 d-block">XYZ WOMEN TOP</span>
            <span class="ps-4 fs-6 d-block"><strike>RS. 1000</strike><span class="text-danger ms-2">50% OFF</span></span>
            <span class="ps-4 fs-5"><b>RS. 500</b></span>
        </div>
        <div class="col-md-3 pb-5">
            <img class="small-banner" width="100%" src="{{ asset('image/small/4.jpg') }}">
            <span class="ps-4 fs-5"><b>BRAND NAME</b></span>
            <i class="bi bi-heart fs-4 me-4 float-end"></i>
            <span class="ps-4 fs-6 d-block">XYZ WOMEN TOP</span>
            <span class="ps-4 fs-6 d-block"><strike>RS. 1000</strike><span class="text-danger ms-2">50% OFF</span></span>
            <span class="ps-4 fs-5"><b>RS. 500</b></span>
        </div>
        <div class="col-md-3 pb-5">
            <img class="small-banner" width="100%" src="{{ asset('image/small/1.jpg') }}">
            <span class="ps-4 fs-5"><b>BRAND NAME</b></span>
            <i class="bi bi-heart fs-4 me-4 float-end"></i>
            <span class="ps-4 fs-6 d-block">XYZ WOMEN TOP</span>
            <span class="ps-4 fs-6 d-block"><strike>RS. 1000</strike><span class="text-danger ms-2">50% OFF</span></span>
            <span class="ps-4 fs-5"><b>RS. 500</b></span>
        </div>
        <div class="col-md-3 pb-5">
            <img class="small-banner" width="100%" src="{{ asset('image/small/2.jpg') }}">
            <span class="ps-4 fs-5"><b>BRAND NAME</b></span>
            <i class="bi bi-heart fs-4 me-4 float-end"></i>
            <span class="ps-4 fs-6 d-block">XYZ WOMEN TOP</span>
            <span class="ps-4 fs-6 d-block"><strike>RS. 1000</strike><span class="text-danger ms-2">50% OFF</span></span>
            <span class="ps-4 fs-5"><b>RS. 500</b></span>
        </div>
        <div class="col-md-3 pb-5">
            <img class="small-banner" width="100%" src="{{ asset('image/small/3.jpg') }}">
            <span class="ps-4 fs-5"><b>BRAND NAME</b></span>
            <i class="bi bi-heart fs-4 me-4 float-end"></i>
            <span class="ps-4 fs-6 d-block">XYZ WOMEN TOP</span>
            <span class="ps-4 fs-6 d-block"><strike>RS. 1000</strike><span class="text-danger ms-2">50% OFF</span></span>
            <span class="ps-4 fs-5"><b>RS. 500</b></span>
        </div>
        <div class="col-md-3 pb-5">
            <img class="small-banner" width="100%" src="{{ asset('image/small/4.jpg') }}">
            <span class="ps-4 fs-5"><b>BRAND NAME</b></span>
            <i class="bi bi-heart fs-4 me-4 float-end"></i>
            <span class="ps-4 fs-6 d-block">XYZ WOMEN TOP</span>
            <span class="ps-4 fs-6 d-block"><strike>RS. 1000</strike><span class="text-danger ms-2">50% OFF</span></span>
            <span class="ps-4 fs-5"><b>RS. 500</b></span>
        </div>
        <div class="col-md-3 pb-5">
            <img class="small-banner" width="100%" src="{{ asset('image/small/5.jpg') }}">
            <span class="ps-4 fs-5"><b>BRAND NAME</b></span>
            <i class="bi bi-heart fs-4 me-4 float-end"></i>
            <span class="ps-4 fs-6 d-block">XYZ WOMEN TOP</span>
            <span class="ps-4 fs-6 d-block"><strike>RS. 1000</strike><span class="text-danger ms-2">50% OFF</span></span>
            <span class="ps-4 fs-5"><b>RS. 500</b></span>
        </div>
        <div class="col-md-3 pb-5">
            <img class="small-banner" width="100%" src="{{ asset('image/small/6.jpg') }}">
            <span class="ps-4 fs-5"><b>BRAND NAME</b></span>
            <i class="bi bi-heart fs-4 me-4 float-end"></i>
            <span class="ps-4 fs-6 d-block">XYZ WOMEN TOP</span>
            <span class="ps-4 fs-6 d-block"><strike>RS. 1000</strike><span class="text-danger ms-2">50% OFF</span></span>
            <span class="ps-4 fs-5"><b>RS. 500</b></span>
        </div>
        <div class="col-md-3 pb-5">
            <img class="small-banner" width="100%" src="{{ asset('image/small/4.jpg') }}">
            <span class="ps-4 fs-5"><b>BRAND NAME</b></span>
            <i class="bi bi-heart fs-4 me-4 float-end"></i>
            <span class="ps-4 fs-6 d-block">XYZ WOMEN TOP</span>
            <span class="ps-4 fs-6 d-block"><strike>RS. 1000</strike><span class="text-danger ms-2">50% OFF</span></span>
            <span class="ps-4 fs-5"><b>RS. 500</b></span>
        </div>
        <div class="col-md-3 pb-5">
            <img class="small-banner" width="100%" src="{{ asset('image/small/5.jpg') }}">
            <span class="ps-4 fs-5"><b>BRAND NAME</b></span>
            <i class="bi bi-heart fs-4 me-4 float-end"></i>
            <span class="ps-4 fs-6 d-block">XYZ WOMEN TOP</span>
            <span class="ps-4 fs-6 d-block"><strike>RS. 1000</strike><span class="text-danger ms-2">50% OFF</span></span>
            <span class="ps-4 fs-5"><b>RS. 500</b></span>
        </div>
        <div class="col-md-3 pb-5">
            <img class="small-banner" width="100%" src="{{ asset('image/small/6.jpg') }}">
            <span class="ps-4 fs-5"><b>BRAND NAME</b></span>
            <i class="bi bi-heart fs-4 me-4 float-end"></i>
            <span class="ps-4 fs-6 d-block">XYZ WOMEN TOP</span>
            <span class="ps-4 fs-6 d-block"><strike>RS. 1000</strike><span class="text-danger ms-2">50% OFF</span></span>
            <span class="ps-4 fs-5"><b>RS. 500</b></span>
        </div>
        <div class="col-md-3 pb-5">
            <img class="small-banner" width="100%" src="{{ asset('image/small/1.jpg') }}">
            <span class="ps-4 fs-5"><b>BRAND NAME</b></span>
            <i class="bi bi-heart fs-4 me-4 float-end"></i>
            <span class="ps-4 fs-6 d-block">XYZ WOMEN TOP</span>
            <span class="ps-4 fs-6 d-block"><strike>RS. 1000</strike><span class="text-danger ms-2">50% OFF</span></span>
            <span class="ps-4 fs-5"><b>RS. 500</b></span>
        </div>
        <div class="col-md-3 pb-5">
            <img class="small-banner" width="100%" src="{{ asset('image/small/2.jpg') }}">
            <span class="ps-4 fs-5"><b>BRAND NAME</b></span>
            <i class="bi bi-heart fs-4 me-4 float-end"></i>
            <span class="ps-4 fs-6 d-block">XYZ WOMEN TOP</span>
            <span class="ps-4 fs-6 d-block"><strike>RS. 1000</strike><span class="text-danger ms-2">50% OFF</span></span>
            <span class="ps-4 fs-5"><b>RS. 500</b></span>
        </div>
    </div>
</div>
@endsection