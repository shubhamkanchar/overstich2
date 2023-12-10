<?php

use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\Backend\OrderController as BackendOrderController;
use App\Http\Controllers\Backend\SelllerController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\ProductController as SellerProductController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\OrderController;
use App\Http\Controllers\Frontend\ProductController;
use App\Http\Controllers\Frontend\SellerController;
use App\Http\Controllers\PaymentController;
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
        return view('welcome');
    })->name('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('seller',SellerController::class);
Route::resource('products',ProductController::class);

Route::group(['middleware'=>['auth','adminMiddleware']],function(){
    Route::get('admin/dashboard',[AdminController::class,'dashboard'])->name('admin.dashboard');
    Route::get('sellers/list',[SelllerController::class,'index'])->name('seller.list');
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
    
    Route::group(['prefix' => 'sellers','as' => 'seller.', 'middleware' => ['role:seller'] ], function () {
        Route::resource('products',SellerProductController::class);
        Route::get('products/get-category/{category}', [SellerProductController::class, 'getSubcategory'])->name('get-category');
        Route::get('products/{product}/images', [SellerProductController::class, 'getImages'])->name('products.images');
        Route::patch('products/{product}/images/{productImage}', [SellerProductController::class, 'replaceImage'])->name('product.replace-image');
    });
});

// Route::resource('cart', CartController::class);
Route::get('cart', [CartController::class, 'index'])->name('cart.index');
Route::post('add-to-cart', [CartController::class, 'store'])->name('cart.store');
Route::post('update-cart-item', [CartController::class, 'update'])->name('cart.update');
Route::post('remove-cart-item', [CartController::class, 'remove'])->name('cart.remove-item');
Route::post('clear-cart', [CartController::class, 'destroy'])->name('cart.clear-cart');

Route::domain('partners.'.env('DOMAIN'))->group(function () {
    Route::get('/',[SellerController::class,'homepage']);
});

Route::any('phonepe-response', [OrderController::class, 'paymentResponse'])->name('payment.response');
Route::any('phonepe-callback', [OrderController::class, 'paymentCallback'])->name('payment.callback');