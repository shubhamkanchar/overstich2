<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductFilter;
use App\Models\ProductSize;
use App\Models\SellerInfo;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Cart;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $categoryId = null)
    {
        $filters = $request->except(['search','size','brand']);
        $search = $request->search ?? '';
        $selectedBrands = $request->brand ?? [];
        $selectedSizes = $request->size ?? [];
        $user = auth()->user();
        $userId = session()->getId();
        if($user = auth()->user()) {
            $userId = $user->id;
        }
        $productIds = Wishlist::where('user_id', $userId)->pluck('product_id')->toArray();
        $products = Product::with(['images','seller'])->where('status', 'active');

        if($filters) {
            $products = $products->whereHas('filters', function($q) use ($filters) {
                $q->where(function($query) use ($filters) {
                    $condition = 'where';
                    foreach($filters as $key => $filter) {
                        foreach($filter as $filterValue) {
                            $query->{$condition}(['value' => $filterValue, 'type' => $key]);
                            $condition = 'orWhere';
                        }
                    }
                });  
            });
        }

        $products = $products->when(!empty($search), function($query) use ($search) {
            $query->where('title', 'like', '%' . $search . '%');
        })->when(count($selectedSizes) > 0, function ($query) use ($selectedSizes) {
            $query->whereHas('sizes', function ($subQuery) use ($selectedSizes) {
                $subQuery->whereIn('size', $selectedSizes);
            });
        })
        ->when(count($selectedBrands) > 0, function ($query) use ($selectedBrands) {
            $query->whereIn('seller_id', $selectedBrands);
        }); 

        
        $category = '';
        if($categoryId) {
            $category = Category::where('id', $categoryId)->with(['filters','parentSubCategory', 'masterCategory'])->first();
            $products = $products->where(function($query) use ($categoryId) {
                $query->where('master_category_id', $categoryId)
                ->orWhere('subcategory_id', $categoryId)
                ->orWhere('category_id', $categoryId);
            });
        }else{
            $category = Category::with(['filters','parentSubCategory', 'masterCategory'])->first();
        }

        $sizes = ProductSize::get()->unique('size')->pluck('size', 'id');
        $brands = SellerInfo::whereHas('seller', function($query) {
            $query->where('is_active', 1);
        })->pluck('brand', 'seller_id');
        $categoryFilters = is_null($category->parent_id) ? $category->filters : $category->masterCategory->filters;
        $products = $products->paginate(20);
        return view('frontend.product.index', compact('products', 'productIds', 'category', 'search', 'filters', 'sizes', 'brands', 'selectedSizes', 'selectedBrands','categoryFilters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug)
    {
        $user = auth()->user();
        $userId = session()->getId();
        if($user = auth()->user()) {
            $userId = $user->id;
        }
        $product = Product::with(['images', 'seller', 'seller.sellerInfo', 'sizes', 'ratings', 'ratings.user'])->withCount('ratings')->where('slug', $slug)->first();
        $seller = $product->seller;
        $sellerInfo = $product->seller?->sellerInfo;
        $productIds = Wishlist::where('user_id', $userId)->pluck('product_id')->toArray();
        $averageStarRating = round($product->ratings->avg('star'), 2);
        $averageTransparencyRating = $product->ratings->avg('transparency');
        $averageFitRating = $product->ratings->avg('fit');
        $averageLengthRating = $product->ratings->avg('length');
        $productFilters = ProductFilter::where('product_id',$product->id)->get();
        return view('frontend.product.details', compact('product', 'seller', 'sellerInfo', 'productIds', 'averageLengthRating', 'averageFitRating', 'averageTransparencyRating', 'averageStarRating', 'user','productFilters'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    public function getProductByBrand(Request $request,$slug) {
        
        $user = auth()->user();
        $userId = session()->getId();
        if($user = auth()->user()) {
            $userId = $user->id;
        }
        $search = $request->search ?? '';
        $productIds = Wishlist::where('user_id', $userId)->pluck('product_id')->toArray();
        $products = Product::with('images')->where('status', 'active');
        
        $seller = User::whereHas('sellerInfo', function($q) use ($slug) {
            $q->where('slug', $slug);
        })->with(['sellerInfo'])->first();
        
        $category = Category::with(['filters','parentSubCategory', 'masterCategory'])->first();
        $filters = [];
        if($seller) {
            $products = $products->where('seller_id', $seller->id);
            $products = $products->paginate(20);
            return view('frontend.product.index', compact('category','search','products', 'productIds', 'seller','filters')); 
        } 

        return redirect()->route('products.index');
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
