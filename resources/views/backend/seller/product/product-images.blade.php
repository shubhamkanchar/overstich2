@extends('backend.seller.layouts.app')

@push('styles')
    <style>
        .img-container {
            height: 400px; 
        }

        .card img {
            width: 100%;
            height: 100%;
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
                    <div class="card-body text-center">
                        <form id="imageForm{{$image->id}}" class="image-form" action="{{ route('seller.product.replace-image', ['product' => $product->slug, 'productImage' => $image->id]) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            <input type="file" class="d-none" id="imageInput{{$image->id}}" name="new_image" data-target="#btn-{{$image->id}}">
                            <label for="imageInput{{$image->id}}" class="btn btn-primary btn-sm text-white">Replace</label>
                            <button class="d-none submit-btn" id="btn-{{$image->id}}">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    @if(!empty($product->size_chart))
        <div class="col-12 col-md-6">
            <div class="card border-0 shadow">
                <div class="card-header bg-white mt-2 text-center">
                   <h5>Size Chart</h5>
                </div>
                <img src="{{ asset($product->size_chart) }}" style="width: 100%; height: 100%;" class="card-img-top p-2" alt="Product Image">
                <div class="card-body text-center">
                    <form id="sizeChart" class="image-form" action="{{ route('seller.product.update-size-chart', ['product' => $product->slug]) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <input type="file" class="d-none" id="sizeChartInput" name="size_chart" data-target="#sizeChartButton">
                        <label for="sizeChartInput" class="btn btn-primary btn-sm text-white">Replace</label>
                        <button class="d-none submit-btn" id="sizeChartButton">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    @else
        <form id="sizeChart" class="image-form" action="{{ route('seller.product.update-size-chart', ['product' => $product->slug]) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <input type="file" class="d-none" id="sizeChartInput" name="size_chart" data-target="#sizeChartButton">
            <label for="sizeChartInput" class="btn btn-primary btn-sm text-center text-white">Add Size Chart</label>
            <button class="d-none submit-btn" id="sizeChartButton">Submit</button>
        </form> 
    @endif
</div>
@endsection
