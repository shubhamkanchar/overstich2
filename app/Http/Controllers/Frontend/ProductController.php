<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Cart;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $userIdentifier = session()->getId();
        if($user){
            $userIdentifier = $user->name.$user->id;
        }

        Cart::instance($userIdentifier)->restore($userIdentifier);
        $cartItems = Cart::instance($userIdentifier)->content();
        $addItems = [];
        foreach ($cartItems as $item) {
            $addItems[] = $item->id;
        }

        $products = Product::with('images')->where('status', 'active')->get();
        return view('frontend.product.index', compact('products', 'cartItems', 'addItems'));
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
        $product = Product::with(['images', 'seller', 'seller.sellerInfo', 'sizes'])->where('slug', $slug)->first();
        $seller = $product->seller;
        $sellerInfo = $product->seller?->sellerInfo;

        return view('frontend.product.details', compact('product', 'seller', 'sellerInfo'));
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
