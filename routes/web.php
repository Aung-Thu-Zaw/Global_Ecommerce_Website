<?php

use App\Http\Controllers\Ecommerce\CartController;
use App\Http\Controllers\Ecommerce\CartItemController;
use App\Http\Controllers\Ecommerce\CollectionController;
use App\Http\Controllers\Ecommerce\HomeController;
use App\Http\Controllers\Ecommerce\ProductController;
use App\Http\Controllers\Ecommerce\CheckoutController;
use App\Http\Controllers\Ecommerce\DeliveryInformationController;
use App\Http\Controllers\Ecommerce\Payments\PaymentController;
use App\Http\Controllers\Ecommerce\Payments\CashOnDeliveryController;
use App\Http\Controllers\Ecommerce\Payments\StripeController;
use App\Http\Controllers\User\MyAccountController;
use App\Http\Controllers\Ecommerce\WatchlistController;
use App\Http\Controllers\User\MyOrderController;
use App\Http\Controllers\User\TrackMyOrderController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
require __DIR__.'/vendor.php';

Route::get('/', [HomeController::class,"index"])->name("home");
// Route::get('/', function () {
//     return view("mails.for-users.order-shipped-mail");
// });

Route::controller(ProductController::class)
       ->prefix("/products")
       ->name("products.")
       ->group(function () {
           Route::get('/new-products', "newProducts")->name("new");
           Route::get('/featured-products', "featuredProducts")->name("featured");
           Route::get('/special-offer-products', "specialOfferProducts")->name("special-offer");
           Route::get('/hot-deal-products', "hotDealProducts")->name("hot-deal");
           Route::get('/{product}', "show")->name("show");
       });

Route::get('/collections', [CollectionController::class,"index"])->name("collections.index");

Route::get('/collections/{collection}/products', [CollectionController::class,"show"])->name("collections.show");

Route::middleware(["auth","verified"])->group(function () {
    Route::controller(CartController::class)
           ->prefix("/cart")
           ->group(function () {
               Route::get('/', "index")->name("cart.index");
               Route::post('/apply-coupon', "applyCoupon")->name("coupon.apply");
               Route::get('/remove-coupon', "removeCoupon")->name("coupon.remove");
           });

    Route::controller(CartItemController::class)
           ->prefix("/cart/cart-items")
           ->name("cart-items.")
           ->group(function () {
               Route::post('/', "store")->name("store");
               Route::post('/{cart_item}', "update")->name("update");
               Route::delete('/{cart_item}', "destroy")->name("destroy");
           });

    Route::controller(WatchlistController::class)
           ->prefix("/watchlist")
           ->name("watchlist.")
           ->group(function () {
               Route::get('/', "index")->name("index");
               Route::post('/', "store")->name("store");
               Route::delete('/{watchlist}', "destroy")->name("destroy");
           });

    Route::get('/checkout', [CheckoutController::class,"index"])->name("checkout.index");

    Route::post('/delivery-information', [DeliveryInformationController::class,"store"])->name("information.store");

    Route::post('/payment', [PaymentController::class,"payment"])->name("payment");

    Route::post('/payment/stripePaymentProcess', [StripeController::class,"stripePaymentProcess"])->name("payment.stripePaymentProcess");

    Route::post('/payment/cashPaymentProcess', [CashOnDeliveryController::class,"cashPaymentProcess"])->name("payment.cashPaymentProcess");

    Route::controller(MyOrderController::class)
           ->prefix("/my-orders")
           ->name("my-orders.")
           ->group(function () {
               Route::get('/', "index")->name("index");
               Route::get('/{order_id}', "show")->name("show");
               Route::get('/invoice/{order_id}/download', "downloadInvoice")->name("download.invoice");
           });

    Route::post('/track-my-orders', [TrackMyOrderController::class,"trackMyOrder"])->name("order.track");

});

Route::controller(MyAccountController::class)
       ->middleware('auth')
       ->prefix("/my-account")
       ->name("my-account.")
       ->group(function () {
           Route::get('/', 'edit')->name('edit');
           Route::post('/', 'update')->name('update');
           Route::delete('/', 'destroy')->name('destroy');
       });




Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth'])->name('user.dashboard');
