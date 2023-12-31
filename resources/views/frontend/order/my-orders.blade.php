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

        .status-new {
            background-color: #007bff;
            color: #fff;
        }

        .status-process {
            background-color: #ffc107;
            color: #000;
        }

        .status-delivered {
            background-color: #28a745;
            color: #fff;
        }

        .status-cancelled {
            background-color: #dc3545;
            color: #fff;
        }

        .status-returned {
            background-color: #17a2b8;
            color: #fff;
        }

        input[name="search"]:focus {
            box-shadow: none !important;
            border-color: #000 !important;
        }

        .translate-y-up {
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        }

        .translate-y-up:hover {
            transform: translateY(-0.5px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .clear-icon {
            cursor: pointer;
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #ccc;
        }

        .clear-icon:hover {
            color: #000;
        }

        @media (max-width: 575.98px) {
            .filters {
                position: absolute;
                top: 19%;
                right: auto;
                z-index: 999;
            }

        }
    </style>
@endpush
@section('content')
    <div class="container-fluid">
        <form action="{{ route('order.my-order') }}" id="myOrderForm" method="get">
            <div class="row mt-5 mb-5 justify-content-between row-gap-5">
                <div class="col-md-3 col-12 filters d-none d-md-block">
                    <div class="card bg-white">
                        <div class="card-header bg-white">
                            <div class="d-flex justify-content-between position-relative" role="button">
                                <div class="card-title">
                                    <h4>Filters</h4>
                                </div>

                                @if (count($date) || count($status))
                                    <span class="clear-filter-icon d-none d-md-block fs-5 text-primary" onclick="clearFilters()">
                                        Clear All
                                    </span>
                                @endif
                                <span class="close-filter-icon d-block d-md-none fs-4 text-dark">
                                    <i class="bi bi-x"></i>
                                </span>
                            </div>
                            
                            
                        </div>
                        <div class="card-body">
                            <h5>Order Status</h5>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="status[]" value="new"
                                    id="newOrder" @checked(in_array('new', $status))>
                                <label class="form-check-label" for="newOrder">
                                    New
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="status[]" value="delivered"
                                    id="deliveredOrder" @checked(in_array('delivered', $status))>
                                <label class="form-check-label" for="deliveredOrder">
                                    Delivered
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="status[]" value="cancelled"
                                    id="cancelledOrder" @checked(in_array('cancelled', $status))>
                                <label class="form-check-label" for="cancelledOrder">
                                    Cancelled
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="status[]" value="returned"
                                    id="ReturnedOrder" @checked(in_array('returned', $status))>
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
                                    <input class="form-check-input" name="date[]" type="checkbox"
                                        value="{{ $year }}" id="year{{ $year }}"
                                        @checked(in_array($year, $date))>
                                    <label class="form-check-label" for="year{{ $year }}">
                                        {{ $year }}
                                    </label>
                                </div>
                            @endfor

                            <div class="form-check">
                                <input class="form-check-input" name="date[]" type="checkbox" value="older"
                                    id="olderYears" @checked(in_array('older', $date))>
                                <label class="form-check-label" for="olderYears">
                                    Older
                                </label>
                            </div>
                            <button type="submit" class="btn btn-dark ml-2 w-100" style="border-radius: 0%">Apply
                                Filters</button>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-9">
                    @if (count($orders) == 0)
                        <h1 class="fw-bold ms-md-4 text-center text-md-start">Order</h1>
                        <p class="ms-md-5 fs-md-3 text-center text-md-start">No order Found</p>
                        <div class="mb-3 d-flex align-items-center justify-content-between translate-y-up">
                            <div class="col-md-10 col-8 position-relative">
                                <input type="text" name="search" value="{{ $search }}" class="form-control" placeholder="Search Your Order Here" style="border-radius: 0%">
                                @if (!empty($search))
                                    <span class="clear-icon fs-4" onclick="clearSearch()">
                                        <i class="bi bi-x"></i>
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-2 col-2">
                                <button type="submit" class="btn btn-dark ml-2 w-100"
                                    style="border-radius: 0%">Search</button>
                            </div>
                            <div class="col-md-2 col-2">
                                <span class="d-md-none ms-4 bi bi-filter fs-3 show-filter"></span>
                            </div>
                        </div>
                    @else
                        <div class="mb-3 d-flex align-items-center justify-content-between translate-y-up">
                            <div class="col-md-10 col-8 position-relative">
                                <input type="text" name="search" value="{{ $search }}" class="form-control" placeholder="Search Your Order Here" style="border-radius: 0%">
                                @if (!empty($search))
                                    <span class="clear-icon fs-4" onclick="clearSearch()">
                                        <i class="bi bi-x"></i>
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-2 col-2">
                                <button type="submit" class="btn btn-dark ml-2 w-100"
                                    style="border-radius: 0%">Search</button>
                            </div>
                            <div class="col-md-2 col-2">
                                <span class="d-md-none ms-4 bi bi-filter fs-3 show-filter"></span>
                            </div>
                        </div>
                        @foreach ($orders as $batch)
                            <div class="card mb-3 bg-white translate-y-up">
                                <div class="card-body">
                                    @foreach ($batch as $order)
                                        <div class="row justify-content-between">
                                            {{-- @foreach ($order->orderItem as $order->orderItem) --}}
                                            <div class="col-4 col-md-2 col-md-2">
                                                <div class="ms-2 mt-2">
                                                    @if ($order->orderItem->product->images)
                                                        <img src="{{ asset($order->orderItem->product->images->first()->image_path) }}"
                                                            class="img-fluid" alt="Product Image"
                                                            style="max-height: 100px; width: 200px;">
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-8 col-md-10 d-flex flex-col flex-md-row">
                                                <div class="d-md-block col-4 col-md-4 text-center text-md-start">
                                                    <div class="ms-2 text-start text-nowrap">
                                                        <span class="mb-1 d-block">{{ $order->orderItem->name }} x
                                                            ({{ $order->orderItem->quantity }})
                                                        </span>
                                                        <span class="mb-1 fs-6 text-muted d-block">Color:
                                                            {{ $order->orderItem->color }} </span>
                                                        <span class="mb-1 fs-6 text-muted">Size:
                                                            {{ $order->orderItem->size }} &nbsp; &nbsp; </span>
                                                    </div>
                                                </div>
                                                <div class="d-md-block col-md-4">
                                                    <div class="ms-2">
                                                        <p class="mb-1">
                                                            &#8377;{{ number_format($order->orderItem->total_price, 2) }}
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-4">
                                                    <div class="ms-2">
                                                        <p
                                                            class="mb-1 d-inline-block status-label status-{{ strtolower($order->status) }}">
                                                            {{ ucfirst($order->status) }}
                                                        </p>
                                                        <span class="text-secondary d-inline-block mb-2">
                                                            {{ $statusDescriptions[$order->status] }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- @endforeach --}}
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </form>
        <div class="d-flex justify-content-center">
            {!! $links !!}
        </div>
    </div>
@endsection

@section('script')
    <script>

        function clearFilters() {
            document.querySelectorAll('#myOrderForm input[type="checkbox"]').forEach(checkbox => checkbox.checked = false);
            document.getElementById('myOrderForm').submit();
        }

        function clearSearch() {
            document.querySelector('input[name="search"]').value = '';
            document.getElementById('myOrderForm').submit();
        }

        document.querySelector('.show-filter').addEventListener('click', function() {
            document.querySelector('.filters').classList.remove('d-none');
        });

        document.querySelector('.close-filter-icon').addEventListener('click', function() {
            document.querySelector('.filters').classList.add('d-none');
        });
    </script>
@endsection