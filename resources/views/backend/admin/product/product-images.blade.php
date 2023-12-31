@extends('backend.admin.layouts.app')

@push('styles')
    <style>
        .img-container {
            height: 400px; 
        }

        .card img {
            width: 100%;
            height: 100%;
            padding: 20px;
            object-fit: cover; 
        }   
    </style>
@endpush
@section('content')
<div class="container seller-product mt-4">
    <div class="row">
        @foreach ($productImages as $image)
            <div class="col-12 col-md-4 mb-4">
                <div class="card border-0 shadow">
                    <div class="img-container">
                        <img src="{{ asset($image->image_path) }}" class="card-img-top" alt="Product Image">
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
