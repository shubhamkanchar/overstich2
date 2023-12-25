<?php

namespace App\Providers;

use App\Models\Category;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('layouts.app', function ($view) {
            $categoryTree = new Category();
            $categories = Category::with('children')->whereNull('parent_id')->get();
            $user = auth()->user();
            $userIdentifier = session()->getId();
            if($user){
                $userIdentifier = $user->name.$user->id;
            }
            Cart::instance($userIdentifier)->restore($userIdentifier);
            $count = Cart::instance($userIdentifier)->content()->count();
            $view->with(['categories' => $categories, 'categoryTree' => $categoryTree, 'cartCount' => $count]);
        });
    }
}
