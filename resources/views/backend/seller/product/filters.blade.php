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
            let index = $('.filter-row').length;
            let maxFilters = $('.card-body').data('max');
            let getFilterUrl = $('.card-body').data('route');

            $('.add-filter').on('click', function () {
                if($('.filter-row').length < maxFilters) {
                    var newRow = $('.filter-row:first').clone();
                    newRow.find('.filter_id').remove(); 
                    newRow.find('select[name="types[0]"]').data('target','#filterValue'+index);
                    newRow.find('select[name="types[0]"]').val('');
                    newRow.find('select[name="types[0]"]').attr('name', 'types[' + index + ']');
                    newRow.find('select[name="type_values[0]"]').attr('id', 'filterValue'+index);
                    newRow.find('select[name="type_values[0]"]').empty();
                    newRow.find('select[name="type_values[0]"]').append($("<option value=''>Select Value</option>"));
                    newRow.find('select[name="type_values[0]"]').attr('name', 'type_values[' + index + ']');
                    newRow.find('button.add-filter').removeClass('add-filter').addClass('remove btn-danger').text('Remove');
                    $('.filter-row:last').after(newRow);
                    index++;
                } else {
                    $('.add-filter').prop('disabled', true)
                    $('.add-filter').addClass('disabled')
                }
            });

            $('.container').on('click', '.remove', function () {
                $(this).closest('.filter-row').remove();
                if($('.add-filter').hasClass('disabled')) {
                    $('.add-filter').prop('disabled', true)
                    $('.add-filter').removeClass('disabled')
                }
            });

            $(document).on('change', '.filter-type',function(){
                let categoryFilter = $(this).val();
                let targetId = $(this).data('target');
                $.ajax({
                    method:"get",
                    url: getFilterUrl.replace(':categoryFilter', categoryFilter),
                    success: (res) =>{
                        $(targetId).empty();
                        $(targetId).append($("<option value=''>Select Value</option>"))
                        let values = JSON.parse(res.categoryFilter.value);
                        $.each(values, function(key, value){
                            $(targetId).append($("<option></option>")
                            .attr("value", value)
                            .text(value)); 
                        })
                    },
                    error: (err) => {

                    }
                });
                console.log(checkSelected(categoryFilter, $(this)), );
            })

            function checkSelected(val, element) {
                var ret = false;
                $(".filter-type").not(element).each(function() {
                    if ($(this).val() === val) {
                        ret = true;
                    }
                });
                return ret;
            }

            $.validator.addMethod("checkSelected", function(value, element) {
                return checkSelected(val, element);
            }, "Filter type must be unique");

            $('#productfilter').validate({
                rules: {
                    'types[]': {
                        required: true,
                        checkSelected: true
                    },
                    'type_values[]': {
                        required: true,
                    },
                },
                messages: {
                    'types[]': {
                        required: "Please select a filter type",
                        checkSelected: "Filter type must be unique"
                    },
                    'type_values[]': {
                        required: "Please select a value",
                    },
                },
            
            });
            
        })
    </script>
@endpush