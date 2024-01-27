@extends('backend.seller.layouts.app')

@section('content')
<div class="grey-bg container seller-product">
    <div class="row">
        <div class="col-12">
            <div class="card">
                @if ($product->category?->filters?->count() > 0)
                    <div class="card-content">
                        <div class="card-header">Add Filters</div>
                        <form id="productfilter" method="POST" action="{{ route('seller.products.filters.store') }}">
                            <div class="card-body" data-max="{{ count($product->category?->filters) }}" data-route="{{ route('seller.get-filter-values', ':categoryFilter')}}">   
                                <input type="hidden" name="product_id" value="{{$product->id}}">
                                @csrf
                                @if ($product->filters->count() > 0)
                                    @foreach ($product->filters as $productFilter)
                                        <div class="mt-2 mb-2 filter-row row justify-content-around">
                                            @php $values = json_decode($productFilter?->categoryFilter->value); @endphp
                                            <div class="col col-md-5">
                                                <label>Filter Type</label>
                                                <select class="form-select filter-type" name="types[{{$loop->index}}]" data-target="#filterValue{{$loop->index}}" placeholder="Filter Type" required>
                                                    <option value="">Select Filter</option>
                                                    @foreach ($product->category?->filters as $filter)
                                                        <option value="{{$filter->id}}" @selected($productFilter->filter_id == $filter->id)>{{ $filter->type}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col col-md-5">
                                                <label>Value</label>
                                                <select class="form-select filter-values" name="type_values[{{$loop->index}}]" id="filterValue{{$loop->index}}" placeholder="Value" required>
                                                    <option value="">Select Value</option>
                                                    @foreach ($values as $value)
                                                        <option value="{{ $value }}" @selected($productFilter->value == $value)>{{ $value}}</option>
                                                    @endforeach
                                                </select>
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
                                    <div class="mt-2 filter-row row justify-content-around">
                                        <div class="col col-md-5">
                                            <label>Filter Type</label>
                                            <select class="form-select filter-type" name="types[0]" data-target="#filterValue" placeholder="Filter Type" required>
                                                <option value="">Select Filter</option>
                                                @foreach ($product->category?->filters as $filter)
                                                    <option value="{{$filter->id}}">{{ $filter->type}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col col-md-5">
                                            <label>Value</label>
                                            <select class="form-select filter-values" name="type_values[0]" id="filterValue" placeholder="Value" required>
                                                <option value="">Select Value</option>
                                            </select>
                                        </div>
                                        <div class="col col-md-2">
                                            <label> &nbsp;</label>
                                            <button type="button" class="form-control btn btn-primary add-filter">Add Filters</button>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="card-footer">                            
                                <button type="submit" class="btn btn-success">Submit</button>
                            </div> 
                        </form>
                    </div>
                @else
                    <div class="card-header">
                        <div class="card-title">Filters</div>
                    </div>
                    <div class="card-body">
                        <h3 class="text-center">No filters found for this category</h3>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
    <script type="module">

        $(function() {
            
            
        })
    </script>
@endpush