@extends('backend.admin.layouts.app')

@section('content')
<div class="grey-bg container admin-category">
    <div class="row">
        <div class="col-xl-12 col-sm-12 col-12">
            <form method="POST" action="{{ route('ads.store') }}" id="categoryForm" enctype="multipart/form-data">
                <div class="card">
                    <div class="card-content">
                        <div class="card-header">Add Advertisement</div>
                        <div class="card-body">
                            @csrf
                            <div class="form-group row">
                                <div class="col-md-6 mt-2">
                                    <label>Ad Link</label>
                                    <input type="url" class="form-control" name="link" placeholder="Ad Link" required>
                                </div>
                                
                                <div class="col-md-6  mt-2">
                                    <label>Ad location</label>
                                    <select class="form-select" name="type" >
                                        <option value="top">Top</option>
                                        <option value="left">Middle Left</option>
                                        <option value="right">Middle Right</option>
                                        <option value="bottom">Bottom</option>
                                    </select>
                                </div>
                                <div class="col-md-6  mt-2">
                                    <label>Ad Status</label>
                                    <select class="form-select" name="status" required>
                                        <option value="1">Active</option>
                                        <option value="0">In-Active</option>
                                    </select>
                                </div>
                                <div class="col-md-6  mt-2">
                                    <label>Ad Banner</label>
                                    <input type="file" value="banner" name="file" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success">Add Advertisement</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection