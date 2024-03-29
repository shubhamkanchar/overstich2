<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\UserCoupon;
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
            return $cartItem->options?->original_price * $cartItem->qty;
        });

        $totalStrikedPrice = $cartItems->sum(function ($cartItem) {
            return $cartItem->options?->striked_price * $cartItem->qty;
        });
    
        $totalPrice = $cartItems->sum(function ($cartItem) {
            return $cartItem->price * $cartItem->qty;
        });
    
        $totalDiscount = $cartItems->sum(function ($cartItem) {
            return $cartItem->options?->discount * $cartItem->qty;
        });

        $totalAmountPerSeller = $cartItems->groupBy('options.seller_id')->map(function ($items) {
            return $items->sum(function ($cartItem) {
                return $cartItem->price * $cartItem->qty;
            });
        });
        
        $sellerIds = $totalAmountPerSeller->keys()->all();
        // for removing coupon if user update cart and when the totalAmount per is less than minimum coupon value 
        foreach($totalAmountPerSeller as $sellerId => $totalAmountPer) {
            $userCouponQuery = UserCoupon::where('user_id', $user->id)->with('coupon')
            ->whereHas('coupon', function($query) use ($sellerId, $totalAmountPer) {
                $query->where('seller_id', $sellerId);
                $query->where('minimum', '>', $totalAmountPer);
            })->update(['is_applied' => 0]);

        }

        $deliveryCharges = 0;

        $products = [];

        foreach ($cartItems as $item) {
            $products[$item->id] = Product::with('images')->where('id', $item->options?->product_id)->first();
        }

        $usedCouponIds = UserCoupon::where(function($query) {
            $query->where('is_used', 1)
            ->orWhere('is_applied', 1);
        })
        ->where('user_id' , $user->id)
        ->pluck('coupon_id');
    
        $availableCoupons = Coupon::whereNotIn('id', $usedCouponIds)
        ->Where('status', 1)
        ->with(['brand'])
        ->whereIn('seller_id', $sellerIds)
        ->get();

        $appliedCoupons = Coupon::whereHas('userCoupon', function($query) use ($user) {
            $query->where('user_id', $user->id);
            $query->where('is_used', 0);
            $query->where('is_applied', 1);
        })
        ->with(['brand', 'userCoupon'])
        ->whereIn('seller_id', $sellerIds)
        ->get();

        $productIds = Wishlist::where('user_id', $userId)->pluck('product_id')->toArray();
        return view('frontend.product.cart', compact( 'cartItems', 'products', 'totalDiscount', 'totalPrice', 'totalStrikedPrice', 'totalOriginalPrice', 'totalAmountPerSeller', 'deliveryCharges', 'productIds', 'availableCoupons', 'appliedCoupons'));
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
        $discountedPrice = $product->striked_price - $product->final_price;
        $sizes = explode(',', $product->size);
        $size = $request->size ?? (!empty($sizes) ? $sizes[0] : '');                                                                                                                                                                                                       
        Cart::instance($userIdentifier)->add(
            $request->slug . '_' . $request->size, 
            $product->title, 
            1, 
            $product->final_price, 
            [
                'product_id' => $product->id,
                'size' => $size,
                'original_price' => $product->net_price,
                'striked_price' => $product->striked_price,
                'taxable_amount' => $product->price,
                'cgst_percent' => $product->cgst_percent,
                'sgst_percent' => $product->sgst_percent,
                'sgst_amount' => $product->sgst_amount,
                'cgst_amount' => $product->cgst_amount,
                'discount_percentage' => $product->discount,
                'discount' => $discountedPrice,
                'return' => $product->return,
                'replace' => $product->replace,
                'image' => $firstImage,
                'seller_id' => $product->seller_id,
                'color' => $product->color,
                'hsn' => $product->hsn,
            ]
        )->associate('App\Models\Product');

        if($user) {
            Cart::store($userIdentifier); 
        }
        $request->session()->put('msg', 'Added to bag');
        // notify()->success('Product Added to bag successfully');
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
            return $cartItem->options?->original_price * $cartItem->qty;
        });

        $totalStrikedPrice = $cartItems->sum(function ($cartItem) {
            return $cartItem->options?->striked_price * $cartItem->qty;
        });
    
        $totalPrice = $cartItems->sum(function ($cartItem) {
            return $cartItem->price * $cartItem->qty;
        });
    
        $totalDiscount = $cartItems->sum(function ($cartItem) {
            return $cartItem->options?->discount * $cartItem->qty;
        });

        $deliveryCharges = 0;
        $platformFee = env('PLATFORM_FEE');
        $request->session()->put('msg', 'Cart Item Updated successfully');
        return response()->json(['message' => 'Cart Item Updated successfully', 'updatedItem' => $updatedItem, 'totalDiscount' => $totalDiscount,'totalStrikedPrice' => $totalStrikedPrice , 'totalPrice' => $totalPrice , 'totalOriginalPrice' => $totalOriginalPrice, 'deliveryCharges' => $deliveryCharges, 'platformFee' => $platformFee ]);

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
