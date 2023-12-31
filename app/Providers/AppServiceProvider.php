<?php

namespace App\Providers;

use App\Models\Category;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Pagination\Paginator;
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
        Paginator::useBootstrap();

        View::composer('layouts.app', function ($view) {
            $categories = Category::with(['subCategory', 'subCategory.childCategory'])->whereNull('parent_id')->get();
            $user = auth()->user();
            $userIdentifier = session()->getId();
            if($user){
                $userIdentifier = $user->name.$user->id;
            }
            Cart::instance($userIdentifier)->restore($userIdentifier);
            $count = Cart::instance($userIdentifier)->content()->count();
            $view->with(['categories' => $categories, 'cartCount' => $count]);
        });
    }
}
