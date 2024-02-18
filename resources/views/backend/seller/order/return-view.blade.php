@extends('backend.seller.layouts.app')
@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h4 class="fw-bold">
                    {{ ucwords($order->orderReturn?->status).' '.($order->orderReturn?->status_condition) }}
                </h4>
                @if($order->orderReturn?->return_reason == 'other')
                    <h5>Reason : {{ config('replace')[$order->orderReturn?->other_reason] }}</h5>
                @else
                    <h5>Reason : {{ config('replace')[$order->orderReturn?->return_reason] }}</h5>
                @endif
            </div>
            <div class="card-body table-responsive">
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
                                                <img src="{{ asset($image->image_path) }}" class="d-block w-100 aspect-img" alt="{{ $order->orderItem->name }}">
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
                    
                        <tr>
                            <th class="text-center">Subtotal</th>
                            <th class="text-center">Delivery Charge</th>
                            @if ($order->coupon_discount > 0)
                                <th class="text-center">Coupon Discount</th>
                            @endif
                            <th class="text-center">Discount</th>
                            <th class="text-center">Total Amount</th>
                            <th class="text-center">Created At</th>
                        </tr>
                        <tr>
                            <td class="text-center">{{ $order->sub_total }}</td>
                            <td class="text-center">{{ $order->shipping_cost ?? '-' }}</td>
                            @if ($order->coupon_discount > 0)
                                <td class="text-center">{{ $order->coupon_discount ?? '-' }}</td>
                            @endif
                            <td class="text-center">{{ $order->total_discount }}</td>
                            <td class="text-center">{{ $order->total_amount }}</td>
                            <td class="text-center">{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$order->created_at)->format('d/m/Y H:i:s') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                @if($order->orderReturn?->status_condition == 'rejected')
                   <h5>{{ ucwords($order->orderReturn?->status).' Rejection Reason : '.$order->orderReturn?->rejected_reason  }}</h5>
                @endif
                @if ($order->orderReturn?->status_condition == 'requested')
                    <a class="btn btn-success" href="{{ route('seller.order.return-accept', $order->id )}}">Accept</a>
                    <button class="btn btn-danger reject-order" data-bs-toggle="modal" data-bs-target="#rejectionModal">Reject</button>
                @endif
            </div>
        </div>
    </div>
    <div class="modal fade" id="rejectionModal" tabindex="-1" role="dialog" aria-labelledby="rejectionModal" aria-hidden="true">
        <div class="modal-dialog d-flex align-items-center">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Rejection Reason</h1>
                </div>
                <div class="modal-body">
                    <form action="{{ route('seller.order.return-reject', $order->id)}}" method="post" id="rejectOrder">
                        @csrf
                        <textarea name="reason" id="reason" class="form-control">

                        </textarea>
                        <button class="btn btn-dark float-end mt-2">Submit</button>
                    </form>
                    <p>Note Once rejected you wont able to revert this</p>
                </div>
            </div>
        </div>
    </div>
@endsection

