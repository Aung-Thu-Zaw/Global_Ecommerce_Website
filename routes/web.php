<?php

use App\Http\Controllers\Ecommerce\Blogs\BlogCommentController;
use App\Http\Controllers\Ecommerce\Blogs\BlogCommentReplyController;
use App\Http\Controllers\Ecommerce\Blogs\BlogController;
use App\Http\Controllers\Ecommerce\CancelOrderAndItemController;
use App\Http\Controllers\Ecommerce\CartController;
use App\Http\Controllers\Ecommerce\CartItemController;
use App\Http\Controllers\Ecommerce\CollectionController;
use App\Http\Controllers\Ecommerce\HomeController;
use App\Http\Controllers\Ecommerce\ProductController;
use App\Http\Controllers\Ecommerce\CheckoutController;
use App\Http\Controllers\Ecommerce\ConversationController;
use App\Http\Controllers\Ecommerce\DeliveryInformationController;
use App\Http\Controllers\Ecommerce\HelpCenter\HelpCenterController;
use App\Http\Controllers\Ecommerce\HelpCenter\LiveChats\LiveChatMessageController;
use App\Http\Controllers\Ecommerce\HelpCenter\LiveChats\SupportLiveChatServiceController;
use App\Http\Controllers\Ecommerce\LanguageController;
use App\Http\Controllers\User\FollowedShopController;
use App\Http\Controllers\Ecommerce\MessageController;
use App\Http\Controllers\Ecommerce\NotificationController;
use App\Http\Controllers\Ecommerce\Payments\PaymentController;
use App\Http\Controllers\Ecommerce\Payments\CashOnDeliveryController;
use App\Http\Controllers\Ecommerce\Payments\StripeController;
use App\Http\Controllers\Ecommerce\ProductAnswerController;
use App\Http\Controllers\Ecommerce\ProductQuestionController;
use App\Http\Controllers\Ecommerce\Reviews\ProductReviewController;
use App\Http\Controllers\Ecommerce\Reviews\ProductReviewReplyController;
use App\Http\Controllers\Ecommerce\ReturnOrderAndItemController;
use App\Http\Controllers\Ecommerce\Products\SearchByCategoryProductController;
use App\Http\Controllers\Ecommerce\SearchHistoryController;
use App\Http\Controllers\Ecommerce\SearchResultProductController;
use App\Http\Controllers\Ecommerce\ShopController;
use App\Http\Controllers\Ecommerce\Reviews\ShopReviewController;
use App\Http\Controllers\Ecommerce\Reviews\ShopReviewReplyController;
use App\Http\Controllers\Ecommerce\SubscriberController;
use App\Http\Controllers\Ecommerce\SuggestionController;
use App\Http\Controllers\Ecommerce\UserProductInteractionController;
use App\Http\Controllers\User\MyAccountController;
use App\Http\Controllers\User\MyWatchlistController;
use App\Http\Controllers\Ecommerce\WebsiteFeedbackController;
use App\Http\Controllers\Ecommerce\WebsitePages\AboutUsController;
use App\Http\Controllers\Ecommerce\WebsitePages\FaqController;
use App\Http\Controllers\Ecommerce\WebsitePages\OurHistoryController;
use App\Http\Controllers\Ecommerce\WebsitePages\PrivacyPolicyController;
use App\Http\Controllers\Ecommerce\WebsitePages\TermsAndConditionsController;
use App\Http\Controllers\User\MyOrderController;
use App\Http\Controllers\User\TrackMyOrderController;
use Illuminate\Support\Facades\Route;

require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
require __DIR__.'/seller.php';

Route::get('/', [HomeController::class,"index"])->name("home");

Route::controller(CollectionController::class)
     ->prefix("/collections")
     ->name("collections.")
     ->group(function () {
         Route::get('/', "index")->name("index");
         Route::get('/{collection}/products', "show")->name("show");
     });

Route::controller(ProductController::class)
     ->prefix("/products")
     ->name("products.")
     ->group(function () {
         Route::get('/flash-sale-products', "flashSaleProducts")->name("flash-sales");
         Route::get('/new-products', "newProducts")->name("new");
         Route::get('/featured-products', "featuredProducts")->name("featured");
         Route::get('/{product}', "show")->name("show");
     });

Route::patch('/search/histories/{search_history}', [SearchHistoryController::class,"update"])->name("user.search.history.update");

Route::get("products", [SearchResultProductController::class,"index"])->name("product.search");

Route::get("{category}/products", [SearchByCategoryProductController::class,"show"])->name("category.products");

Route::get("/about-us", [AboutUsController::class,"index"])->name("about-us.index");

Route::get("/our-history", [OurHistoryController::class,"index"])->name("our-history.index");

Route::get("/privacy-policy", [PrivacyPolicyController::class,"index"])->name("privacy-policy.index");

Route::get("/terms-and-conditions", [TermsAndConditionsController::class,"index"])->name("terms-and-conditions.index");

Route::controller(FaqController::class)
     ->prefix("/faqs")
     ->name("faqs.")
     ->group(function () {
         Route::get("/", "index")->name("index");
         Route::get("/{faq}", "show")->name("show");
     });

Route::controller(HelpCenterController::class)
     ->prefix("/help-center")
     ->name("help-center.")
     ->group(function () {
         Route::get("/", "index")->name("index");
         Route::get("/questions/search-result", "searchResult")->name("questions.search");
     });

Route::post('/subscribe', [SubscriberController::class, 'store'])->name("subscribe.store");

Route::post('/suggestion', [SuggestionController::class, 'store'])->name("suggestion.store");

Route::post('/feedback', [WebsiteFeedbackController::class, 'store'])->name("feedback.store");

Route::post('/languages/change', [LanguageController::class,"change"])->name("languages.change");

Route::controller(BlogController::class)
     ->prefix("/blogs")
     ->name("blogs.")
     ->group(function () {
         Route::get("/", "index")->name("index");
         Route::get("/{blog_post}", "show")->name("show");
         Route::get("/tags/{tag}", "tagBlog")->name("tag");
     });

// For Authenticated Users
Route::controller(MyAccountController::class)
     ->middleware('auth')
     ->prefix("/my-account")
     ->name("my-account.")
     ->group(function () {
         Route::get('/', 'edit')->name('edit');
         Route::post('/', 'update')->name('update');
         Route::delete('/', 'destroy')->name('destroy');
     });

// For Authenticated And Verified Users
Route::middleware(["auth","verified"])->group(function () {

    // Dashboard Notification
    Route::controller(NotificationController::class)
         ->prefix("/notifications")
         ->name("notifications.")
         ->group(function () {
             Route::patch("/{notification_id}/read", "reatNotification")->name("read");
             Route::patch("/read-all", "markAllAsRead")->name("read-all");
         });

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
             Route::patch('/{cart_item}', "update")->name("update");
             Route::delete('/{cart_item}', "destroy")->name("destroy");
         });

    Route::get('/checkout', [CheckoutController::class,"index"])->name("checkout.index");

    Route::post('/delivery-information', [DeliveryInformationController::class,"store"])->name("information.store");

    Route::post('/payment', [PaymentController::class,"payment"])->name("payment");

    Route::post('/payment/stripePaymentProcess', [StripeController::class,"stripePaymentProcess"])->name("payment.stripe");

    Route::post('/payment/cashPaymentProcess', [CashOnDeliveryController::class,"cashPaymentProcess"])->name("payment.cash");

    Route::post("/product/track-interaction", [UserProductInteractionController::class,"store"])->name("product.track-interaction");

    Route::post('/track-my-orders', [TrackMyOrderController::class,"trackMyOrder"])->name("order.track");

    Route::controller(BlogCommentController::class)
         ->prefix("/blogs/comments")
         ->name("blogs.comments.")
         ->group(function () {
             Route::post("/", "store")->name("store");
             Route::patch("/{blog_comment}", "update")->name("update");
             Route::delete("/{blog_comment}", "destroy")->name("destroy");
         });

    Route::controller(BlogCommentReplyController::class)
         ->prefix("/blogs/comments/reply")
         ->name("blogs.comments.reply.")
         ->group(function () {
             Route::post("/", "store")->name("store");
             Route::patch("/{blog_comment_reply}/update", "update")->name("update");
             Route::delete("/{blog_comment_reply}/destroy", "destroy")->name("destroy");
         });

    Route::controller(ProductQuestionController::class)
         ->prefix("/product/ask-questions")
         ->name("product.questions.")
         ->group(function () {
             Route::post("/", "store")->name("store");
             Route::patch("/{product_question}/update", "update")->name("update");
             Route::delete("/{product_question}/destroy", "destroy")->name("destroy");
         });

    Route::controller(ProductAnswerController::class)
         ->prefix("/products/questions/answer")
         ->name("product.questions.answer.")
         ->group(function () {
             Route::post("/", "store")->name("store");
             Route::patch("/{product_answer}/update", "update")->name("update");
             Route::delete("/{product_answer}/destroy", "destroy")->name("destroy");
         });

    Route::post("/product/reviews", [ProductReviewController::class,"store"])->name("product.reviews.store");

    Route::post("/product/reviews/reply", [ProductReviewReplyController::class,"store"])->name("product.reviews.reply.store");

    Route::post("/shop/reviews", [ShopReviewController::class,"store"])->name("shop.reviews.store");

    Route::post("/shop/reviews/reply", [ShopReviewReplyController::class,"store"])->name("shop.reviews.reply.store");

    Route::controller(ShopController::class)
    ->prefix("/shops")
    ->name("shop.")
    ->group(function () {
        Route::get("/", "index")->name("index");
        Route::get("/{shop_id:uuid}", "show")->name("show");
        Route::post("/{shop_id}/follow", "followShop")->name("follow");
        Route::post("/{shop_id}/unfollow", "unfollowShop")->name("unfollow");
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
         ->prefix("/watchlists")
         ->name("watchlists.")
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


    Route::controller(SupportLiveChatServiceController::class)
         ->prefix("/support-service")
         ->name("service.live-chat.")
         ->group(function () {
             Route::get('/live-chats/{live_chat_id:uuid}', "show")->name("show");
             Route::get('/other-options', "otherOption")->name("other-options");
             Route::post('/live-chats', "store")->name("store");
             Route::patch('/live-chats/{live_chat}/end-chat', "endChat")->name("end-chat");
         });


    Route::controller(LiveChatMessageController::class)
         ->prefix("/support-service/live-chats/messages")
         ->name("live-chat.message.")
         ->group(function () {
             Route::post("", "store")->name("store");
             Route::patch("/{live_chat_mesage}/delete-for-myself", "deleteMessageForMyself")->name("delete-for-myself");
             Route::patch("/{live_chat_mesage}/reply", "replyMessage")->name("reply");
             Route::delete("/{live_chat_mesage}", "destroy")->name("destroy");
         });



});
