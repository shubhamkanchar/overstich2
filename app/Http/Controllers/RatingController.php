<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function store(Request $request,Product $product) {
        $user = auth()->user();
        $rating = Rating::firstOrNew([
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);

        $rating->star = $request->star; 
        $rating->fit = $request->fit; 
        $rating->transparency = $request->transparency; 
        $rating->length = $request->length; 
        $rating->review = $request->description; 

        $rating->save();

        return redirect()->route('order.my-order');
    }

    public function addRating(Request $request, $slug) {
        $product = Product::where('slug', $slug)->with(['images'])->first();
        return view('frontend.product.add-rating', compact('product'));
    }
}
