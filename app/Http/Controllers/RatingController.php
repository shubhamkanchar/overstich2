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
        request()->session()->put('success','Rating has been ' . ($rating->wasRecentlyCreated ? 'added' : 'updated') . ' successfully.');
        return redirect()->route('order.my-order');
    }

    public function addRating(Request $request, $slug) {
        $user = auth()->user();
        $product = Product::where('slug', $slug)->with(['images', 'ratings'])->withCount('ratings')->first();
        $averageStarRating = round($product->ratings->avg('star'), 2);
        $userRating = Rating::where(['user_id' => $user->id, 'product_id' => $product->id])->first();
        return view('frontend.product.add-rating', compact('product', 'userRating', 'averageStarRating'));
    }

    public function destroy(Request $request,Product $product) {
        $user = auth()->user();
        $rating = Rating::firstOrNew([
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);

        $rating->delete();
        request()->session()->put('success','Rating has been removed');
        return redirect()->back();
    }
}
