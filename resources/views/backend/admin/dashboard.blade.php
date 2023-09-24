@extends('backend.layouts.app')

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
                                <h3>278</h3>
                                <span>New Posts</span>
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
                                <i class="icon-speech warning font-large-2 float-left"></i>
                            </div>
                            <div class="media-body text-end w-50">
                                <h3>156</h3>
                                <span>New Comments</span>
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
                                <i class="icon-graph success font-large-2 float-left"></i>
                            </div>
                            <div class="media-body text-end w-50">
                                <h3>64.89 %</h3>
                                <span>Bounce Rate</span>
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
                                <i class="icon-pointer danger font-large-2 float-left"></i>
                            </div>
                            <div class="media-body text-end w-50">
                                <h3>423</h3>
                                <span>Total Visits</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection