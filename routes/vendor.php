<?php

use App\Http\Controllers\MultiImageController;
use App\Http\Controllers\Vendor\VendorAuthController;
use App\Http\Controllers\Vendor\VendorDashboardController;
use App\Http\Controllers\Vendor\VendorDashboardGuideController;
use App\Http\Controllers\Vendor\VendorDashboardNotificationController;
use App\Http\Controllers\Vendor\VendorOrderController;
use App\Http\Controllers\Vendor\VendorProductBannerController;
use App\Http\Controllers\Vendor\VendorProductController;
use App\Http\Controllers\Vendor\VendorProductReviewController;
use Illuminate\Support\Facades\Route;

Route::get("vendor/register", [VendorAuthController::class,"register"])->middleware("guest")->name("vendor.register");
Route::get("vendor/login", [VendorAuthController::class,"login"])->middleware("guest")->name("vendor.login");

Route::middleware(["vendor","user.role:vendor"])
     ->prefix("vendor")
     ->name("vendor.")
     ->group(function () {

         // Dashboard Section
         Route::get("/dashboard", [VendorDashboardController::class,"index"])->name("dashboard");

         // Dashboard Notification
         Route::post("/notifications/{notification_id}/read", [VendorDashboardNotificationController::class,"reatNotification"])->name("notifications.read");

         // Vendor Products Section
         Route::controller(VendorProductController::class)
              ->prefix("/products")
              ->name("products.")
              ->group(function () {
                  Route::get("/", "index")->name("index");
                  Route::get("/create", "create")->name("create");
                  Route::post("/", "store")->name("store");
                  Route::get("/{product}/edit", "edit")->name("edit");
                  Route::post("/{product}", "update")->name("update");
                  Route::delete("/{product}", "destroy")->name("destroy");
                  Route::get("/trash", "trash")->name("trash");
                  Route::post("/{product}/restore", "restore")->name("restore");
                  Route::delete("/{product}/force-delete", "forceDelete")->name("force.delete");
                  Route::get("/permanently-delete", "permanentlyDelete")->name("permanently.delete");
              });

         Route::delete('products/{product_id}/images/{image_id}', [MultiImageController::class,"destroy"])->name("image.destroy");

         // Vendor Product Banners Section
         Route::controller(VendorProductBannerController::class)
              ->prefix("/product-banners")
              ->name("product-banners.")
              ->group(function () {
                  Route::get("/", "index")->name("index");
                  Route::get("/create", "create")->name("create");
                  Route::post("/", "store")->name("store");
                  Route::get("/{vendor_product_banner}/edit", "edit")->name("edit");
                  Route::post("/{vendor_product_banner}", "update")->name("update");
                  Route::delete("/{vendor_product_banner}", "destroy")->name("destroy");
                  Route::get("/trash", "trash")->name("trash");
                  Route::post("/{vendor_product_banner}/restore", "restore")->name("restore");
                  Route::delete("/{vendor_product_banner}/force-delete", "forceDelete")->name("forceDelete");
                  Route::post("/{vendor_product_banner}/show", "handleShow")->name("show");
                  Route::post("/{vendor_product_banner}/hide", "handleHide")->name("hide");
                  Route::get("/permanently-delete", "permanentlyDelete")->name("permanentlyDelete");
              });



         // Vendor Product Reviews Section
         Route::controller(VendorProductReviewController::class)
              ->prefix("/product-reviews")
              ->name("product-reviews.")
              ->group(function () {
                  Route::get("/", "index")->name("index");
                  Route::get("/{product_review}", "show")->name("show");
              });

         // Vendor Dashboard Guide Section
         Route::get("/guide", [VendorDashboardGuideController::class,"index"])->name("dashboard.guide");







         // Vendor Orders
         Route::controller(VendorOrderController::class)
         ->prefix("/orders")
         ->name("orders.")
         ->group(function () {
             Route::get("/", "index")->name("index");
             Route::get("/details/{id}", "show")->name("show");
             Route::post("/{id}", "update")->name("update");
             //    Route::delete("/{id}", "destroy")->name("destroy");
             //    Route::get("/trash", "trash")->name("trash");
             //    Route::post("/{id}/restore", "restore")->name("restore");
             //    Route::delete("/{id}/force-delete", "forceDelete")->name("forceDelete");
             //    Route::get("/permanently-delete", "permanentlyDelete")->name("permanentlyDelete");
         });
     });
