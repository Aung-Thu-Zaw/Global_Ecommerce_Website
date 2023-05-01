<?php

use App\Http\Controllers\Ecommerce\CartController;
use App\Http\Controllers\Ecommerce\CartItemController;
use App\Http\Controllers\Ecommerce\CollectionController;
use App\Http\Controllers\Ecommerce\HomeController;
use App\Http\Controllers\Ecommerce\ProductController;
use App\Http\Controllers\Ecommerce\CheckoutController;
use App\Http\Controllers\Ecommerce\DeliveryInformationController;
use App\Http\Controllers\Ecommerce\PaymentController;
use App\Http\Controllers\MyAccountController;
use App\Http\Controllers\WatchlistController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [HomeController::class,"index"])->name("home");


Route::get('/products/new-products', [ProductController::class,"newProducts"])->name("products.new");
Route::get('/products/featured-products', [ProductController::class,"featuredProducts"])->name("products.featured");
Route::get('/products/special-offer-products', [ProductController::class,"specialOfferProducts"])->name("products.special-offer");
Route::get('/products/hot-deal-products', [ProductController::class,"hotDealProducts"])->name("products.hot-deal");
Route::get('/products/{product}', [ProductController::class,"show"])->name("products.show");


Route::get('/cart', [CartController::class,"index"])->name("cart.index");
Route::post('/cart/apply-coupon', [CartController::class,"applyCoupon"])->name("coupon.apply");
Route::get('/cart/remove-coupon', [CartController::class,"removeCoupon"])->name("coupon.remove");

Route::post('/cart/cart-items', [CartItemController::class,"store"])->name("cart-items.store");
Route::post('/cart/cart-items/{cart_item}', [CartItemController::class,"update"])->name("cart-items.update");
Route::delete('/cart/cart-items/{cart_item}', [CartItemController::class,"destroy"])->name("cart-items.destroy");

Route::get('/watchlist', [WatchlistController::class,"index"])->name("watchlist.index");
Route::post('/watchlist', [WatchlistController::class,"store"])->name("watchlist.store");
Route::delete('/watchlist/{watchlist}', [WatchlistController::class,"destroy"])->name("watchlist.destroy");


Route::get('/collections', [CollectionController::class,"index"])->name("collections.index");
Route::get('/collections/{collection}/products', [CollectionController::class,"show"])->name("collections.show");

// Route::post('/apply-coupon', [::class,"index"])->name("checkout.index");



Route::get('/checkout', [CheckoutController::class,"index"])->name("checkout.index");

Route::post('/payment', [PaymentController::class,"payment"])->name("payment");
Route::post('/payment/stripePaymentProcess', [PaymentController::class,"stripePaymentProcess"])->name("payment.stripePaymentProcess");
Route::post('/payment/cashPaymentProcess', [PaymentController::class,"cashPaymentProcess"])->name("payment.cashPaymentProcess");



Route::post('/delivery-information', [DeliveryInformationController::class,"store"])->name("information.store");

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth'])->name('user.dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/my-account', [MyAccountController::class, 'edit'])->name('my-account.edit');
    Route::post('/my-account', [MyAccountController::class, 'update'])->name('my-account.update');
    Route::delete('/my-account', [MyAccountController::class, 'destroy'])->name('my-account.destroy');
});




require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
require __DIR__.'/vendor.php';
