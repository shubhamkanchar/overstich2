<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
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
        $user = auth()->user();
        $userId = session()->getId();
        if($user = auth()->user()) {
            $userId = $user->id;
        }
        $productIds = Wishlist::where('user_id', $userId)->pluck('product_id')->toArray();
        $products = Product::with('images')->where('status', 'active');
        $category = '';
        if($categoryId) {
            $category = Category::where('id', $categoryId)->with('filters')->first();
            $products = $products->where(function($query) use ($categoryId) {
                $query->where('master_category_id', $categoryId)
                ->orWhere('subcategory_id', $categoryId)
                ->orWhere('category_id', $categoryId);
            });
            
        }

        $products = $products->paginate(20);
        return view('frontend.product.index', compact('products', 'productIds', 'category'));
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
        return view('frontend.product.details', compact('product', 'seller', 'sellerInfo', 'productIds', 'averageLengthRating', 'averageFitRating', 'averageTransparencyRating', 'averageStarRating', 'user'));
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
        $productIds = Wishlist::where('user_id', $userId)->pluck('product_id')->toArray();
        $products = Product::with('images')->where('status', 'active');
        
        $seller = User::whereHas('sellerInfo', function($q) use ($slug) {
            $q->where('slug', $slug);
        })->with(['sellerInfo'])->first();

        if($seller) {
            $products = $products->where('seller_id', $seller->id);
            $products = $products->paginate(20);
            return view('frontend.product.product-brand', compact('products', 'productIds', 'seller')); 
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
