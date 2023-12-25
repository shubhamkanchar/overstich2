<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index() {
        $userId = session()->getId();
        if($user = auth()->user()) {
            $userId = $user->id;
        }

        $productIds = Wishlist::where('user_id', $userId)->pluck('product_id')->toArray();
        $products = Product::with('images')->whereIn('id', $productIds)->get();
        return view('frontend.product.wishlist', compact('products', 'productIds'));
    }

    public function add($id) {
        $userId = auth()->user() ? auth()->user()->id : session()->getId();
        $wishlist = new Wishlist();
        $wishlist->product_id = $id;
        $wishlist->user_id = $userId;
        $wishlist->save();
        $message = 'Product added to Wishlist';
        $added = true;

        return response()->json(['message' => $message, 'added' => $added]);

    }

    public function remove($id) {

        $userId = session()->getId();
        if($user = auth()->user()) {
            $userId = $user->id;
        }

        $wishlist = Wishlist::where(['product_id' => $id, 'user_id' => $userId]);
        $wishlist->delete();
        return response()->json(['message' => 'Wishlist Item removed Successfully']);
    }
}
