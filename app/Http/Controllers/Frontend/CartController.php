<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Wishlist;
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
        $userIdentifier = $userId = session()->getId();

        if($user){
            $userIdentifier = $user->name.$user->id;
            $userId = $user->id;
        }

        Cart::instance($userIdentifier)->restore($userIdentifier);
        $cartItems = Cart::instance($userIdentifier)->content();

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

        $products = [];
        foreach ($cartItems as $item) {
            $products[$item->id] = Product::with('images')->where('id', $item->options?->product_id)->first();
        }
        $productIds = Wishlist::where('user_id', $userId)->pluck('product_id')->toArray();

        return view('frontend.product.cart', compact( 'cartItems', 'products', 'totalDiscount', 'totalPrice', 'totalOriginalPrice', 'deliveryCharges', 'productIds'));
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

        $firstImage = $product?->images?->first()->image_path;
        $discountedPrice = $product->price - ($product->price * ($product->discount / 100));
        $sizes = explode(',', $product->size);
        $size = $request->size ?? (!empty($sizes) ? $sizes[0] : '');
        Cart::instance($userIdentifier)->add($request->slug . '_' . $request->size, $product->title, 1, $discountedPrice, ['product_id' => $product->id,'size' => $size , 'original_price' => $product->price, 'discount_percentage' => $product->discount, 'discount' => $product->price - $discountedPrice,'image' => $firstImage, 'seller_id' => $product->seller_id, 'color' => $product->color ])->associate('App\Models\Product');
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
        $updatedItem = Cart::instance($userIdentifier)->update($rowId, $quantity);
        if($user) {
            Cart::store($userIdentifier); 
        }

        $cartItems = Cart::instance($userIdentifier)->content();
        
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
        $platformFee = env('PLATFORM_FEE');
        return response()->json(['message' => 'Cart Item Updated successfully', 'updatedItem' => $updatedItem, 'totalDiscount' => $totalDiscount , 'totalPrice' => $totalPrice , 'totalOriginalPrice' => $totalOriginalPrice, 'deliveryCharges' => $deliveryCharges, 'platformFee' => $platformFee ]);

    }

    public function removeItem(Request $request){
        
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        
    }

}
