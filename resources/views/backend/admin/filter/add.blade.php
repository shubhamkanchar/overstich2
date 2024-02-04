@extends('backend.admin.layouts.app')

@section('content')
<div class="grey-bg container admin-category">
    <div class="row">
        <div class="col-xl-12 col-sm-12 col-12">
            <form method="POST" action="{{ route('category.filters.add') }}" id="categoryForm">
                <div class="card">
                    <div class="card-content">
                        <div class="card-header">
                            <h3>Add Filter</h3>  
                        </div>
                        <div class="card-body">
                            @csrf
                            <div class="form-group row">
                                <div class="col-md-6 col-12">
                                    <label class="form-lable">Category Type</label>
                                    <select class="form-select" name="category_id" placeholder="Category Type" required>
                                        @foreach ($categories as $category)
                                            <option value="{{$category->id}}" >{{$category->category}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label>Filter Type</label>
                                    <input class="form-control" name="type" placeholder="Filter Type" required>
                                </div>
                                <div class="col-12 col-md-12">
                                    <label>Values</label>
                                    <input class="form-control" name="type_values" placeholder="Add multiple value by comma seperate" required>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success">Add Filter</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection