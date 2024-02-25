<form action="{{ route('seller.account.products.details') }}" id="passwordForm" method="post" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-md-6 p-3">
            <label>Products</label>
            <input class="form-control" type="text" name="product" placeholder="Casual Men t-shirts, formal shirts"
            value="{{ old('product', $user->sellerInfo->products ?? '') }}" required>
            @error('product')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="col-md-6 p-3">
            <label>Category</label>
            <input class="form-control" type="text" name="category" placeholder="Clothing, footwear, jewellery etc.*"
            value="{{ old('category', $user->sellerInfo->category ?? '') }}" required>
            @error('category')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="col-md-6 p-3">
            <label>Product price range</label>
            <input class="form-control" type="text" name="price_range"
                placeholder="Rs.500 - 1500, Rs.700 - 3000, etc." value="{{ old('price_range', $user->sellerInfo->price_range ?? '') }}" required>
            @error('price_range')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="col-md-6 p-3">
            <label>Upload product photos</label>
            <input class="form-control" accept="image/*" type="file" name="product_photos[]"
                placeholder="Minimum 5 photos" multiple required min="5" max="7">
            @error('product_photos')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </div>
</form>
