@extends('layouts.app')
@section('content')
<div class="container">
    <form method="post" action="{{ route('seller.store') }}" class="seller-register" id="registerSeller" enctype="multipart/form-data">
        <div class="row justify-content-center mt-5 mb-5">
            <div class="col-md-8">
                <h3 class="fs-2">Register As Seller</h3>
                @csrf
                <div class="row">
                    <div class="col-md-6 p-3">
                        <label>GST no.</label>
                        <input class="form-control" type="text" name="gst">
                    </div>
                    <div class="col-md-6 p-3">
                        <label>Brand Name</label>
                        <input class="form-control" type="text" name="brand">
                    </div>
                    <div class="col-md-6 p-3">
                        <label>Mail ID</label>
                        <input class="form-control" type="email" name="mail">
                    </div>
                    <div class="col-md-6 p-3">
                        <label>Whatsapp</label>
                        <input class="form-control" type="text" name="whatsapp">
                    </div>
                    <div class="col-md-6 p-3">
                        <label>Category</label>
                        <input class="form-control" type="text" name="category" placeholder="Clothing, footwear, jewellery etc.*">
                    </div>
                    <div class="col-md-6 p-3">
                        <label>Products</label>
                        <input class="form-control" type="text" name="product" placeholder="Casual Men t-shirts, formal shirts">
                    </div>
                    <div class="col-md-6 p-3">
                        <label>Password</label>
                        <input class="form-control" type="password" name="password" placeholder="Password" id="password">
                    </div>
                    <div class="col-md-6 p-3">
                        <label>Confirm Password</label>
                        <input class="form-control" type="password" name="c_password" placeholder="Confirm Password">
                    </div>
                    <div class="col-md-6 p-3">
                        <label>Product price range</label>
                        <input class="form-control" type="text" name="price_range" placeholder="Rs.500 - 1500, Rs.700 - 3000, etc.">
                    </div>
                    <div class="col-md-6 p-3">
                        <label>Upload product photos</label>
                        <input class="form-control" accept="image/*" type="file" name="product_photos[]" placeholder="Minimum 5 photos" multiple>
                    </div>
                    <div class="col-md-12 p-3">
                        <label>Pick Up Address</label>
                        <input class="form-control" type="text" name="address_line" placeholder="Plot no, Building, street, Area*">
                    </div>
                    <div class="col-md-6 p-3">
                        <input class="form-control" type="text" name="locality" placeholder="Locality">
                    </div>
                    <div class="col-md-6 p-3">
                        <input class="form-control" type="text" name="city" placeholder="City">
                    </div>
                    <div class="col-md-6 p-3">
                        <input class="form-control" type="text" name="state" placeholder="State">
                    </div>
                    <div class="col-md-6 p-3">
                        <input class="form-control" type="text" name="pincode" placeholder="Pincode">
                    </div>
                    <div class="col-md-12 pt-3 ps-3">
                        <label>Bank A/c Details</label>
                    </div>
                    <div class="col-md-6 p-3">
                        <span>Account No</span>
                        <input class="form-control" type="text" name="account">
                    </div>
                    <div class="col-md-6 p-3">
                        <span>IFSC Code</span>
                        <input class="form-control" type="text" name="ifsc">
                    </div>
                    <div class="col-md-12 p-3 text-center">
                        <button type="submit" class="btn border fs-2">Submit For Approval</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection