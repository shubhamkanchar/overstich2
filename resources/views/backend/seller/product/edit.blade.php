@extends('backend.seller.layouts.app')

@section('content')
<div class="grey-bg container seller-product">
    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-content">
                    <div class="card-header">Edit Product</div>
                    <form id="productForm" method="POST" action="{{ route('seller.products.update', $product->slug) }}" novalidate>
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="form-group row">
                                <div class="col-12 col-md-4 mb-3">
                                    <label for="title" class="form-label">Title</label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror" placeholder="Title" id="title" name="title" value="{{ old('title', $product->title) }}" required>
                                    @error('title')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-12 col-md-4 mb-3">
                                    <label for="category" class="form-label">Category</label>
                                    <select class="form-select @error('category_id') is-invalid @enderror" name="category_id" id="category" data-route="{{ route('seller.get-category', [':categoryId']) }}" >
                                        <option value="" selected disabled>Category Type</option>
                                        @foreach($category as $cat)
                                            <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->category }}</option>
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
                                            <option value="{{ $subCat->id }}" {{ old('child_category_id', $product->child_category_id) == $subCat->id ? 'selected' : '' }}>{{ $subCat->category }}</option>
                                        @endforeach
                                    </select>
                                    @error('child_category_id')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div> --}}

                                <div class="col-12 col-md-4 mb-3">
                                    <label for="brand" class="form-label">Brand</label>
                                    <input type="text" class="form-control @error('brand') is-invalid @enderror" placeholder="Brand" id="brand" name="brand" value="{{ old('brand', $product->brand) }}">
                                    @error('brand')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                
                                <div class="col-12 col-md-4 mb-3">
                                    <label for="color" class="form-label">Color</label>
                                    <input type="text" class="form-control @error('color') is-invalid @enderror" placeholder="Color" id="color" name="color" value="{{ old('color', $product->color) }}">
                                    @error('color')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>   

                                <div class="col-12 col-md-4 mb-3">
                                    <label for="price" class="form-label">Price</label>
                                    <input type="number" step="0.01" placeholder="Price" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price', $product->price) }}" required>
                                    @error('price')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-12 col-md-4 mb-3">
                                    <label for="discount" class="form-label">Discount</label>
                                    <input type="number" step="0.5" min="0" max="100" placeholder="1-100%" class="form-control @error('discount') is-invalid @enderror" id="discount" name="discount" value="{{ old('discount', $product->discount) }}">
                                    @error('discount')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                
                                <div class="col-12 col-md-4 mb-3">
                                    <label for="condition" class="form-label">Condition</label>
                                    <select class="form-select @error('condition') is-invalid @enderror" id="condition" name="condition">
                                        <option value="default" {{ old('condition', $product->condition) == 'default' ? 'selected' : '' }}>Default</option>
                                        <option value="new" {{ old('condition', $product->condition) == 'new' ? 'selected' : '' }}>New</option>
                                        <option value="hot" {{ old('condition', $product->condition) == 'hot' ? 'selected' : '' }}>Hot</option>
                                    </select>
                                    @error('condition')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                
                                <div class="col-12 col-md-4 mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-select @error('status') is-invalid @enderror" id="status" name="status">
                                        <option value="active" {{ old('status', $product->status) == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ old('status', $product->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                    @error('status')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>    
                                <div class="col-12 col-md-12 row p-3 mb-3" id="sizeContainer">
                                    <label for="size" class="form-label">Size and Quantity</label>
                                    @if (count($productSizes) > 0)
                                        @foreach ($productSizes as $size)
                                            <div class="size-row row mb-2 col-8">
                                                <div class="col-4">
                                                    <input type="text" class="form-control size-input" placeholder="Size" value="{{ $size->size}}" name="size[{{$loop->index}}]" required>
                                                </div>
                                                <div class="col-4">
                                                    <input type="number" class="form-control quantity-input" placeholder="Quantity" value="{{ $size->quantity}}" name="quantity[{{$loop->index}}]" required>
                                                </div>
                                                @if ($loop->index == 0)
                                                    <div class="col-4 add-size-row">
                                                        <button type="button" class="btn btn-primary add-size-btn">Add More Sizes</button>
                                                    </div>
                                                @else
                                                    <div class="col-4 add-size-row">
                                                        <button type="button" class="btn btn-danger remove-size-btn">Remove</button>
                                                    </div>
                                                @endif
                                                
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="size-row row mb-2 col-8">
                                            <div class="col-4">
                                                <input type="text" class="form-control size-input" placeholder="Size" name="size[0]" required>
                                            </div>
                                            <div class="col-4">
                                                <input type="number" class="form-control quantity-input" placeholder="Quantity" name="quantity[0]" required>
                                            </div>
                                            <div class="col-4 add-size-row">
                                                <button type="button" class="btn btn-primary add-size-btn">Add More Sizes</button>
                                            </div>
                                        </div>
                                    @endif
                                
                                </div>
                                <div class="col-12 col-md-12 mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description">{{ old('description', $product->description) }}</textarea>
                                    @error('description')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>                    
                            </div>
                        </div>
                        <div class="card-footer">                            
                            <button type="submit" class="btn btn-success">Update Product</button>
                        </div> 
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
