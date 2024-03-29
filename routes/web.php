<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\Backend\AccountController;
use App\Http\Controllers\Backend\AdsModelController;
use App\Http\Controllers\Backend\WarehouseController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\Backend\CouponController;
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
use App\Http\Controllers\RatingController;
use App\Http\Controllers\WishlistController;
use App\Models\AdsModel;
use App\Models\CategoryFilter;
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

Route::domain(env('WWW').env('DOMAIN'))->group(function () {
    Route::get('/', function () {
        $topAds = AdsModel::where('status' ,'1')->where('location' ,'top')->limit(10)->get();
        $bottomAds = AdsModel::where('status' ,'1')->where('location' ,'bottom')->limit(10)->get();
        $leftAds = AdsModel::where('status' ,'1')->where('location' ,'left')->limit(10)->get();
        $rightAds = AdsModel::where('status' ,'1')->where('location' ,'right')->limit(10)->get();

        $query = Product::with('images')->where('status', 'active');
        $newProductsQuery = clone $query;
        $newProducts = $newProductsQuery->where('condition', 'new')->latest()->take(30)->get();
        
        $hotProductsQuery = clone $query;
        $hotProducts = $hotProductsQuery->where('condition', 'hot')->latest()->take(30)->get();

        $defaultProductsQuery = clone $query;
        $products = $defaultProductsQuery->where('condition', 'default')->latest()->take(30)->get();

        return view('welcome', compact('topAds', 'products', 'newProducts', 'hotProducts','bottomAds','leftAds','rightAds'));
    })->name('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/terms-and-condition',function(){
    return view('terms-condition');
})->name('tc');
Route::get('/privacy-policy', function(){
    return view('privacy-policy');
})->name('pp');
Route::get('/return-and-refund',function(){
    return view('return-policy');
})->name('rp');
Route::get('/shipping-policy', function(){
    return view('shipping-policy');
})->name('sp');
Route::get('/about-us', function(){
    return view('about-us');
})->name('about_us');
Route::get('/contact-us', function(){
    return view('contact-us');
})->name('contact_us');
Route::get('search/products', [ProductController::class,'index'])->name('search-product');

Route::resource('products', ProductController::class)->except(['index']);
Route::get('category/products/{category?}', [ProductController::class, 'index'])->name('products.index');
Route::get('products/{seller:slug?}/get-brand', [ProductController::class, 'getProductByBrand'])->name('products.brand');
Route::get('track/{id}',[DelhiveryController::class,'track'])->name('user.track');
Route::get('return_replace/{order_number}',[DelhiveryController::class,'returnReplaceOrderGet'])->name('user.replaceGet');
Route::post('return_replace/{order_number}',[DelhiveryController::class,'returnReplaceOrder'])->name('user.replacePost');

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
    Route::get('sellers/view/{id}',[SelllerController::class,'view'])->name('seller.view');
    Route::get('orders/list',[BackendOrderController::class,'index'])->name('admin.order.list');
    Route::get('orders/{id}',[BackendOrderController::class,'viewOrder'])->name('admin.order.view');
    Route::resource('categories',CategoryController::class);
    Route::get('category-filters', [CategoryController::class, 'viewFilters'])->name('category.filters.view');
    Route::get('category-filters/add', [CategoryController::class, 'addFilter'])->name('category.filters.add');
    Route::post('category-filters/add', [CategoryController::class, 'storeFilter'])->name('category.filters.store');
    Route::get('category-filters/{categoryFilter}/edit', [CategoryController::class, 'editFilter'])->name('category.filters.edit');
    Route::put('category-filters/{categoryFilter}/update', [CategoryController::class, 'updateFilter'])->name('category.filters.update');
    Route::delete('category-filters/{categoryFilter}/delete', [CategoryController::class, 'destroyFilter'])->name('category.filters.destroy');
    Route::get('get-sub-categories/{category}', [CategoryController::class, 'getSubCategory'])->name('admin.get-sub-categories');
    Route::resource('coupon', CouponController::class);
    Route::resource('ads',AdsModelController::class);
});

Route::group(['middleware'=>['auth']],function(){
    Route::get('sellers/dashboard',[SelllerController::class,'dashboard'])->name('seller.dashboard');
    Route::get('user/dashboard',[UserController::class,'dashboard'])->name('user.dashboard');

    Route::get('check-out', [OrderController::class, 'index'])->name('checkout');
    Route::get('change-address', [AddressController::class, 'changeAddress'])->name('change-address');
    Route::post('place-order', [OrderController::class, 'placeOrder'])->name('order.store');
    Route::get('my-order', [OrderController::class, 'myOrders'])->name('order.my-order');
    Route::get('{product}/add-rating', [RatingController::class, 'addRating'])->name('rating.add-rating');
    Route::post('{product}/rating', [RatingController::class, 'store'])->name('rating.store');
    Route::delete('{product}/remove-rating', [RatingController::class, 'destroy'])->name('rating.destroy');

    Route::group(['prefix' => 'sellers','as' => 'seller.', 'middleware' => ['role:seller'] ], function () {
        Route::resource('products',SellerProductController::class);
        Route::get('products/get-category/{category}', [SellerProductController::class, 'getSubcategory'])->name('get-category');
        Route::get('products/get-child-categories/{category}', [CategoryController::class, 'getChildCategory'])->name('get-child-categories');
        Route::get('products/get-filter-values/{categoryFilter}', [SellerProductController::class, 'getFilterValues'])->name('get-filter-values');
        Route::get('products/get-filter-type/{category}', [SellerProductController::class, 'getCategoryFilter'])->name('get-filter-type');
        Route::get('products/{product}/images', [SellerProductController::class, 'getImages'])->name('products.images');
        Route::get('products/{product}/filters', [SellerProductController::class, 'addFilters'])->name('products.filters');
        Route::post('products/save-filters', [SellerProductController::class, 'saveFilters'])->name('products.filters.store');
        Route::patch('products/{product}/images/{productImage}', [SellerProductController::class, 'replaceImage'])->name('product.replace-image');
        Route::patch('products/{product}/size-chart', [SellerProductController::class, 'updateSizeChart'])->name('product.update-size-chart');
        Route::get('orders/list',[BackendOrderController::class,'index'])->name('order.list');
        Route::get('orders/{id}',[BackendOrderController::class,'viewOrder'])->name('order.view');
        Route::post('orders/{order}/reject', [BackendOrderController::class,'rejectOrder'])->name('order.reject');
        Route::get('download-invoice/{id}', [BackendOrderController::class,'downloadInvoice'])->name('download.invoice');
        Route::get('order/return',[BackendOrderController::class,'orderReturnTable'])->name('order.return');
        Route::get('order/return/{order_number}',[BackendOrderController::class,'orderReturnView'])->name('order.return-view');
        Route::get('order/shipment/{id}',[DelhiveryController::class,'shipmentCreate'])->name('order.shipment');
        Route::get('warehouse/create',[DelhiveryController::class,'warehouseCreate'])->name('warehouse.create');
        Route::post('warehouse/store',[DelhiveryController::class,'warehousestore'])->name('warehouse.store');
        Route::get('slip/create/{id}',[DelhiveryController::class,'slipDownload'])->name('order.slip');
        Route::post('pickup',[DelhiveryController::class,'raisePickup'])->name('pickup');
        Route::resource('warehouses',WarehouseController::class);
        Route::get('track/{id}',[DelhiveryController::class,'track'])->name('order.track');
        Route::get('account', [AccountController::class, 'sellerAccount'])->name('account.index');
        Route::post('update-basic-info', [AccountController::class, 'updateBrandInfo'])->name('account.update.basic');
        Route::post('deactivate-account', [AccountController::class, 'deactivate'])->name('account.deactivate');
        Route::post('activate-account', [AccountController::class, 'activate'])->name('account.activate');
        Route::post('update-products-details', [AccountController::class, 'updateProductDetails'])->name('account.products.details');
        Route::post('update-gst-account-details', [AccountController::class, 'updateGstAccount'])->name('account.update.gst-account');
        Route::patch('update-cancel-cheque', [AccountController::class, 'updateCancelCheque'])->name('account.update-cancel-cheque');
        Route::patch('update-gst-doc', [AccountController::class, 'updateGstDoc'])->name('account.update-gst-doc');
        Route::patch('update-noc-doc', [AccountController::class, 'uploadNocDoc'])->name('account.update-noc-doc');
        Route::patch('update-authorize-signature', [AccountController::class, 'uploadSignature'])->name('account.update-authorize-signature');

        Route::get('shipment/create/{id}',[DelhiveryController::class,'shipmentForm'])->name('shipment-form');
        Route::resource('coupon', CouponController::class);
        Route::get('accept/{order}',[BackendOrderController::class,'acceptOrder'])->name('order.accept');

        Route::get('return/accept/{id}',[BackendOrderController::class,'acceptReturnOrder'])->name('order.return-accept');
        Route::post('return/orders/{id}/reject', [BackendOrderController::class,'rejectReturnOrder'])->name('order.return-reject');

        Route::post('upload-signature',[SelllerController::class,'uploadSignature'])->name('upload-signature');
    });

    Route::get('download-invoice/{id}', [OrderController::class,'downloadInvoice'])->name('download.invoice');
    // Route::resource('cart', CartController::class);
    Route::get('cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('add-to-cart', [CartController::class, 'store'])->name('cart.store');
    Route::post('update-cart-item', [CartController::class, 'update'])->name('cart.update');
    Route::post('remove-cart-item', [CartController::class, 'remove'])->name('cart.remove-item');
    Route::post('clear-cart', [CartController::class, 'destroy'])->name('cart.clear-cart');
    Route::get('wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('add-to-wishlist/{id}', [WishlistController::class, 'add'])->name('wishlist.add-wishlist');
    Route::delete('remove-from-wishlist/{id}', [WishlistController::class, 'Remove'])->name('wishlist.remove-wishlist');
    Route::post('apply-coupon/{coupon}', [CouponController::class, 'applyCoupon'])->name('coupon.apply');
    Route::post('remove-coupon/{coupon}', [CouponController::class, 'removeCoupon'])->name('coupon.remove');
    Route::resource('addresses',AddressController::class);
    Route::get('my-account', [AccountController::class, 'userAccount'])->name('account.index');
    Route::post('/profile/update', [AccountController::class, 'updateProfile'])->name('account.update');
    Route::post('/profile/update-password', [AccountController::class, 'updatePassword'])->name('account.update.password');
    Route::post('profile/password-verification', [AccountController::class, 'passwordVerification'])->name('account.verify-old-password');
});


Route::domain('partners.'.env('DOMAIN'))->group(function () {
    Route::get('/',[SellerController::class,'homepage']);
    Route::resource('seller',SellerController::class);
});
Route::resource('seller',SellerController::class);
Route::any('phonepe-response', [OrderController::class, 'paymentResponse'])->name('payment.response');
Route::any('phonepe-callback', [OrderController::class, 'paymentCallback'])->name('payment.callback');
Route::get('/success',function(){
    return view('frontend.order.success');
})->name('success-page');

Route::get('/error',function(){
    return view('frontend.order.error');
})->name('error-page');
//delhivery routes
Route::post('pincode',[DelhiveryController::class,'pincodeCheck'])->name('pinocde-check');
Route::post('cancel',[DelhiveryController::class,'cancelOrder'])->name('cancel-order');

