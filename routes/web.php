<?php

use App\Http\Controllers\Backend\WarehouseController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\Backend\OrderController as BackendOrderController;
use App\Http\Controllers\Backend\SelllerController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\ProductController as SellerProductController;
use App\Http\Controllers\DelhiveryController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\OrderController;
use App\Http\Controllers\Frontend\ProductController;
use App\Http\Controllers\Frontend\SellerController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\WishlistController;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::domain(env('DOMAIN'))->group(function () {
    Route::get('/', function () {
        $sellers = User::where(['user_type' => 'seller'])
            ->whereHas('sellerInfo', function($query) {
                $query->where('is_approved', 1) ;
            })
            ->with(['sellerInfo', 'sellerInfoImage'])
            ->latest()
            ->take(10)
            ->get();

        $query = Product::with('images')->where('status', 'active');
        $newProductsQuery = clone $query;
        $newProducts = $newProductsQuery->where('condition', 'new')->latest()->take(30)->get();
        
        $hotProductsQuery = clone $query;
        $hotProducts = $hotProductsQuery->where('condition', 'hot')->latest()->take(30)->get();

        $defaultProductsQuery = clone $query;
        $products = $defaultProductsQuery->where('condition', 'default')->latest()->take(30)->get();

        return view('welcome', compact('sellers', 'products', 'newProducts', 'hotProducts'));
    })->name('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('seller',SellerController::class);
Route::resource('products', ProductController::class)->except(['index']);
Route::get('category/products/{category?}', [ProductController::class, 'index'])->name('products.index');
Route::get('brand/products/{seller?}', [ProductController::class, 'getProductByBrand'])->name('products.brand');

Route::group(['middleware'=>['auth','adminMiddleware'], 'prefix' => 'admin'],function(){
    Route::get('dashboard',[AdminController::class,'dashboard'])->name('admin.dashboard');
    Route::get('sellers/list',[SelllerController::class,'index'])->name('seller.list');
    Route::get('users/list',[UserController::class,'index'])->name('user.list');
    Route::get('products/list',[SellerProductController::class,'allProductListing'])->name('admin.product.list');
    Route::get('products/{product}',[SellerProductController::class,'view'])->name('admin.product.view');
    Route::get('products/{product}/images',[SellerProductController::class,'viewImages'])->name('admin.product.images');
    Route::get('sellers/approve/{id}',[SelllerController::class,'approve'])->name('seller.approve');
    Route::get('sellers/reject/{id}',[SelllerController::class,'reject'])->name('seller.reject');
    Route::get('sellers/delete/{id}',[SelllerController::class,'delete'])->name('seller.delete');
    Route::get('orders/list',[BackendOrderController::class,'index'])->name('admin.order.list');
    Route::get('orders/{id}',[BackendOrderController::class,'viewOrder'])->name('admin.order.view');
});

Route::group(['middleware'=>['auth']],function(){
    Route::get('sellers/dashboard',[SelllerController::class,'dashboard'])->name('seller.dashboard');
    Route::get('user/dashboard',[UserController::class,'dashboard'])->name('user.dashboard');
    Route::resource('categories',CategoryController::class);

    Route::get('check-out', [OrderController::class, 'index'])->name('checkout');
    Route::post('place-order', [OrderController::class, 'placeOrder'])->name('order.store');
    Route::get('my-order', [OrderController::class, 'myOrders'])->name('order.my-order');
    Route::resource('warehouses',WarehouseController::class);

    Route::group(['prefix' => 'sellers','as' => 'seller.', 'middleware' => ['role:seller'] ], function () {
        Route::resource('products',SellerProductController::class);
        Route::get('products/get-category/{category}', [SellerProductController::class, 'getSubcategory'])->name('get-category');
        Route::get('products/{product}/images', [SellerProductController::class, 'getImages'])->name('products.images');
        Route::patch('products/{product}/images/{productImage}', [SellerProductController::class, 'replaceImage'])->name('product.replace-image');
        Route::get('orders/list',[BackendOrderController::class,'index'])->name('order.list');
        Route::get('orders/{id}',[BackendOrderController::class,'viewOrder'])->name('order.view');
        
    
    });

    Route::get('download-invoice/{id}', [BackendOrderController::class,'downloadInvoice'])->name('download.invoice');
});

// Route::resource('cart', CartController::class);
Route::get('cart', [CartController::class, 'index'])->name('cart.index');
Route::post('add-to-cart', [CartController::class, 'store'])->name('cart.store');
Route::post('update-cart-item', [CartController::class, 'update'])->name('cart.update');
Route::post('remove-cart-item', [CartController::class, 'remove'])->name('cart.remove-item');
Route::post('clear-cart', [CartController::class, 'destroy'])->name('cart.clear-cart');
Route::get('wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
Route::post('add-to-wishlist/{id}', [WishlistController::class, 'add'])->name('wishlist.add-wishlist');
Route::delete('remove-from-wishlist/{id}', [WishlistController::class, 'Remove'])->name('wishlist.remove-wishlist');

Route::domain('partners.'.env('DOMAIN'))->group(function () {
    Route::get('/',[SellerController::class,'homepage']);
});

Route::any('phonepe-response', [OrderController::class, 'paymentResponse'])->name('payment.response');
Route::any('phonepe-callback', [OrderController::class, 'paymentCallback'])->name('payment.callback');

Route::post('pincode',[DelhiveryController::class,'pincodeCheck'])->name('pinocde-check');