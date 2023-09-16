@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row mt-5 mb-5 justify-content-center">
        <div class="col-lg-4 col-md-6 pb-5">
            <div class="row">
                <div class="col-md-6">
                    <img class="pb-4" width="100%" src="{{ asset('public/image/small/1.jpg') }}">
                </div>
                <div class="col-md-6">
                    <img class="pb-4" width="100%" src="{{ asset('public/image/small/1.jpg') }}">
                </div>
                <div class="col-md-6">
                    <img class="pb-4" width="100%" src="{{ asset('public/image/small/1.jpg') }}">
                </div>
                <div class="col-md-6">
                    <img class="pb-4" width="100%" src="{{ asset('public/image/small/1.jpg') }}">
                </div>
                <div class="col-md-6">
                    <img class="pb-4" width="100%" src="{{ asset('public/image/small/1.jpg') }}">
                </div>
                <div class="col-md-12">
                    <p>SELLER INFORMATION :-</p>
                    <span class="d-block"><b>BRAND :-</b> XYZ FASHION</span>
                    <span class="d-block"><b>LEGAL NAME :-</b> FAB & FASHION</span>
                    <span class="d-block"><b>ADDRESS :-</b> PLOT 25718 INSIDE RIGHT SIDE SHOP,</span>
                    <span class="d-block"><b>RAJASTHAN :-</b> 302029</span>
                    <span class="d-block"><b>MAIL :-</b> fab&fashion@gmail.com</span>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 pb-5">
            <span class="ps-4 fs-3"><b>BRAND NAME</b></span>
            <i class="bi bi-heart fs-2 me-4 float-end"></i>
            <span class="ps-4 fs-4 d-block">XYZ WOMEN TOP</span>
            <span class="ps-4 fs-4 d-block"><strike>RS. 1000</strike><span class="text-danger ms-2">50% OFF</span></span>
            <span class="ps-4 fs-3 d-block"><b>RS. 500</b></span>
            <span class="ps-4 fs-3 mt-3 d-block"><b>Sizes</b></span>
            <div class="ps-3">
                <button class="btn btn-lg border w-25 m-2">XS</button>
                <button class="btn btn-lg border w-25 m-2">S</button>
                <button class="btn btn-lg border w-25 m-2">M</button>
                <button class="btn btn-lg border w-25 m-2">L</button>
                <button class="btn btn-lg border w-25 m-2">XL</button>
                <button class="btn btn-lg border w-25 m-2">XXL</button>
            </div>
            <span class="ps-4 fs-3 mt-3 d-block">Sizes Chart</span>
            <button class="ms-4 fs-3 mt-5 mb-5 btn btn-dark" style="width:85%"><i class="bi bi-bag me-1"></i>Add</button>
            <ul class="ms-4">
                <li>Standart Delivery in 5 - 9 days</li>
                <li>Return/Exchange Available for 7 days</li>
            </ul>
            <span class="ps-4 fs-4 mt-3 d-block">DELIVERY CHECK</span>
            <input class="ms-4 mt-4 w-50" type="text">
            <a class="text-danger ms-2">CHECK</a>
            <span class="ps-4 fs-4 mt-3 d-block">PRODUCT DETAILS</span>
            <ul class="ms-4">
                <li>Colour : solid black</li>
                <li>Round neck</li>
                <li>Slim fit</li>
                <li>Material : Cotton</li>
                <li>Sleeveless</li>
            </ul>
            <span class="ps-4 fs-4 mt-3 d-block">RATINGS</span>
            <h1 class="ps-4 mt-3 d-block">4.2 <i class="bi bi-star-fill ms-2"></i></h1>
            <ul class="ms-4">
                <li>102 BUYERS RATING</li>
            </ul>
            <label class="mt-3 ms-4">FIT</label>
            <div class="progress ms-4" style="height:10px">
                <div class="progress-bar bg-success" role="progressbar" style="width: 75%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <label class="mt-3 ms-4">TRANSPARENCY</label>
            <div class="progress ms-4" style="height:10px">
                <div class="progress-bar bg-danger" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <label class="mt-3 ms-4">LENGTH</label>
            <div class="progress ms-4" style="height:10px">
                <div class="progress-bar bg-primary" role="progressbar" style="width: 50%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <span class="ps-4 fs-4 mt-4 d-block">REVIEWS</span>
            <div class="ratings ps-4 mt-3">
                <span class="p-2 bg-primary" style="border-radius: 5px;"><b>5</b> <i class="bi bi-star-fill text-white"></i></span>
                <span>The material is pure cotton. Very comfortable to wear and looks beautiful❤</span>
            </div>
            
        </div>
    </div>
</div>
@endsection