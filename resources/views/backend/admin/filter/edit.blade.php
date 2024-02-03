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