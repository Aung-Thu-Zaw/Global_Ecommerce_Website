<?php

use App\Http\Controllers\Ecommerce\BlogController;
use App\Http\Controllers\Ecommerce\CancelOrderAndItemController;
use App\Http\Controllers\Ecommerce\CartController;
use App\Http\Controllers\Ecommerce\CartItemController;
use App\Http\Controllers\Ecommerce\CollectionController;
use App\Http\Controllers\Ecommerce\HomeController;
use App\Http\Controllers\Ecommerce\ProductController;
use App\Http\Controllers\Ecommerce\CheckoutController;
use App\Http\Controllers\Ecommerce\ConversationController;
use App\Http\Controllers\Ecommerce\DeliveryInformationController;
use App\Http\Controllers\Ecommerce\LanguageController;
use App\Http\Controllers\User\FollowedShopController;
use App\Http\Controllers\Ecommerce\MessageController;
use App\Http\Controllers\Ecommerce\Payments\PaymentController;
use App\Http\Controllers\Ecommerce\Payments\CashOnDeliveryController;
use App\Http\Controllers\Ecommerce\Payments\StripeController;
use App\Http\Controllers\Ecommerce\ProductAnswerController;
use App\Http\Controllers\Ecommerce\ProductQuestionController;
use App\Http\Controllers\Ecommerce\ProductReviewController;
use App\Http\Controllers\Ecommerce\ProductReviewReplyController;
use App\Http\Controllers\Ecommerce\ReturnOrderAndItemController;
use App\Http\Controllers\Ecommerce\SearchByCategoryProductController;
use App\Http\Controllers\Ecommerce\SearchHistoryController;
use App\Http\Controllers\Ecommerce\SearchResultProductController;
use App\Http\Controllers\Ecommerce\ShopController;
use App\Http\Controllers\Ecommerce\ShopReviewController;
use App\Http\Controllers\Ecommerce\ShopReviewReplyController;
use App\Http\Controllers\Ecommerce\SubscriberController;
use App\Http\Controllers\Ecommerce\SuggestionController;
use App\Http\Controllers\Ecommerce\UserProductInteractionController;
use App\Http\Controllers\User\MyAccountController;
use App\Http\Controllers\User\MyWatchlistController;
use App\Http\Controllers\Ecommerce\WebsiteFeedbackController;
use App\Http\Controllers\Ecommerce\WebsitePages\AboutUsController;
use App\Http\Controllers\Ecommerce\WebsitePages\OurHistoryController;
use App\Http\Controllers\Ecommerce\WebsitePages\PrivacyPolicyController;
use App\Http\Controllers\Ecommerce\WebsitePages\TermsAndConditionsController;
use App\Http\Controllers\User\MyOrderController;
use App\Http\Controllers\User\TrackMyOrderController;
use Illuminate\Support\Facades\Route;

require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
require __DIR__.'/vendor.php';

Route::get('/', [HomeController::class,"index"])->name("home");

Route::controller(MyAccountController::class)
     ->middleware('auth')
     ->prefix("/my-account")
     ->name("my-account.")
     ->group(function () {
         Route::get('/', 'edit')->name('edit');
         Route::post('/', 'update')->name('update');
         Route::delete('/', 'destroy')->name('destroy');
     });

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

Route::get("/about-us", [AboutUsController::class,"index"])->name("about-us");

Route::get("/our-history", [OurHistoryController::class,"index"])->name("our-history");

Route::get("/privacy-policy", [PrivacyPolicyController::class,"index"])->name("privacy-policy");

Route::get("/terms-and-conditions", [TermsAndConditionsController::class,"index"])->name("terms-and-conditions");

Route::post('/search/histories/{search_history}', [SearchHistoryController::class,"update"])->name("user.search.history.update");

Route::get("products", [SearchResultProductController::class,"index"])->name("product.search");

Route::get("{category}/products", [SearchByCategoryProductController::class,"show"])->name("category.products");

Route::get('/collections', [CollectionController::class,"index"])->name("collections.index");

Route::get('/collections/{collection}/products', [CollectionController::class,"show"])->name("collections.show");

Route::get("/blogs", [BlogController::class,"index"])->name("blogs.index");

Route::get("/blogs/{blog_post}", [BlogController::class,"show"])->name("blogs.show");

Route::post('/subscribe', [SubscriberController::class, 'store'])->name("subscribe");

Route::post('/suggestion', [SuggestionController::class, 'store'])->name("suggestion.store");

Route::post('/feedback', [WebsiteFeedbackController::class, 'store'])->name("feedback.store");

Route::post('/languages/change', [LanguageController::class,"change"])->name("languages.change");

// For Authenticated And Verified Users
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

    Route::get('/checkout', [CheckoutController::class,"index"])->name("checkout.index");

    Route::post('/delivery-information', [DeliveryInformationController::class,"store"])->name("information.store");

    Route::post('/payment', [PaymentController::class,"payment"])->name("payment");

    Route::post('/payment/stripePaymentProcess', [StripeController::class,"stripePaymentProcess"])->name("payment.stripePaymentProcess");

    Route::post('/payment/cashPaymentProcess', [CashOnDeliveryController::class,"cashPaymentProcess"])->name("payment.cashPaymentProcess");

    Route::post("/product/track-interaction", [UserProductInteractionController::class,"store"])->name("product.track-interaction");

    Route::post('/track-my-orders', [TrackMyOrderController::class,"trackMyOrder"])->name("order.track");

    Route::controller(ProductQuestionController::class)
         ->prefix("/products/ask-questions")
         ->name("product.question.")
         ->group(function () {
             Route::post("/", "storeQuestion")->name("store");
             Route::post("/{question_id}/update", "updateQuestion")->name("update");
             Route::post("/{question_id}/destroy", "destroyQuestion")->name("destroy");
         });

    Route::controller(ProductAnswerController::class)
         ->prefix("/products/ask-questions/answer")
         ->name("product.question.answer.")
         ->group(function () {
             Route::post("/", "storeAnswer")->name("store");
             Route::post("/{answer_id}/update", "updateAnswer")->name("update");
             Route::post("/{answer_id}/destroy", "destroyAnswer")->name("destroy");
         });

    Route::controller(ProductReviewController::class)
         ->prefix("/products/reviews")
         ->name("product.review.")
         ->group(function () {
             Route::post("/", "storeReview")->name("store");
             Route::post("/{review_id}/update", "updateReview")->name("update");
             Route::post("/{review_id}/destroy", "destroyReview")->name("destroy");
         });

    Route::controller(ProductReviewReplyController::class)
         ->prefix("/products/reviews/reply")
         ->name("product.review.reply.")
         ->group(function () {
             Route::post("/", "storeProductReviewReply")->name("store");
             Route::post("/{reply_id}/update", "updateProductReviewReply")->name("update");
             Route::post("/{reply_id}/destroy", "destroyProductReviewReply")->name("destroy");
         });

    Route::controller(ShopController::class)
         ->prefix("/shops")
         ->name("shop.")
         ->group(function () {
             Route::get("/", "index")->name("index");
             Route::get("/{shop_id:uuid}", "show")->name("show");
             Route::post("/{shop_id}/follow", "followShop")->name("follow");
             Route::post("/{shop_id}/unfollow", "unfollowShop")->name("unfollow");
         });

    Route::controller(ShopReviewController::class)
         ->prefix("/shop/reviews")
         ->name("shop.review.")
         ->group(function () {
             Route::post("/", "storeReview")->name("store");
             Route::post("/{review_id}/update", "updateReview")->name("update");
             Route::post("/{review_id}/destroy", "destroyReview")->name("destroy");
         });

    Route::controller(ShopReviewReplyController::class)
         ->prefix("/shop/reviews/reply")
         ->name("shop.review.reply.")
         ->group(function () {
             Route::post("/", "storeShopReviewReply")->name("store");
             Route::post("/{reply_id}/update", "updateShopReviewReply")->name("update");
             Route::post("/{reply_id}/destroy", "destroyShopReviewReply")->name("destroy");
         });

    Route::controller(MyOrderController::class)
    ->prefix("/my-orders")
    ->name("my-orders.")
    ->group(function () {
        Route::get('/', "index")->name("index");
        Route::get('/{order_id}', "show")->name("show");
        Route::post('/{order_id}/return', "return")->name("return");
        Route::post('/{order_id}/cancel', "cancel")->name("cancel");
        Route::get('/invoice/{order_id}/download', "downloadInvoice")->name("download.invoice");
    });

    Route::controller(ReturnOrderAndItemController::class)
         ->prefix("/return-orders")
         ->name("return-orders.")
         ->group(function () {
             Route::get('/', "index")->name("index");
         });

    Route::controller(CancelOrderAndItemController::class)
         ->prefix("/cancel-orders")
         ->name("cancel-orders.")
         ->group(function () {
             Route::get('/', "index")->name("index");
         });

    Route::controller(MyWatchlistController::class)
         ->prefix("/watchlist")
         ->name("watchlist.")
         ->group(function () {
             Route::get('/', "index")->name("index");
             Route::post('/', "store")->name("store");
             Route::delete('/{watchlist}', "destroy")->name("destroy");
         });

    Route::get("followed-shops", [FollowedShopController::class,"index"])->name("user.shop.followed");

    Route::post("followed-shops/{shop_id}/unfollow", [FollowedShopController::class,"unfollowShop"])->name("user.shop.unfollow");

    Route::controller(ConversationController::class)
         ->prefix("/conversations")
         ->name("conversation.")
         ->group(function () {
             Route::post("/", "storeReview")->name("store");
             Route::post("/{conversation}/messages/seen", "markMessageAsSeen")->name("messages.seen");

         });

    Route::post("/conversation/messages", [MessageController::class,"store"])->name("message.store");

});
