@extends('backend.admin.layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Image</th>
                            <th class="text-center">Price</th>
                            <th class="text-center">Discount</th>
                            <th class="text-center">Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $image = $order->orderItem->product->images->first()->image_path;
                        @endphp
                        <tr>
                            <td>{{ $order->orderItem->name }}</td>
                            <td style="height: 100px; width: 200px">
                                <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
                                    <div class="carousel-inner">
                                        @foreach ($order->orderItem->product->images as $index => $image)
                                            <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                                <img src="{{ asset($image->image_path) }}" class="d-block w-100" alt="{{ $order->orderItem->name }}">
                                            </div>
                                        @endforeach
                                    </div>
                                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Next</span>
                                    </button>
                                </div>
                            </td>
                            <td class="text-center">{{ $order->orderItem->price }}</td>
                            <td class="text-center">{{ $order->orderItem->discount }}</td>
                            <td class="text-center">{{ $order->orderItem->quantity }}</td>
                        </tr>
                    </tbody>
                </table>
                <table class="table float-end text-end">
                    <thead>
                        <tr>
                            <th></th>
                            <th class="text-center">Subtotal</th>
                            <th class="text-center">Delivery Charge</th>
                            <th class="text-center">Discount</th>
                            <th class="text-center">Total Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td></td>
                            <td class="text-center">{{ $order->sub_total }}</td>
                            <td class="text-center">{{ $order->shipping_cost ?? '-' }}</td>
                            <td class="text-center">{{ $order->total_discount }}</td>
                            <td class="text-center">{{ $order->total_amount }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
 
@push('scripts')
    
@endpush