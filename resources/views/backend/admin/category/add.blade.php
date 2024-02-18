@extends('backend.admin.layouts.app')

@section('content')
<div class="grey-bg container admin-category">
    <div class="row">
        <div class="col-xl-12 col-sm-12 col-12">
            <form method="POST" action="{{ route('categories.store') }}" id="categoryForm">
                <div class="card">
                    <div class="card-content">
                        <div class="card-header">Add Category</div>
                        <div class="card-body">
                            @csrf
                            <div class="form-group row">
                                <div class="col-md-6 mt-2">
                                    <label>Category Name</label>
                                    <input class="form-control" name="name" placeholder="Category Name" required>
                                </div>
                                <div class="col-md-6  mt-2">
                                    <label>Master Category</label>
                                    <select class="form-select" data-route="{{ route('admin.get-sub-categories', ':categoryId') }}" id="masterCategory" name="parent_id">
                                        <option value="">Master Category</option>
                                        @foreach($category as $cat)
                                            <option value="{{ $cat->id }}">{{ $cat->category }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6  mt-2">
                                    <label>SubCategory</label>
                                    <select class="form-select" id="subCategory" name="subcategory_id">
                                        <option value="">Sub Category</option>
                                        @foreach($subCategory as $sub)
                                            <option value="{{ $sub->id }}">{{ $sub->category }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6  mt-2">
                                    <label>Category Status</label>
                                    <select class="form-select" name="is_active" required>
                                        {{-- <option value="">Category Status</option> --}}
                                        <option value="1">Active</option>
                                        <option value="0">In-Active</option>
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