@extends('backend.seller.layouts.app')

@section('content')
<div class="grey-bg container">
    <div class="row">
        <div class="col-xl-12 col-sm-12 col-12">
            <form method="POST" action="{{ route('categories.update',$category->id) }}" >
                <div class="card">
                    <div class="card-content">
                        <div class="card-header">Add Category</div>
                        <div class="card-body">
                            @csrf
                            @method('PATCH')
                            <div class="form-group row">
                                <div class="col-md-6 mt-2">
                                    <label>Category Name</label>
                                    <input class="form-control" name="name" placeholder="Category Name" value="{{ $category->category }}" required>
                                </div>
                                <div class="col-md-6  mt-2">
                                    <label>Category Type</label>
                                    <select class="form-select" name="parent_id">
                                        <option value="">Category Type</option>
                                        @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}" @if($cat->id == $category->parent_id) selected @endif>{{ $cat->category }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6  mt-2">
                                    <label>Category Status</label>
                                    <select class="form-select" name="is_active" required>
                                        <option value="">Category Status</option>
                                        <option value="1" @if($category->is_active == '1') selected @endif>Active</option>
                                        <option value="0" @if($category->is_active == '0') selected @endif>In-Active</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success">Add Category</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection