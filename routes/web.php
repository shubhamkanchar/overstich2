<?php

use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\Backend\SelllerController;
use App\Http\Controllers\Frontend\ProductController;
use App\Http\Controllers\Frontend\SellerController;
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

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('seller',SellerController::class);
Route::resource('products',ProductController::class);

Route::group(['middleware'=>['auth','adminMiddleware']],function(){
    Route::get('admin/dashboard',[AdminController::class,'dashboard'])->name('admin.dashboard');
    Route::get('seller/dashboard',[SelllerController::class,'dashboard'])->name('seller.dashboard');
    Route::get('sellers/list',[SelllerController::class,'index'])->name('seller.list');
    Route::get('sellers/approve/{id}',[SelllerController::class,'approve'])->name('seller.approve');
    Route::get('sellers/reject/{id}',[SelllerController::class,'reject'])->name('seller.reject');
    Route::get('sellers/delete/{id}',[SelllerController::class,'delete'])->name('seller.delete');
});

Route::group(['middleware'=>['auth','adminMiddleware']],function(){
    Route::get('seller/dashboard',[SelllerController::class,'dashboard'])->name('seller.dashboard');
});