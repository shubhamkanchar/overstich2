@extends('backend.admin.layouts.app')

@section('content')
<div class="grey-bg container admin-category">
    <div class="row">
        <div class="col-xl-12 col-sm-12 col-12">
            <form method="POST" action="{{ route('categories.store') }}" id="categoryForm">
                <div class="card">
                    <div class="card-content">
                        <div class="card-header">Add Filter</div>
                        <div class="card-body">
                            @csrf
                            <div class="form-group row">
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