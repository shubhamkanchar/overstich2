@extends('backend.admin.layouts.app')

@section('content')
<div class="grey-bg container admin-category">
    <div class="row">
        <div class="col-xl-12 col-sm-12 col-12">
            <form method="POST" action="{{ route('category.filters.update', $categoryFilter->id) }}" id="categoryForm">
                <div class="card">
                    <div class="card-content">
                        <div class="card-header">
                            <h3>Edit Category</h3> 
                        </div>
                        <div class="card-body">
                            @csrf
                            @method('PUT') 
                            <div class="form-group row">
                                <div class="col-md-6 col-12">
                                    <label class="form-lable">Category Type</label>
                                    <select class="form-select" name="category_id" placeholder="Category Type" required>
                                        @foreach ($categories as $category)
                                            <option value="{{$category->id}}" @selected($categoryFilter->category_id == $category->id)>{{$category->category}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label>Filter Type</label>
                                    <input class="form-control" name="type" placeholder="Filter Type" value="{{ $categoryFilter->type }}" required>
                                </div>
                                <div class="col-12 col-md-12">
                                    <label>Values</label>
                                    <input class="form-control" name="type_values" placeholder="Add multiple value by comma seperate" value="{{ implode(",", json_decode($categoryFilter->value)) }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success">Edit Filter</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection