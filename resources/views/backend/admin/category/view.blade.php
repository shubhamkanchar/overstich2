@extends('backend.admin.layouts.app')

@section('content')
<div class="grey-bg container-fluid admin-category">
    <div class="row">
        <div class="col-xl-12 col-sm-12 col-12">
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
    </div>
</div>
@endsection