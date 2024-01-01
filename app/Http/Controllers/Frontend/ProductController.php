<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
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
        if($categoryId) {
            $category = Category::find($categoryId);
            $categoryIds = $category->allChildrenId();
            $products = $products->whereIn('category_id', $categoryIds);
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
        $product = Product::with(['images', 'seller', 'seller.sellerInfo', 'sizes'])->where('slug', $slug)->first();
        $seller = $product->seller;
        $sellerInfo = $product->seller?->sellerInfo;
        $productIds = Wishlist::where('user_id', $userId)->pluck('product_id')->toArray();
        return view('frontend.product.details', compact('product', 'seller', 'sellerInfo', 'productIds'));
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

    public function getProductByBrand(Request $request, $sellerId = null) {
        $user = auth()->user();
        $userId = session()->getId();
        if($user = auth()->user()) {
            $userId = $user->id;
        }
        $productIds = Wishlist::where('user_id', $userId)->pluck('product_id')->toArray();
        $products = Product::with('images')->where('status', 'active');
        
        if($sellerId) {
            $products = $products->where('seller_id', $sellerId);
            $seller = User::find($sellerId)->where(['user_type' => 'seller'])->with(['sellerInfo'])->first();
        }

        if($seller) {
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
