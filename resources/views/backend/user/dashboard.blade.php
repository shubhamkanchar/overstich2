@extends('backend.user.layouts.app')

@section('content')
<div class="grey-bg container-fluid">
    <div class="row">
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <div class="media d-flex">
                            <div class="align-self-center w-50">
                                <i class="bi bi-box2 fs-1"></i>
                            </div>
                            <div class="media-body w-50 text-end">
                                <h3>{{ App\Models\User::where('user_type','seller')->count() }}</h3>
                                <span>Total Seller's</span>
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
                                <i class="bi bi-person fs-1"></i>
                            </div>
                            <div class="media-body text-end w-50">
                                <h3>{{ App\Models\User::where('user_type','user')->count() }}</h3>
                                <span>Total User's</span>
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
                                <i class="bi bi-cart fs-1"></i>
                            </div>
                            <div class="media-body text-end w-50">
                                <h3>0</h3>
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
                                <h3>0</h3>
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