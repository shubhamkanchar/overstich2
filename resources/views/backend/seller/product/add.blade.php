@extends('backend.seller.layouts.app')

@section('content')
<div class="grey-bg container seller-product">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-header">Add Product</div>
                    <form id="productForm" method="POST" action="{{ route('seller.products.store') }}" enctype="multipart/form-data">
                        <div class="card-body">
                            @csrf 
                            <div class="form-group row">
                                <div class="col-12 col-md-4 mb-3">
                                    <label for="title" class="form-label">Title</label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror" placeholder="Title" id="title" name="title" value="{{ old('title') }}" required>
                                    @error('title')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-12 col-md-4 mb-3">
                                    <label for="category" class="form-label">Master Category</label>
                                    <select class="form-select @error('master_category_id') is-invalid @enderror" name="master_category_id" id="masterCategory" data-route="{{ route('seller.get-category', [':categoryId']) }}" >
                                        <option value="" selected disabled>Master Category Type</option>
                                        @foreach($masterCategory as $master)
                                            <option value="{{ $master->id }}" {{ old('master_category_id') == $master->id ? 'selected' : '' }}>{{ $master->category }}</option>
                                        @endforeach
                                    </select>
                                    @error('masterCategory')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-12 col-md-4 mb-3">
                                    <label for="category" class="form-label">Sub Category</label>
                                    <select class="form-select @error('subcategory_id') is-invalid @enderror" name="subcategory_id" id="subCategory" data-route="{{ route('seller.get-child-categories', [':categoryId']) }}">
                                        <option value="" selected disabled>Sub Category Type</option>
                                        @foreach($subCategory as $sub)
                                            <option value="{{ $sub->id }}" {{ old('subcategory_id') == $sub->id ? 'selected' : '' }}>{{ $sub->category }}</option>
                                        @endforeach
                                    </select>
                                    @error('subcategory')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-12 col-md-4 mb-3">
                                    <label for="category" class="form-label">Category</label>
                                    <select class="form-select @error('category_id') is-invalid @enderror" name="category_id" id="category" data-route="{{ route('seller.get-filter-type', ':categoryId')}}">
                                        <option value="" selected disabled>Category Type</option>
                                        @foreach($category as $cat)
                                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->category }}</option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- <div class="col-12 col-md-4 mb-3">
                                    <label for="subCategory" class="form-label">Sub Category</label>
                                    <select class="form-select @error('child_category_id') is-invalid @enderror" name="child_category_id" id="subCategory">
                                        <option value="" selected disabled>Sub Category</option>
                                        @foreach($subCategory as $subCat)
                                            <option value="{{ $subCat->id }}" {{ old('child_category_id') == $subCat->id ? 'selected' : '' }}>{{ $subCat->category }}</option>
                                        @endforeach
                                    </select>
                                    @error('child_category_id')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div> --}}

                                <div class="col-12 col-md-4 mb-3">
                                    <label for="brand" class="form-label">Brand</label>
                                    <input type="text" class="form-control @error('brand') is-invalid @enderror" placeholder="Brand" id="brand" name="brand" value="{{ old('brand') }}">
                                    @error('brand')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                
                                {{-- <div class="col-12 col-md-4 mb-3">
                                    <label for="color" class="form-label">Color</label>
                                    <input type="text" class="form-control @error('color') is-invalid @enderror" placeholder="Color" id="color" name="color" value="{{ old('color') }}">
                                    @error('color')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>  --}}
                                
                                <div class="col-12 col-md-4 mb-3">
                                    <label for="hsn" class="form-label">Hsn Code</label>
                                    <input type="text" placeholder="hsn" class="form-control @error('hsn') is-invalid @enderror" id="hsn" name="hsn"  required value="{{ old('hsn') }}">
                                    @error('hsn')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                
                                <div class="col-12 col-md-4 mb-3">
                                    <label for="netPrice" class="form-label">Gross Amount</label>
                                    <input type="number" placeholder="Gross Amount" class="form-control @error('price') is-invalid @enderror" id="netPrice" name="net_price" value="{{ old('net_price') }}" required>
                                    @error('net_price')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-12 col-md-4 mb-3">
                                    <label for="discount" class="form-label">Discount Percenatge (%)</label>
                                    <input type="number" min="0" max="100" placeholder="1-100%" class="form-control @error('discount') is-invalid @enderror" id="discount" name="discount" value="{{ old('discount') }}">
                                    @error('discount')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-12 col-md-4 mb-3">
                                    <label for="price" class="form-label">Taxable Amount</label>
                                    <input type="number" placeholder="Price" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price') }}" required readonly>
                                    @error('price')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-12 col-md-4 mb-3">
                                    <label for="gst" class="form-label">GST Percentage (%)</label>
                                    <input type="number" placeholder="GST" class="form-control @error('gst') is-invalid @enderror" id="gst" value="{{ old('gst') }}" required>
                                    @error('gst')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-12 col-md-4 mb-3 d-none">
                                    <label for="cgst" class="form-label">CGST Percentage (%)</label>
                                    <input type="number" placeholder="CGST" class="form-control @error('cgst') is-invalid @enderror" id="cgst" name="cgst" value="{{ old('cgst') }}" required>
                                    @error('cgst')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-12 col-md-4 mb-3 d-none">
                                    <label for="sgst" class="form-label">SGST Percentage (%)</label>
                                    <input type="number" placeholder="CGST" class="form-control @error('sgst') is-invalid @enderror" id="sgst" name="sgst" value="{{ old('sgst') }}" required>
                                    @error('sgst')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-12 col-md-4 mb-3">
                                    <label for="finalPrice" class="form-label">Final selling price</label>
                                    <input type="number" placeholder="Final selling price" class="form-control @error('final_price') is-invalid @enderror" id="finalPrice" name="final_price" value="{{ old('final_price') }}" readonly>
                                    @error('final_price')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                
                                <div class="col-12 col-md-4 mb-3">
                                    <label for="condition" class="form-label">Condition</label>
                                    <select class="form-select @error('condition') is-invalid @enderror" id="condition" name="condition">
                                        <option value="default" {{ old('condition') == 'default' ? 'selected' : '' }}>Default</option>
                                        <option value="new" {{ old('condition') == 'new' ? 'selected' : '' }}>New</option>
                                        <option value="hot" {{ old('condition') == 'hot' ? 'selected' : '' }}>Hot</option>
                                    </select>
                                    @error('condition')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                
                                <div class="col-12 col-md-4 mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-select @error('status') is-invalid @enderror" id="status" name="status">
                                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                    @error('status')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-12 col-md-6 mt-4 mb-3">
                                    <div class="form-check form-check-inline">
                                        <input name="return" class="form-check-input" type="checkbox" value="1"
                                            id="flexCheckDefault" checked>
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Return Available
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input name="replace" class="form-check-input" type="checkbox" value="1"
                                            id="flexCheckChecked" checked>
                                        <label class="form-check-label" for="flexCheckChecked">
                                            Replace Available
                                        </label>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <label class="form-label">Upload product images</label>
                                    <input class="form-control @error('product_images') is-invalid @enderror" accept="image/*" type="file" name="product_images[]" placeholder="Minimum 5 images" multiple>
                                    @error('product_images')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-12 col-md-4">
                                    <label class="form-label">Size Chart</label>
                                    <input class="form-control" accept="image/*" type="file" name="size_chart" placeholder="Size Chart">
                                </div>
                                <div class="mt-2 row justify-content-around">
                                    <div class="col col-md-5">
                                        <label>Filter Type</label>
                                        <input type="text" class="form-control filter-type" data-target="#filterValue" placeholder="Filter Type" required value="Color" readonly>
                                    </div>
                                    <div class="col col-md-5">
                                        <label>Value</label>
                                        <input type="text" class="form-control filter-values" placeholder="Value" id="color" name="color" value="{{ old('color') }}" required >
                                        @error('color')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col col-md-2">
                                        
                                    </div>
                                </div>
                                <div class="mt-2 filter-row row justify-content-around" data-max="0" data-route="{{ route('seller.get-filter-values', ':categoryFilter')}}">
                                    
                                    <div class="col col-md-5">
                                        <label>Filter Type</label>
                                        <select class="form-select filter-type" name="types[0]" data-target="#filterValue" placeholder="Filter Type" required>
                                            <option value="">Select Filter</option>
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

                                <div class="col-12 col-md-8 row p-3 mb-3" id="sizeContainer">
                                    <label for="size" class="form-label">Size and Quantity</label>
                                    <div class="size-row row mb-2 col-md-8 col-12">
                                        <div class="col-4">
                                            <input type="text" class="form-control size-input" placeholder="Size" name="size[0]" required>
                                        </div>
                                        <div class="col-4">
                                            <input type="number" class="form-control quantity-input" placeholder="Quantity" name="quantity[0]" required>
                                        </div>
                                        <div class="col-4 add-size-row">
                                            <button type="button" class="btn btn-primary add-size-btn text-nowrap">Add More Sizes</button>
                                        </div>
                                    </div>
                                
                                </div>

                                <div class="col-12 col-md-12 mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control @error('') is-invalid @enderror" id="description" name="description">{{ old('description') }}</textarea>
                                    @error('description')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>                    
                            </div>
                        </div>
                        <div class="card-footer">                            
                            <button type="submit" class="btn btn-success">Create Product</button>
                        </div> 
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection