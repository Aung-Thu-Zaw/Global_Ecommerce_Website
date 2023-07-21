<?php

use App\Http\Controllers\Admin\Auth\AdminAuthController;
use App\Http\Controllers\Admin\AdminBrandController;
use App\Http\Controllers\Admin\Banners\AdminCampaignBannerController;
use App\Http\Controllers\Admin\AdminCollectionController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminCouponController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminDashboardNotificationController;
use App\Http\Controllers\Admin\AdminLanguageController;
use App\Http\Controllers\MultiImageController;
use App\Http\Controllers\Admin\Banners\AdminProductBannerController;
use App\Http\Controllers\Admin\UserManagements\VendorManage\AdminActiveVendorController;
use App\Http\Controllers\Admin\UserManagements\VendorManage\AdminInactiveVendorController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminWebControlArea\FaqCategories\AdminFaqCategoryController;
use App\Http\Controllers\Admin\AdminWebControlArea\FaqCategories\AdminFaqSubCategoryController;
use App\Http\Controllers\Admin\AuthorityManagements\AdminRoleInPermissionController;
use App\Http\Controllers\Admin\AdminWebControlArea\SiteSettings\AdminSeoSettingController;
use App\Http\Controllers\Admin\AdminWebControlArea\SiteSettings\AdminWebsiteSettingController;
use App\Http\Controllers\Admin\AdminWebControlArea\WebsitePages\AdminPrivacyPolicyController;
use App\Http\Controllers\Admin\AdminWebControlArea\WebsitePages\AdminTermsAndConditionsController;
use App\Http\Controllers\Admin\Banners\AdminSliderBannerController;
use App\Http\Controllers\Admin\BlogManagements\AdminBlogCategoryController;
use App\Http\Controllers\Admin\BlogManagements\AdminBlogPostController;
use App\Http\Controllers\Admin\UserManagements\UserManage\AdminRegisterUserController;
use App\Http\Controllers\Admin\UserManagements\UserManage\AdminRegisterVendorController;
use App\Http\Controllers\Admin\OrderManagements\CancelOrderManage\AdminApprovedCancelOrderController;
use App\Http\Controllers\Admin\OrderManagements\CancelOrderManage\AdminRequestedCancelOrderController;
use App\Http\Controllers\Admin\OrderManagements\OrderManage\AdminConfirmedOrderController;
use App\Http\Controllers\Admin\OrderManagements\OrderManage\AdminDeliveredOrderController;
use App\Http\Controllers\Admin\OrderManagements\OrderManage\AdminPendingOrderController;
use App\Http\Controllers\Admin\OrderManagements\OrderManage\AdminProcessingOrderController;
use App\Http\Controllers\Admin\OrderManagements\OrderManage\AdminShippedOrderController;
use App\Http\Controllers\Admin\OrderManagements\ReturnOrderManage\AdminApprovedReturnOrderController;
use App\Http\Controllers\Admin\OrderManagements\ReturnOrderManage\AdminRequestedReturnOrderController;
use App\Http\Controllers\Admin\OrderManagements\ReturnOrderManage\AdminRefundedReturnOrderController;
use App\Http\Controllers\Admin\ShippingArea\AdminCityController;
use App\Http\Controllers\Admin\ShippingArea\AdminCountryController;
use App\Http\Controllers\Admin\ShippingArea\AdminRegionController;
use App\Http\Controllers\Admin\ShippingArea\AdminTownshipController;
use App\Http\Controllers\Admin\AuthorityManagements\RolesAndPermissions\AdminRoleController;
use App\Http\Controllers\Admin\AuthorityManagements\RolesAndPermissions\AdminPermissionController;
use App\Http\Controllers\Admin\Dashboard\AdminSocialTrafficController;
use App\Http\Controllers\Admin\FromTheSubmitters\AdminWebsiteFeedbackController;
use App\Http\Controllers\Admin\FromTheSubmitters\AdminSubscriberController;
use App\Http\Controllers\Admin\FromTheSubmitters\AdminSuggestionController;
use App\Http\Controllers\Admin\UserManagements\AdminManage\AdminManageController;
use App\Http\Controllers\ReviewManagements\ProductReviews\AdminPendingProductReviewController;
use App\Http\Controllers\ReviewManagements\ProductReviews\AdminPublishedProductReviewController;
use App\Http\Controllers\ReviewManagements\ShopReviews\AdminPendingShopReviewController;
use App\Http\Controllers\ReviewManagements\ShopReviews\AdminPublishedShopReviewController;
use Illuminate\Support\Facades\Route;

Route::get("/admin/login", [AdminAuthController::class,"login"])->middleware("guest")->name("admin.login");

Route::middleware(["admin","verified","user.role:admin"])
       ->prefix("admin")
       ->name("admin.")
       ->group(function () {

           // Dashboard Section
           Route::get("/dashboard", [AdminDashboardController::class,"index"])->name("dashboard");

           // Dashboard Notification
           Route::post("/notifications/{notification_id}/read", [AdminDashboardNotificationController::class,"reatNotification"])->name("notifications.read");

           // Dashboard Social Traffic
           Route::controller(AdminSocialTrafficController::class)
                ->prefix("/social-traffics")
                ->name("social-traffics.")
                ->group(function () {
                    Route::post("/change-target", "changeTarget")->name("change.target");
                    Route::post("/{social_traffic}/increment-visitors", "incrementActualVisitors")->name("increment.visitors");
                });

           // Admin Brand Section
           Route::controller(AdminBrandController::class)
                ->prefix("/brands")
                ->name("brands.")
                ->group(function () {
                    Route::get("/", "index")->middleware('permission:brand.menu')->name("index");
                    Route::get("/create", "create")->middleware('permission:brand.add')->name("create");
                    Route::post("/", "store")->middleware('permission:brand.add')->name("store");
                    Route::get("/{brand}/edit", "edit")->middleware('permission:brand.edit')->name("edit");
                    Route::post("/{brand}", "update")->middleware('permission:brand.edit')->name("update");
                    Route::delete("/{brand}", "destroy")->middleware('permission:brand.delete')->name("destroy");
                    Route::get("/trash", "trash")->middleware('permission:brand.trash.list')->name("trash");
                    Route::post("/{brand}/restore", "restore")->middleware('permission:brand.trash.restore')->name("restore");
                    Route::delete("/{brand}/force-delete", "forceDelete")->middleware('permission:brand.trash.delete')->name("force.delete");
                    Route::get("/permanently-delete", "permanentlyDelete")->middleware('permission:brand.trash.delete')->name("permanently.delete");
                });

           // Admin Collection Section
           Route::controller(AdminCollectionController::class)
                ->prefix("/collections")
                ->name("collections.")
                ->group(function () {
                    Route::get("/", "index")->middleware('permission:collection.menu')->name("index");
                    Route::get("/create", "create")->middleware('permission:collection.add')->name("create");
                    Route::post("/", "store")->middleware('permission:collection.add')->name("store");
                    Route::get("/{collection}/edit", "edit")->middleware('permission:collection.edit')->name("edit");
                    Route::post("/{collection}", "update")->middleware('permission:collection.edit')->name("update");
                    Route::delete("/{collection}", "destroy")->middleware('permission:collection.delete')->name("destroy");
                    Route::get("/trash", "trash")->middleware('permission:collection.trash.list')->name("trash");
                    Route::post("/{collection}/restore", "restore")->middleware('permission:collection.trash.restore')->name("restore");
                    Route::delete("/{collection}/force-delete", "forceDelete")->middleware('permission:collection.trash.delete')->name("force.delete");
                    Route::get("/permanently-delete", "permanentlyDelete")->middleware('permission:collection.trash.delete')->name("permanently.delete");
                });

           // Admin Category Section
           Route::controller(AdminCategoryController::class)
                ->prefix("/categories")
                ->name("categories.")
                ->group(function () {
                    Route::get("/", "index")->middleware('permission:category.menu')->name("index");
                    Route::get("/create", "create")->middleware('permission:category.add')->name("create");
                    Route::post("/", "store")->middleware('permission:category.add')->name("store");
                    Route::get("/{category}/edit", "edit")->middleware('permission:category.edit')->name("edit");
                    Route::post("/{category}", "update")->middleware('permission:category.edit')->name("update");
                    Route::delete("/{category}", "destroy")->middleware('permission:category.delete')->name("destroy");
                    Route::get("/trash", "trash")->middleware('permission:category.trash.list')->name("trash");
                    Route::post("/{category}/restore", "restore")->middleware('permission:category.trash.restore')->name("restore");
                    Route::delete("/{category}/force-delete", "forceDelete")->middleware('permission:category.trash.delete')->name("force.delete");
                    Route::get("/permanently-delete", "permanentlyDelete")->middleware('permission:category.trash.delete')->name("permanently.delete");
                });





























           Route::controller(AdminProductController::class)
                ->prefix("/products")
                ->name("products.")
                ->group(function () {
                    Route::get("/", "index")->middleware('permission:product.menu')->name("index");
                    Route::get("/{product}", "show")->middleware('permission:product.detail')->name("show");
                    Route::get("/create", "create")->middleware('permission:product.add')->name("create");
                    Route::post("/", "store")->middleware('permission:product.add')->name("store");
                    Route::get("/{product}/edit", "edit")->middleware('permission:product.edit')->name("edit");
                    Route::post("/{product}", "update")->middleware('permission:product.edit')->name("update");
                    Route::delete("/{product}", "destroy")->middleware('permission:product.delete')->name("destroy");
                    Route::get("/trash", "trash")->middleware('permission:product.trash.list')->name("trash");
                    Route::post("/{id}/restore", "restore")->middleware('permission:product.trash.restore')->name("restore");
                    Route::delete("/{id}/force-delete", "forceDelete")->middleware('permission:product.trash.delete')->name("force.delete");
                    Route::get("/permanently-delete", "permanentlyDelete")->middleware('permission:product.trash.delete')->name("permanently.delete");
                });
           Route::delete('products/{product_id}/images/{image_id}', [MultiImageController::class,"destroy"])->name("image.destroy");

           // Admin Dashboard Coupon Section
           Route::controller(AdminCouponController::class)
                ->prefix("/coupons")
                ->name("coupons.")
                ->group(function () {
                    Route::get("/", "index")->middleware('permission:coupon.menu')->name("index");
                    Route::get("/create", "create")->middleware('permission:coupon.add')->name("create");
                    Route::post("/", "store")->middleware('permission:coupon.add')->name("store");
                    Route::get("/{coupon}/edit", "edit")->middleware('permission:coupon.edit')->name("edit");
                    Route::post("/{coupon}", "update")->middleware('permission:coupon.edit')->name("update");
                    Route::delete("/{coupon}", "destroy")->middleware('permission:coupon.delete')->name("destroy");
                    Route::get("/trash", "trash")->middleware('permission:coupon.trash.list')->name("trash");
                    Route::post("/{id}/restore", "restore")->middleware('permission:coupon.trash.restore')->name("restore");
                    Route::delete("/{id}/force-delete", "forceDelete")->middleware('permission:coupon.trash.delete')->name("force.delete");
                    Route::get("/permanently-delete", "permanentlyDelete")->middleware('permission:coupon.trash.delete')->name("permanently.delete");
                });

           Route::controller(AdminSliderBannerController::class)
                ->prefix("/slider-banners")
                ->name("slider-banners.")
                ->group(function () {
                    Route::get("/", "index")->middleware('permission:banner.menu')->name("index");
                    Route::get("/create", "create")->middleware('permission:banner.add')->name("create");
                    Route::post("/", "store")->middleware('permission:banner.add')->name("store");
                    Route::get("/{slider_banner}/edit", "edit")->middleware('permission:banner.edit')->name("edit");
                    Route::post("/{slider_banner}", "update")->middleware('permission:banner.edit')->name("update");
                    Route::delete("/{slider_banner}", "destroy")->middleware('permission:banner.delete')->name("destroy");
                    Route::get("/trash", "trash")->middleware('permission:banner.trash.list')->name("trash");
                    Route::post("/{id}/restore", "restore")->middleware('permission:banner.trash.restore')->name("restore");
                    Route::delete("/{id}/force-delete", "forceDelete")->middleware('permission:banner.trash.delete')->name("force.delete");
                    Route::get("/permanently-delete", "permanentlyDelete")->middleware('permission:banner.trash.delete')->name("permanently.delete");
                    Route::post("/{id}/show", "handleShow")->middleware('permission:banner.control')->name("show");
                    Route::post("/{id}/hide", "handleHide")->middleware('permission:banner.control')->name("hide");
                });

           Route::controller(AdminProductBannerController::class)
                ->prefix("/product-banners")
                ->name("product-banners.")
                ->group(function () {
                    Route::get("/", "index")->middleware('permission:banner.menu')->name("index");
                    Route::get("/create", "create")->middleware('permission:banner.add')->name("create");
                    Route::post("/", "store")->middleware('permission:banner.add')->name("store");
                    Route::get("/{product_banner}/edit", "edit")->middleware('permission:banner.edit')->name("edit");
                    Route::post("/{product_banner}", "update")->middleware('permission:banner.edit')->name("update");
                    Route::delete("/{product_banner}", "destroy")->middleware('permission:banner.delete')->name("destroy");
                    Route::get("/trash", "trash")->middleware('permission:banner.trash.list')->name("trash");
                    Route::post("/{id}/restore", "restore")->middleware('permission:banner.trash.restore')->name("restore");
                    Route::delete("/{id}/force-delete", "forceDelete")->middleware('permission:banner.trash.delete')->name("force.delete");
                    Route::get("/permanently-delete", "permanentlyDelete")->middleware('permission:banner.trash.delete')->name("permanently.delete");
                    Route::post("/{id}/show", "handleShow")->middleware('permission:banner.control')->name("show");
                    Route::post("/{id}/hide", "handleHide")->middleware('permission:banner.control')->name("hide");
                });

           Route::controller(AdminCampaignBannerController::class)
                ->prefix("/campaign-banners")
                ->name("campaign-banners.")
                ->group(function () {
                    Route::get("/", "index")->middleware('permission:banner.menu')->name("index");
                    Route::get("/create", "create")->middleware('permission:banner.add')->name("create");
                    Route::post("/", "store")->middleware('permission:banner.add')->name("store");
                    Route::get("/{campaign_banner}/edit", "edit")->middleware('permission:banner.edit')->name("edit");
                    Route::post("/{campaign_banner}", "update")->middleware('permission:banner.edit')->name("update");
                    Route::delete("/{campaign_banner}", "destroy")->middleware('permission:banner.delete')->name("destroy");
                    Route::get("/trash", "trash")->middleware('permission:banner.trash.list')->name("trash");
                    Route::post("/{id}/restore", "restore")->middleware('permission:banner.trash.restore')->name("restore");
                    Route::delete("/{id}/force-delete", "forceDelete")->middleware('permission:banner.trash.delete')->name("force.delete");
                    Route::get("/permanently-delete", "permanentlyDelete")->middleware('permission:banner.trash.delete')->name("permanently.delete");
                    Route::post("/{id}/show", "handleShow")->middleware('permission:banner.control')->name("show");
                    Route::post("/{id}/hide", "handleHide")->middleware('permission:banner.control')->name("hide");
                });

           Route::controller(AdminCountryController::class)
                ->prefix("/countries")
                ->name("countries.")
                ->group(function () {
                    Route::get("/", "index")->middleware('permission:shipping-area.menu')->name("index");
                    Route::get("/create", "create")->middleware('permission:shipping-area.add')->name("create");
                    Route::post("/", "store")->middleware('permission:shipping-area.add')->name("store");
                    Route::get("/{country}/edit", "edit")->middleware('permission:shipping-area.edit')->name("edit");
                    Route::post("/{country}", "update")->middleware('permission:shipping-area.edit')->name("update");
                    Route::delete("/{country}", "destroy")->middleware('permission:shipping-area.delete')->name("destroy");
                    Route::get("/trash", "trash")->middleware('permission:shipping-area.trash.list')->name("trash");
                    Route::post("/{id}/restore", "restore")->middleware('permission:shipping-area.trash.restore')->name("restore");
                    Route::delete("/{id}/force-delete", "forceDelete")->middleware('permission:shipping-area.trash.delete')->name("force.delete");
                    Route::get("/permanently-delete", "permanentlyDelete")->middleware('permission:shipping-area.trash.delete')->name("permanently.delete");
                });

           Route::controller(AdminRegionController::class)
                ->prefix("/regions")
                ->name("regions.")
                ->group(function () {
                    Route::get("/", "index")->middleware('permission:shipping-area.menu')->name("index");
                    Route::get("/create", "create")->middleware('permission:shipping-area.add')->name("create");
                    Route::post("/", "store")->middleware('permission:shipping-area.add')->name("store");
                    Route::get("/{region}/edit", "edit")->middleware('permission:shipping-area.edit')->name("edit");
                    Route::post("/{region}", "update")->middleware('permission:shipping-area.edit')->name("update");
                    Route::delete("/{region}", "destroy")->middleware('permission:shipping-area.delete')->name("destroy");
                    Route::get("/trash", "trash")->middleware('permission:shipping-area.trash.list')->name("trash");
                    Route::post("/{id}/restore", "restore")->middleware('permission:shipping-area.trash.restore')->name("restore");
                    Route::delete("/{id}/force-delete", "forceDelete")->middleware('permission:shipping-area.trash.delete')->name("force.delete");
                    Route::get("/permanently-delete", "permanentlyDelete")->middleware('permission:shipping-area.trash.delete')->name("permanently.delete");
                });

           Route::controller(AdminCityController::class)
                ->prefix("/cities")
                ->name("cities.")
                ->group(function () {
                    Route::get("/", "index")->middleware('permission:shipping-area.menu')->name("index");
                    Route::get("/create", "create")->middleware('permission:shipping-area.add')->name("create");
                    Route::post("/", "store")->middleware('permission:shipping-area.add')->name("store");
                    Route::get("/{city}/edit", "edit")->middleware('permission:shipping-area.edit')->name("edit");
                    Route::post("/{city}", "update")->middleware('permission:shipping-area.edit')->name("update");
                    Route::delete("/{city}", "destroy")->middleware('permission:shipping-area.delete')->name("destroy");
                    Route::get("/trash", "trash")->middleware('permission:shipping-area.trash.list')->name("trash");
                    Route::post("/{id}/restore", "restore")->middleware('permission:shipping-area.trash.restore')->name("restore");
                    Route::delete("/{id}/force-delete", "forceDelete")->middleware('permission:shipping-area.trash.delete')->name("force.delete");
                    Route::get("/permanently-delete", "permanentlyDelete")->middleware('permission:shipping-area.trash.delete')->name("permanently.delete");
                });

           Route::controller(AdminTownshipController::class)
                ->prefix("/townships")
                ->name("townships.")
                ->group(function () {
                    Route::get("/", "index")->middleware('permission:shipping-area.menu')->name("index");
                    Route::get("/create", "create")->middleware('permission:shipping-area.add')->name("create");
                    Route::post("/", "store")->middleware('permission:shipping-area.add')->name("store");
                    Route::get("/{township}/edit", "edit")->middleware('permission:shipping-area.edit')->name("edit");
                    Route::post("/{township}", "update")->middleware('permission:shipping-area.edit')->name("update");
                    Route::delete("/{township}", "destroy")->middleware('permission:shipping-area.delete')->name("destroy");
                    Route::get("/trash", "trash")->middleware('permission:shipping-area.trash.list')->name("trash");
                    Route::post("/{id}/restore", "restore")->middleware('permission:shipping-area.trash.restore')->name("restore");
                    Route::delete("/{id}/force-delete", "forceDelete")->middleware('permission:shipping-area.trash.delete')->name("force.delete");
                    Route::get("/permanently-delete", "permanentlyDelete")->middleware('permission:shipping-area.trash.delete')->name("permanently.delete");
                });

           // Admin Dashboard Language Section
           Route::controller(AdminLanguageController::class)
                ->prefix("/languages")
                ->name("languages.")
                ->group(function () {
                    Route::get("/", "index")->middleware('permission:language.menu')->name("index");
                    Route::get("/{language}", "languageDetail")->middleware('permission:language.detail')->name("show");
                    Route::post("/{language}/update", "updateLanguageDetail")->middleware('permission:language.detail')->name("update.detail");
                    Route::get("/create", "create")->middleware('permission:language.add')->name("create");
                    Route::post("/", "store")->middleware('permission:language.add')->name("store");
                    Route::get("/{language}/edit", "edit")->middleware('permission:language.edit')->name("edit");
                    Route::post("/{language}", "update")->middleware('permission:language.edit')->name("update");
                    Route::delete("/{language}", "destroy")->middleware('permission:language.delete')->name("destroy");
                    Route::get("/trash", "trash")->middleware('permission:language.trash.list')->name("trash");
                    Route::post("/{id}/restore", "restore")->middleware('permission:language.trash.restore')->name("restore");
                    Route::delete("/{id}/force-delete", "forceDelete")->middleware('permission:language.trash.delete')->name("force.delete");
                    Route::get("/permanently-delete", "permanentlyDelete")->middleware('permission:language.trash.delete')->name("permanently.delete");
                });

           Route::controller(AdminPendingOrderController::class)
                ->prefix("/order-manage/pending-orders")
                ->name("orders.pending.")
                ->group(function () {
                    Route::get("/", "index")->middleware('permission:order-manage.menu')->name("index");
                    Route::get("/{id}", "show")->middleware('permission:order-manage.detail')->name("show");
                    Route::post("/{id}", "update")->middleware('permission:order-manage.control')->name("update");
                });

           Route::controller(AdminConfirmedOrderController::class)
                ->prefix("/order-manage/confirmed-orders")
                ->name("orders.confirmed.")
                ->group(function () {
                    Route::get("/", "index")->middleware('permission:order-manage.menu')->name("index");
                    Route::get("/{id}", "show")->middleware('permission:order-manage.detail')->name("show");
                    Route::post("/{id}", "update")->middleware('permission:order-manage.control')->name("update");
                });

           Route::controller(AdminProcessingOrderController::class)
                ->prefix("/order-manage/processing-orders")
                ->name("orders.processing.")
                ->group(function () {
                    Route::get("/", "index")->middleware('permission:order-manage.menu')->name("index");
                    Route::get("/{id}", "show")->middleware('permission:order-manage.detail')->name("show");
                    Route::post("/{id}", "update")->middleware('permission:order-manage.control')->name("update");
                });

           Route::controller(AdminShippedOrderController::class)
                ->prefix("/order-manage/shipped-orders")
                ->name("orders.shipped.")
                ->group(function () {
                    Route::get("/", "index")->middleware('permission:order-manage.menu')->name("index");
                    Route::get("/{id}", "show")->middleware('permission:order-manage.detail')->name("show");
                    Route::post("/{id}", "update")->middleware('permission:order-manage.control')->name("update");
                });

           Route::controller(AdminDeliveredOrderController::class)
                 ->prefix("/order-manage/delivered-orders")
                 ->name("orders.delivered.")
                 ->group(function () {
                     Route::get("/", "index")->middleware('permission:order-manage.menu')->name("index");
                     Route::get("/{id}", "show")->middleware('permission:order-manage.detail')->name("show");
                 });


           Route::controller(AdminRequestedReturnOrderController::class)
                ->prefix("/return-order-manage/requested-return")
                ->name("return-orders.requested.")
                ->group(function () {
                    Route::get("/", "index")->middleware('permission:return-order-manage.menu')->name("index");
                    Route::get("/{id}", "show")->middleware('permission:return-order-manage.detail')->name("show");
                    Route::post("/{id}", "update")->middleware('permission:return-order-manage.control')->name("update");
                });

           Route::controller(AdminApprovedReturnOrderController::class)
                ->prefix("/return-order-manage/approved-return")
                ->name("return-orders.approved.")
                ->group(function () {
                    Route::get("/", "index")->middleware('permission:return-order-manage.menu')->name("index");
                    Route::get("/{id}", "show")->middleware('permission:return-order-manage.detail')->name("show");
                    Route::post("/{id}", "update")->middleware('permission:return-order-manage.control')->name("update");
                });

           Route::controller(AdminRefundedReturnOrderController::class)
                ->prefix("/return-order-manage/refunded-return")
                ->name("return-orders.refunded.")
                ->group(function () {
                    Route::get("/", "index")->middleware('permission:return-order-manage.menu')->name("index");
                    Route::get("/{id}", "show")->middleware('permission:return-order-manage.detail')->name("show");
                });

           Route::controller(AdminRequestedCancelOrderController::class)
           ->prefix("/cancel-order-manage/requested-cancel")
           ->name("cancel-orders.requested.")
           ->group(function () {
               Route::get("/", "index")->middleware('permission:cancel-order-manage.menu')->name("index");
               Route::get("/{id}", "show")->middleware('permission:cancel-order-manage.detail')->name("show");
               Route::post("/{id}", "update")->middleware('permission:cancel-order-manage.control')->name("update");
           });

           Route::controller(AdminApprovedCancelOrderController::class)
                ->prefix("/cancel-order-manage/approved-cancel")
                ->name("cancel-orders.approved.")
                ->group(function () {
                    Route::get("/", "index")->middleware('permission:cancel-order-manage.menu')->name("index");
                    Route::get("/{id}", "show")->middleware('permission:cancel-order-manage.detail')->name("show");
                });



           //    Admin Dashboard Pending Product Review Section
           Route::controller(AdminPendingProductReviewController::class)
           ->prefix("/product-reviews/pending-reviews")
           ->name("product-reviews.pending.")
           ->group(function () {
               Route::get("/", "index")->middleware('permission:product-review.menu')->name("index");
               Route::get("/{product_review}", "show")->middleware('permission:product-review.detail')->name("show");
               Route::post("/{product_review}", "update")->middleware('permission:product-review.control')->name("update");
               Route::delete("/{product_review}", "destroy")->middleware('permission:product-review.delete')->name("destroy");
               Route::get("/trash", "trash")->middleware('permission:product-review.trash.list')->name("trash");
               Route::post("/{id}/restore", "restore")->middleware('permission:product-review.trash.restore')->name("restore");
               Route::delete("/{id}/force-delete", "forceDelete")->middleware('permission:product-review.trash.delete')->name("force.delete");
               Route::get("/permanently-delete", "permanentlyDelete")->middleware('permission:product-review.trash.delete')->name("permanently.delete");
           });

           //    Admin Dashboard Published Product Review Section
           Route::controller(AdminPublishedProductReviewController::class)
           ->prefix("/product-reviews/published-reviews")
           ->name("product-reviews.published.")
           ->group(function () {
               Route::get("/", "index")->middleware('permission:product-review.menu')->name("index");
               Route::get("/{product_review}", "show")->middleware('permission:product-review.detail')->name("show");
               Route::post("/{product_review}", "update")->middleware('permission:product-review.control')->name("update");
               Route::delete("/{product_review}", "destroy")->middleware('permission:product-review.delete')->name("destroy");
               //    Route::get("/trash", "trash")->middleware('permission:product-review.trash.list')->name("trash");
               //    Route::post("/{id}/restore", "restore")->middleware('permission:product-review.trash.restore')->name("restore");
               //    Route::delete("/{id}/force-delete", "forceDelete")->middleware('permission:product-review.trash.delete')->name("force.delete");
               //    Route::get("/permanently-delete", "permanentlyDelete")->middleware('permission:product-review.trash.delete')->name("permanently.delete");
           });

           //    Admin Dashboard Pending Shop Review Section
           Route::controller(AdminPendingShopReviewController::class)
           ->prefix("/shop-reviews/pending-reviews")
           ->name("shop-reviews.pending.")
           ->group(function () {
               Route::get("/", "index")->middleware('permission:shop-review.menu')->name("index");
               Route::get("/{id}", "show")->middleware('permission:shop-review.detail')->name("show");
               Route::post("/{id}", "update")->middleware('permission:shop-review.control')->name("update");
           });

           //    Admin Dashboard Published Shop Review Section
           Route::controller(AdminPublishedShopReviewController::class)
           ->prefix("/shop-reviews/published-reviews")
           ->name("shop-reviews.published.")
           ->group(function () {
               Route::get("/", "index")->middleware('permission:shop-review.menu')->name("index");
               Route::get("/{id}", "show")->middleware('permission:shop-review.detail')->name("show");
               Route::post("/{id}", "update")->middleware('permission:shop-review.control')->name("update");
               Route::delete("/{id}", "destroy")->middleware('permission:shop-review.delete')->name("destroy");
               //    Route::get("/trash", "trash")->middleware('permission:shop-review.trash.list')->name("trash");
               //    Route::post("/{id}/restore", "restore")->middleware('permission:shop-review.trash.restore')->name("restore");
               //    Route::delete("/{id}/force-delete", "forceDelete")->middleware('permission:shop-review.trash.delete')->name("force.delete");
               //    Route::get("/permanently-delete", "permanentlyDelete")->middleware('permission:shop-review.trash.delete')->name("permanently.delete");
           });


           // Admin Dashboard Inactive Vendor Section
           Route::controller(AdminInactiveVendorController::class)
                ->prefix("/vendor-manage/inactive-vendors")
                ->name("vendors.inactive.")
                ->group(function () {
                    Route::get("/", "index")->middleware('permission:vendor-manage.menu')->name("index");
                    Route::get("/{id}", "show")->middleware('permission:vendor-manage.detail')->name("show");
                    Route::post("/{id}", "update")->middleware('permission:vendor-manage.control')->name("update");
                    Route::delete("/{id}", "destroy")->middleware('permission:vendor-manage.delete')->name("destroy");
                    Route::get("/trash", "trash")->middleware('permission:vendor-manage.trash.list')->name("trash");
                    Route::post("/{id}/restore", "restore")->middleware('permission:vendor-manage.trash.restore')->name("restore");
                    Route::delete("/{id}/force-delete", "forceDelete")->middleware('permission:vendor-manage.trash.delete')->name("force.delete");
                    Route::get("/permanently-delete", "permanentlyDelete")->middleware('permission:vendor-manage.trash.delete')->name("permanently.delete");
                });

           // Admin Dashboard Active Vendor Section
           Route::controller(AdminActiveVendorController::class)
                ->prefix("/vendor-manage/active-vendors")
                ->name("vendors.active.")
                ->group(function () {
                    Route::get("/", "index")->middleware('permission:vendor-manage.menu')->name("index");
                    Route::get("/{id}", "show")->middleware('permission:vendor-manage.detail')->name("show");
                    Route::post("/{id}", "update")->middleware('permission:vendor-manage.control')->name("update");
                });

           // Admin Dashboard Register User Section
           Route::controller(AdminRegisterUserController::class)
                ->prefix("/user-manage/register-users")
                ->name("users.register.")
                ->group(function () {
                    Route::get("/", "index")->middleware('permission:user-manage.menu')->name("index");
                    Route::get("/{user}", "show")->middleware('permission:user-manage.detail')->name("show");
                    Route::delete("/{user}", "destroy")->middleware('permission:user-manage.delete')->name("destroy");
                    Route::get("/trash", "trash")->middleware('permission:user-manage.trash.list')->name("trash");
                    Route::post("/{id}/restore", "restore")->middleware('permission:user-manage.trash.restore')->name("restore");
                    Route::delete("/{id}/force-delete", "forceDelete")->middleware('permission:user-manage.trash.delete')->name("force.delete");
                    Route::get("/permanently-delete", "permanentlyDelete")->middleware('permission:user-manage.trash.delete')->name("permanently.delete");
                });

           // Admin Dashboard Register Vendor Section
           Route::controller(AdminRegisterVendorController::class)
                ->prefix("/user-manage/register-vendors")
                ->name("vendors.register.")
                ->group(function () {
                    Route::get("/", "index")->middleware('permission:user-manage.menu')->name("index");
                    Route::get("/{user}", "show")->middleware('permission:user-manage.detail')->name("show");
                    Route::delete("/{user}", "destroy")->middleware('permission:user-manage.delete')->name("destroy");
                    Route::get("/trash", "trash")->middleware('permission:user-manage.trash.list')->name("trash");
                    Route::post("/{id}/restore", "restore")->middleware('permission:user-manage.trash.restore')->name("restore");
                    Route::delete("/{id}/force-delete", "forceDelete")->middleware('permission:user-manage.trash.delete')->name("force.delete");
                    Route::get("/permanently-delete", "permanentlyDelete")->middleware('permission:user-manage.trash.delete')->name("permanently.delete");
                });

           // Admin Dashboard Admin Manage Section
           Route::controller(AdminManageController::class)
                ->prefix("/admin-manage")
                ->name("admin-manage.")
                ->group(function () {
                    Route::get("/", "index")->middleware('permission:admin-manage.menu')->name("index");
                    Route::get("/{user}", "show")->middleware('permission:admin-manage.detail')->name("show");
                    Route::get("/create", "create")->middleware('permission:admin-manage.add')->name("create");
                    Route::post("/", "store")->middleware('permission:admin-manage.add')->name("store");
                    Route::get("/{user}/edit", "edit")->middleware('permission:admin-manage.edit')->name("edit");
                    Route::post("/{user}", "update")->middleware('permission:admin-manage.edit')->name("update");
                    Route::delete("/{user}", "destroy")->middleware('permission:admin-manage.delete')->name("destroy");
                    Route::get("/trash", "trash")->middleware('permission:admin-manage.trash.list')->name("trash");
                    Route::post("/{id}/restore", "restore")->middleware('permission:admin-manage.trash.restore')->name("restore");
                    Route::delete("/{id}/force-delete", "forceDelete")->middleware('permission:admin-manage.trash.delete')->name("force.delete");
                    Route::get("/permanently-delete", "permanentlyDelete")->middleware('permission:admin-manage.trash.delete')->name("permanently.delete");
                });

           // Admin Dashboard Role Section
           Route::controller(AdminRoleController::class)
                ->prefix("/roles-and-permissions/roles")
                ->name("roles.")
                ->group(function () {
                    Route::get("/", "index")->middleware('permission:role-and-permission.menu')->name("index");
                    Route::get("/create", "create")->middleware('permission:role-and-permission.add')->name("create");
                    Route::post("/", "store")->middleware('permission:role-and-permission.add')->name("store");
                    Route::get("/{role}/edit", "edit")->middleware('permission:role-and-permission.edit')->name("edit");
                    Route::post("/{role}", "update")->middleware('permission:role-and-permission.edit')->name("update");
                    Route::delete("/{role}", "destroy")->middleware('permission:role-and-permission.delete')->name("destroy");
                    Route::get("/trash", "trash")->middleware('permission:role-and-permission.trash.list')->name("trash");
                    Route::post("/{id}/restore", "restore")->middleware('permission:role-and-permission.trash.restore')->name("restore");
                    Route::delete("/{id}/force-delete", "forceDelete")->middleware('permission:role-and-permission.trash.delete')->name("force.delete");
                    Route::get("/permanently-delete", "permanentlyDelete")->middleware('permission:role-and-permission.trash.delete')->name("permanently.delete");
                });

           // Admin Dashboard Permission Section
           Route::controller(AdminPermissionController::class)
                ->prefix("/roles-and-permissions/permissions")
                ->name("permissions.")
                ->group(function () {
                    Route::get("/", "index")->middleware('permission:role-and-permission.menu')->name("index");
                    Route::get("/create", "create")->middleware('permission:role-and-permission.add')->name("create");
                    Route::post("/", "store")->middleware('permission:role-and-permission.add')->name("store");
                    Route::get("/{permission}/edit", "edit")->middleware('permission:role-and-permission.edit')->name("edit");
                    Route::post("/{permission}", "update")->middleware('permission:role-and-permission.edit')->name("update");
                    Route::delete("/{permission}", "destroy")->middleware('permission:role-and-permission.delete')->name("destroy");
                    Route::get("/trash", "trash")->middleware('permission:role-and-permission.trash.list')->name("trash");
                    Route::post("/{id}/restore", "restore")->middleware('permission:role-and-permission.trash.restore')->name("restore");
                    Route::delete("/{id}/force-delete", "forceDelete")->middleware('permission:role-and-permission.trash.delete')->name("force.delete");
                    Route::get("/permanently-delete", "permanentlyDelete")->middleware('permission:role-and-permission.trash.delete')->name("permanently.delete");
                });

           // Admin Dashboard Role In Permission Section
           Route::controller(AdminRoleInPermissionController::class)
                ->prefix("/role-in-permissions")
                ->name("role-in-permissions.")
                ->group(function () {
                    Route::get("/", "index")->middleware('permission:role-in-permissions.menu')->name("index");
                    Route::get("/create", "create")->middleware('permission:role-in-permissions.add')->name("create");
                    Route::post("/", "store")->middleware('permission:role-in-permissions.add')->name("store");
                    Route::get("/{role}/edit", "edit")->middleware('permission:role-in-permissions.edit')->name("edit");
                    Route::post("/{role}", "update")->middleware('permission:role-in-permissions.edit')->name("update");
                    Route::delete("/{role}", "destroy")->middleware('permission:role-in-permissions.delete')->name("destroy");
                });

           // Admin Privacy And Policy Section
           Route::controller(AdminPrivacyPolicyController::class)
           ->prefix("/pages/privacy-policy")
           ->name("pages.privacy-policy.")
           ->group(function () {
               Route::get("/", "edit")->middleware('permission:page.menu')->name("edit");
               Route::post("/{page}", "update")->middleware('permission:page.edit')->name("update");
           });

           // Admin Terms And Conditions Section
           Route::controller(AdminTermsAndConditionsController::class)
           ->prefix("/pages/terms-and-conditions")
           ->name("pages.terms-and-conditions.")
           ->group(function () {
               Route::get("/", "edit")->middleware('permission:page.menu')->name("edit");
               Route::post("/{page}", "update")->middleware('permission:page.edit')->name("update");
           });











           // Admin Faq Category Section
           Route::controller(AdminFaqCategoryController::class)
           ->prefix("/faq-categories/categories")
           ->name("faq-categories.categories.")
           ->group(function () {
               Route::get("/", "index")->middleware('permission:faq-category.menu')->name("index");
               Route::get("/create", "create")->middleware('permission:faq-category.add')->name("create");
               Route::post("/", "store")->middleware('permission:faq-category.add')->name("store");
               Route::get("/{blog_category}/edit", "edit")->middleware('permission:faq-category.edit')->name("edit");
               Route::post("/{blog_category}", "update")->middleware('permission:faq-category.edit')->name("update");
               Route::delete("/{blog_category}", "destroy")->middleware('permission:faq-category.delete')->name("destroy");
               Route::get("/trash", "trash")->middleware('permission:faq-category.trash.list')->name("trash");
               Route::post("/{blog_category}/restore", "restore")->middleware('permission:faq-category.trash.restore')->name("restore");
               Route::delete("/{blog_category}/force-delete", "forceDelete")->middleware('permission:faq-category.trash.delete')->name("force.delete");
               Route::get("/permanently-delete", "permanentlyDelete")->middleware('permission:faq-category.trash.delete')->name("permanently.delete");
           });
           // Admin Faq Sub Category Section
           Route::controller(AdminFaqSubCategoryController::class)
           ->prefix("/faq-categories/sub-categories")
           ->name("faq-categories.sub-categories.")
           ->group(function () {
               Route::get("/", "index")->middleware('permission:faq-category.menu')->name("index");
               Route::get("/create", "create")->middleware('permission:faq-category.add')->name("create");
               Route::post("/", "store")->middleware('permission:faq-category.add')->name("store");
               Route::get("/{blog_category}/edit", "edit")->middleware('permission:faq-category.edit')->name("edit");
               Route::post("/{blog_category}", "update")->middleware('permission:faq-category.edit')->name("update");
               Route::delete("/{blog_category}", "destroy")->middleware('permission:faq-category.delete')->name("destroy");
               Route::get("/trash", "trash")->middleware('permission:faq-category.trash.list')->name("trash");
               Route::post("/{blog_category}/restore", "restore")->middleware('permission:faq-category.trash.restore')->name("restore");
               Route::delete("/{blog_category}/force-delete", "forceDelete")->middleware('permission:faq-category.trash.delete')->name("force.delete");
               Route::get("/permanently-delete", "permanentlyDelete")->middleware('permission:faq-category.trash.delete')->name("permanently.delete");
           });




















           // Admin Blog Category Section
           Route::controller(AdminBlogCategoryController::class)
                ->prefix("/blogs/categories")
                ->name("blogs.categories.")
                ->group(function () {
                    Route::get("/", "index")->middleware('permission:blog-category.menu')->name("index");
                    Route::get("/create", "create")->middleware('permission:blog-category.add')->name("create");
                    Route::post("/", "store")->middleware('permission:blog-category.add')->name("store");
                    Route::get("/{blog_category}/edit", "edit")->middleware('permission:blog-category.edit')->name("edit");
                    Route::post("/{blog_category}", "update")->middleware('permission:blog-category.edit')->name("update");
                    Route::delete("/{blog_category}", "destroy")->middleware('permission:blog-category.delete')->name("destroy");
                    Route::get("/trash", "trash")->middleware('permission:blog-category.trash.list')->name("trash");
                    Route::post("/{blog_category}/restore", "restore")->middleware('permission:blog-category.trash.restore')->name("restore");
                    Route::delete("/{blog_category}/force-delete", "forceDelete")->middleware('permission:blog-category.trash.delete')->name("force.delete");
                    Route::get("/permanently-delete", "permanentlyDelete")->middleware('permission:blog-category.trash.delete')->name("permanently.delete");
                });

           // Admin Blog Post Section
           Route::controller(AdminBlogPostController::class)
                ->prefix("/blogs/posts")
                ->name("blogs.posts.")
                ->group(function () {
                    Route::get("/", "index")->middleware('permission:blog-post.menu')->name("index");
                    Route::get("/create", "create")->middleware('permission:blog-post.add')->name("create");
                    Route::post("/", "store")->middleware('permission:blog-post.add')->name("store");
                    Route::get("/{blog_post}/edit", "edit")->middleware('permission:blog-post.edit')->name("edit");
                    Route::post("/{blog_post}", "update")->middleware('permission:blog-post.edit')->name("update");
                    Route::delete("/{blog_post}", "destroy")->middleware('permission:blog-post.delete')->name("destroy");
                    Route::get("/trash", "trash")->middleware('permission:blog-post.trash.list')->name("trash");
                    Route::post("/{blog_post}/restore", "restore")->middleware('permission:blog-post.trash.restore')->name("restore");
                    Route::delete("/{blog_post}/force-delete", "forceDelete")->middleware('permission:blog-post.trash.delete')->name("force.delete");
                    Route::get("/permanently-delete", "permanentlyDelete")->middleware('permission:blog-post.trash.delete')->name("permanently.delete");
                });

           // Admin Website Setting Section
           Route::controller(AdminWebsiteSettingController::class)
                ->prefix("/settings/website-settings")
                ->name("website-settings.")
                ->group(function () {
                    Route::get("/", "edit")->middleware('permission:setting.menu')->name("edit");
                    Route::post("/{website_setting}", "update")->middleware('permission:setting.edit')->name("update");
                });

           // Admin Seo Setting Section
           Route::controller(AdminSeoSettingController::class)
                ->prefix("/settings/seo-settings")
                ->name("seo-settings.")
                ->group(function () {
                    Route::get("/", "edit")->middleware('permission:setting.menu')->name("edit");
                    Route::post("/{seo_setting}", "update")->middleware('permission:setting.edit')->name("update");
                });

           // Admin Subscribers Section
           Route::controller(AdminSubscriberController::class)
                ->prefix("/subscribers")
                ->name("subscribers.")
                ->group(function () {
                    Route::get("/", "index")->middleware('permission:subscriber.menu')->name("index");
                    Route::delete("/{subscriber}", "destroy")->middleware('permission:subscriber.delete')->name("destroy");
                    Route::get("/trash", "trash")->middleware('permission:subscriber.trash.list')->name("trash");
                    Route::post("/{subscriber}/restore", "restore")->middleware('permission:subscriber.trash.restore')->name("restore");
                    Route::delete("/{subscriber}/force-delete", "forceDelete")->middleware('permission:subscriber.trash.delete')->name("force.delete");
                    Route::get("/permanently-delete", "permanentlyDelete")->middleware('permission:subscriber.trash.delete')->name("permanently.delete");
                });

           // Admin Suggestions Section
           Route::controller(AdminSuggestionController::class)
                ->prefix("/suggestions")
                ->name("suggestions.")
                ->group(function () {
                    Route::get("/", "index")->middleware('permission:suggestion.menu')->name("index");
                    Route::get("/{suggestion}", "show")->middleware('permission:suggestion.detail')->name("show");
                    Route::delete("/{suggestion}", "destroy")->middleware('permission:suggestion.delete')->name("destroy");
                    Route::get("/trash", "trash")->middleware('permission:suggestion.trash.list')->name("trash");
                    Route::post("/{suggestion}/restore", "restore")->middleware('permission:suggestion.trash.restore')->name("restore");
                    Route::delete("/{suggestion}/force-delete", "forceDelete")->middleware('permission:suggestion.trash.delete')->name("force.delete");
                    Route::get("/permanently-delete", "permanentlyDelete")->middleware('permission:suggestion.trash.delete')->name("permanently.delete");
                });

           // Admin Website Feedbacks Section
           Route::controller(AdminWebsiteFeedbackController::class)
                ->prefix("/website-feedbacks")
                ->name("website-feedbacks.")
                ->group(function () {
                    Route::get("/", "index")->middleware('permission:website-feedback.menu')->name("index");
                    Route::get("/{website_feedback}", "show")->middleware('permission:website-feedback.detail')->name("show");
                    Route::delete("/{website_feedback}", "destroy")->middleware('permission:website-feedback.delete')->name("destroy");
                    Route::get("/trash", "trash")->middleware('permission:website-feedback.trash.list')->name("trash");
                    Route::post("/{website_feedback}/restore", "restore")->middleware('permission:website-feedback.trash.restore')->name("restore");
                    Route::delete("/{website_feedback}/force-delete", "forceDelete")->middleware('permission:website-feedback.trash.delete')->name("force.delete");
                    Route::get("/permanently-delete", "permanentlyDelete")->middleware('permission:website-feedback.trash.delete')->name("permanently.delete");
                });
       });
