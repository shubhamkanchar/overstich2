@extends('backend.admin.layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                Order At: {{ $order->created_at->format('d/m/Y H:i A')}}
            </div>
            <div class="card-body table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th style="width: 400px !important">Image</th>
                            <th class="text-center">Gross Amount(rs)</th>
                            <th class="text-center">Discount(rs)</th>
                            <th class="text-center">Taxable Amount(rs)</th>
                            <th class="text-center">Discount</th>
                            <th class="text-center">Quantity</th>
                            <th class="text-center">Net Amount(rs)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $image = $order->orderItem->product->images->first()->image_path;
                        @endphp
                        <tr>
                            <td>{{ $order->orderItem->name }}</td>
                            <td style="width: 400px !important">
                                <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
                                    <div class="carousel-inner">
                                        @foreach ($order->orderItem->product->images as $index => $image)
                                            <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                                <img src="{{ asset($image->image_path) }}" class=" aspect-img" alt="{{ $order->orderItem->name }}">
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
                            <td class="text-center">{{ number_format($order->orderItem->taxable_amount, 2) }}</td>
                            <td class="text-center">{{ number_format($order->orderItem->discount, 2) }}</td>
                            <td class="text-center">{{ number_format($order->orderItem->taxable_amount, 2) }}</td>
                            <td class="text-center">{{ $order->orderItem->quantity }}</td>
                            <td class="text-center">{{ number_format($order->orderItem->price, 2) }}</td>
                        </tr>
                        <tr>
                            <th>Total</th>
                            <th></th>
                            <td class="text-center">{{ $order->sub_total }}</td>
                            <td class="text-center">{{ $order->total_discount ?? '-' }}</td>
                            <td class="text-center">{{ $order->total_taxable_amount }}</td>
                            <td></td>
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