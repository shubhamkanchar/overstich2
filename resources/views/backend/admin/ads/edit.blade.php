@extends('backend.admin.layouts.app')

@section('content')
<div class="grey-bg container admin-category">
    <div class="row">
        <div class="col-xl-12 col-sm-12 col-12">
            <form method="POST" action="{{ route('ads.update',$adsModel->id) }}" id="categoryForm" enctype="multipart/form-data">
                @method('PUT');
                <div class="card">
                    <div class="card-content">
                        <div class="card-header">Update Advertisement</div>
                        <div class="card-body">
                            @csrf
                            <div class="form-group row">
                                <div class="col-md-6 mt-2">
                                    <label>Ad Link</label>
                                    <input type="url" class="form-control" name="link" placeholder="Ad Link" required value="{{ $adsModel->link }}">
                                </div>
                                
                                <div class="col-md-6  mt-2">
                                    <label>Ad location</label>
                                    <select class="form-select" name="type" >
                                        <option value="top" @if($adsModel->location == 'top') selected @endif>Top</option>
                                        <option value="left" @if($adsModel->location == 'left') selected @endif>Middle Left</option>
                                        <option value="right" @if($adsModel->location == 'right') selected @endif>Middle Right</option>
                                        <option value="bottom" @if($adsModel->location == 'bottom') selected @endif>Bottom</option>
                                    </select>
                                </div>
                                <div class="col-md-6  mt-2">
                                    <label>Ad Status</label>
                                    <select class="form-select" name="status" required>
                                        <option value="1" @if($adsModel->status == '1') selected @endif>Active</option>
                                        <option value="0" @if($adsModel->status == '0') selected @endif>In-Active</option>
                                    </select>
                                </div>
                                <div class="col-md-6  mt-2">
                                    <label>Ad Banner</label>
                                    <input type="file" value="banner" name="file" class="form-control">
                                    <img class="aspect-img mt-2" style="height:100px" src="{{ asset('image/banner/'.$adsModel->file) }}">
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success">Update Advertisement</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection