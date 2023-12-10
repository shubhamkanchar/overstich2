<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Cart;
use Illuminate\Http\Request;

class CartController extends Controller
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
        $products = [];
        foreach ($cartItems as $item) {
            $products[$item->id] = Product::with('images')->where('id', $item->options?->product_id)->first();
        }

        $totalOriginalPrice = $cartItems->sum(function ($cartItem) {
            return $cartItem->options->original_price * $cartItem->qty;
        });
    
        $totalPrice = $cartItems->sum(function ($cartItem) {
            return $cartItem->price * $cartItem->qty;
        });
    
        $totalDiscount = $cartItems->sum(function ($cartItem) {
            return $cartItem->options->discount * $cartItem->qty;
        });

        $deliveryCharges = 0;
        return view('frontend.product.cart', compact( 'cartItems', 'products', 'totalDiscount', 'totalPrice', 'totalOriginalPrice', 'deliveryCharges'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $product = Product::where('slug', $request->slug)->with('images')->first();
        $user = auth()->user();
        $userIdentifier = session()->getId();

        if($user) {
            $userIdentifier = $user->name.$user->id;
        }

        // if($request->already_exist == '1') {
        //     Cart::instance($userIdentifier)->restore($userIdentifier);
        //     $cartItems = Cart::instance($userIdentifier)->content();

        //     $rowId = $cartItems->search(function ($cartItem, $rowId) use ($product) {
        //         return $cartItem->id === $product->slug;
        //     });

        //     Cart::instance($userIdentifier)->remove($rowId);
        //     Cart::store($userIdentifier);
        //     notify()->success('Product Removed From bag');
        //     return redirect()->back();
        // } 

        $firstImage = $product?->images?->first()->image_path;
        $discountedPrice = $product->price - ($product->price * ($product->discount / 100));
        $sizes = explode(',', $product->size);
        // dd($request->all());
        $size = $request->size ?? (!empty($sizes) ? $sizes[0] : '');
        Cart::instance($userIdentifier)->add($request->slug . '_' . $request->size, $product->title, 1, $discountedPrice, ['product_id' => $product->id,'size' => $size , 'original_price' => $product->price, 'discount_percentage' => $product->discount, 'discount' => $product->price - $discountedPrice,'image' => $firstImage, 'seller_id' => $product->seller_id ])->associate('App\Models\Product');
        if($user) {
            Cart::store($userIdentifier); 
        }
        
        notify()->success('Product Added to bag successfully');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $user = auth()->user();
        $userIdentifier = session()->getId();
        if($user) {
            $userIdentifier = $user->name.$user->id;
            Cart::instance($userIdentifier)->restore($userIdentifier);
        }
        
        $rowId = $request->id;
        $quantity = $request->quantity;
        $cartItems = Cart::instance($userIdentifier)->update($rowId, $quantity);
        if($user) {
            Cart::store($userIdentifier); 
        }
        notify()->success('Cart Item Updated successfully');
        return redirect()->back();

    }

    public function removeItem(Request $request){
        
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        //
    }
}
