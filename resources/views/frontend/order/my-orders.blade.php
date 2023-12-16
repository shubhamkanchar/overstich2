@extends('layouts.app')
@push('styles')
    <style>
        .status-label {
            display: inline-block;
            padding: 0.275rem 0.50rem;
            line-height: 1;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            border-radius: 0.25rem;
        }

        .status-new { background-color: #007bff; color: #fff; }
        .status-process { background-color: #ffc107; color: #000; }
        .status-delivered { background-color: #28a745; color: #fff; }
        .status-cancelled { background-color: #dc3545; color: #fff; }
        .status-returned { background-color: #17a2b8; color: #fff; }
        
        @media (max-width: 575.98px) {
            .filters {
                position: absolute;
                top: 0px;
            }

        }
    </style>
@endpush
@section('content')
    <div class="container-fluid">
        <div class="row mt-5 mb-5 justify-content-between row-gap-5 relative">
            <div class="col-md-3 col-12 d-none d-md-block filters ">
                <div class="card bg-white">
                    <div class="card-header bg-white">
                        <div class="card-title">
                            <h4>Filters</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('order.my-order')}}" method="get">
                            <h5>Order Status</h5>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="status" value="new" id="newOrder">
                                <label class="form-check-label" for="newOrder">
                                    New
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="status" value="delivered" id="deliveredOrder">
                                <label class="form-check-label" for="deliveredOrder">
                                    Delivered
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="status" value="cancel" id="cancelledOrder">
                                <label class="form-check-label" for="cancelledOrder">
                                    Cancelled
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="status" value="return" id="ReturnedOrder">
                                <label class="form-check-label" for="ReturnedOrder">
                                    Returned
                                </label>
                            </div>
                            <h5>Order Time</h5>
                            @php
                                $currentYear = now()->year;
                            @endphp
                            @for ($year = $currentYear; $year >= $currentYear - 4; $year--)
                                <div class="form-check">
                                    <input class="form-check-input" name="date" type="checkbox" value="{{ $year }}"
                                        id="year{{ $year }}">
                                    <label class="form-check-label" for="year{{ $year }}">
                                        {{ $year }}
                                    </label>
                                </div>
                            @endfor

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="older" id="olderYears">
                                <label class="form-check-label" for="olderYears">
                                    Older
                                </label>
                            </div>
                            <button type="submit" class="btn btn-primary ml-2 w-100" style="border-radius: 0%">Apply Filters</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-9">
                @if (count($orders) == 0)
                    <h1 class="fw-bold ms-md-4 text-center text-md-start">Order</h1>
                    <p class="ms-md-5 fs-md-3 text-center text-md-start">No order Found</p>
                @else
                    <form action="{{ route('order.my-order') }}" method="get">
                        <div class="mb-3 d-flex align-items-center justify-content-between">
                            <div class="col-md-10 col-8">
                                <input type="text" name="search" class="form-control" placeholder="Search Your Order Here" style="border-radius: 0%">
                            </div>
                            <div class="col-md-2 col-2">
                                <button type="submit" class="btn btn-primary ml-2 w-100" style="border-radius: 0%">Search</button>
                            </div>
                            <div class="col-md-2 col-2">
                                <span class="d-md-none ms-4 bi bi-filter fs-3"></span>
                            </div>
                        </div>
                    </form>
                    @foreach ($orders as $batch)
                        @foreach ($orders as $batch)
                            <div class="card mb-3 bg-white">
                                <div class="card-body">
                                    @foreach ($batch as $order)
                                        <div class="row justify-content-between">
                                            @foreach ($order->orderItem as $item)
                                                <div class="col-4 col-md-2 col-md-2">
                                                    <div class="ms-2 mt-2">
                                                        @if ($item->product->images)
                                                            <img src="{{ asset($item->product->images->first()->image_path) }}"
                                                                class="img-fluid" alt="Product Image"
                                                                style="max-height: 100px; width: 200px;">
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-8 col-md-10 d-flex flex-col flex-md-row">
                                                    <div class="d-md-block col-4 col-md-4 text-center text-md-start">
                                                        <div class="ms-2 text-nowrap">
                                                            <span class="mb-1 d-block">{{ $item->name }} x ({{ $item->quantity }})</span>
                                                            <span class="mb-1 fs-6 text-muted">Color: {{ $item->product->color }} </span>
                                                        </div>
                                                    </div>
                                                    <div class="d-md-block col-md-4">
                                                        <div class="ms-2">
                                                            <p class="mb-1"> &#8377;{{ number_format($item->total_price, 2) }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-4">
                                                        <div class="ms-2">
                                                            <p class="mb-1 d-inline-block status-label status-{{ strtolower($order->status) }}">
                                                                {{ ucfirst($order->status) }}
                                                            </p>
                                                            <span class="text-secondary d-inline-block mb-2">
                                                                {{ $statusDescriptions[$order->status] }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div> 
                                            @endforeach
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    @endforeach
                @endif
            </div>
        </div>
    @endsection
