@extends('backend.admin.layouts.app')

@section('content')
<div class="grey-bg container admin-category">
    <div class="row">
        <div class="col-xl-12 col-sm-12 col-12">
            <form method="POST" action="{{ route('categories.update',$category->id) }}" id="categoryForm">
                <div class="card">
                    <div class="card-content">
                        <div class="card-header">Edit Category</div>
                        <div class="card-body">
                            @csrf
                            @method('PATCH')
                            <div class="form-group row">
                                <div class="col-md-6 mt-2">
                                    <label>Category Name</label>
                                    <input class="form-control" name="name" placeholder="Category Name" value="{{ $category->category }}" required>
                                </div>
                                <div class="col-md-6  mt-2">
                                    <label>Master Category</label>
                                    <select class="form-select" name="parent_id" id="masterCategory" data-route="{{ route('admin.get-sub-categories', ':categoryId') }}" required>
                                        <option value="">Master Category</option>
                                        @foreach($categories as $cat)
                                            <option value="{{ $cat->id }}" @if($cat->id == $category->parent_id) selected @endif>{{ $cat->category }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6  mt-2">
                                    <label>Sub Category</label>
                                    <select class="form-select" name="subcategory_id" id="subCategory">
                                        <option value="">Sub Category</option>
                                        @foreach($subCategory as $sub)
                                            <option value="{{ $sub->id }}" @selected($sub->id == $category->subcategory_id)>{{ $sub->category }}</option>
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
                            @if (count($category->filters))
                                @foreach ($category->filters as $filter)
                                <div class="col-12 mt-2 filter-row row">
                                        <input type="hidden" class="filter_id" name="filter_id[{{$loop->index}}]" value="{{ $filter->id }}">
                                        <div class="col col-md-2">
                                            <label>Filter Type</label>
                                            <input class="form-control" name="types[{{$loop->index}}]" value="{{ $filter->type }}" placeholder="Category Type" required>
                                        </div>
                                        <div class="col col-md-8">
                                            <label>Values</label>
                                            <input class="form-control" name="type_values[{{$loop->index}}]" value="{{ implode(',', json_decode($filter->value))}}" placeholder="Add multiple value by comma seperate" required>
                                        </div>
                                        @if ($loop->index == 0)
                                            <div class="col col-md-2">
                                                <label> &nbsp;</label>
                                                <button type="button" class="form-control btn btn-primary add-filter">Add Filters</button>
                                            </div>
                                        @else
                                            <div class="col col-md-2">
                                                <label> &nbsp;</label>
                                                <button type="button" class="form-control btn btn-danger remove">Remove</button>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            @else
                                <div class="col-12 mt-2 filter-row row">
                                    <div class="col col-md-2">
                                        <label>Filter Type</label>
                                        <input class="form-control" name="types[0]" placeholder="Category Type" required>
                                    </div>
                                    <div class="col col-md-8">
                                        <label>Values</label>
                                        <input class="form-control" name="type_values[0]" placeholder="Add multiple value by comma seperate" required>
                                    </div>
                                    <div class="col col-md-2">
                                        <label> &nbsp;</label>
                                        <button type="button" class="form-control btn btn-primary add-filter">Add Filters</button>
                                    </div>
                                </div>
                            @endif
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success">Edit Category</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection