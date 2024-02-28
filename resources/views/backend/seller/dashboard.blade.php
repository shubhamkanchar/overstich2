@extends('backend.seller.layouts.app')

@section('content')
<div class="grey-bg container-fluid">
    <div class="row">
        <div class="col-12">
        @if(!auth()->user()->sellerInfo->is_completed)
            <div class="alert alert-warning" role="alert">
                Please complete profile and upload product details
                <a class="btn btn-dark" href="{{ route('seller.account.index')}}">Account</a>
            </div>
        @endif
        @if(!auth()->user()->sellerInfo->is_approved)
            <div class="alert alert-warning" role="alert">
                Admin approval is pending Once your account is complete you able to use all functionality
            </div>
        @endif
        </div>
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <div class="media d-flex">
                            <div class="align-self-center w-50">
                                <i class="bi bi-cart fs-1"></i>
                            </div>
                            <div class="media-body text-end w-50">
                                <h3>{{ App\Models\Product::where('seller_id', auth()->id())->count() }}</h3>
                                <span>Total Product's</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <div class="media d-flex">
                            <div class="align-self-center w-50">
                                <i class="bi bi-bag fs-1"></i>
                            </div>
                            <div class="media-body text-end w-50">
                                <h3>{{ App\Models\Order::where(['seller_id' => auth()->id(), 'is_order_confirmed' => 1])->count() }}</h3>
                                <span>Total Order's</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection