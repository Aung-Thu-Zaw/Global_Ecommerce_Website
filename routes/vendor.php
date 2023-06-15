<?php

use App\Http\Controllers\MultiImageController;
use App\Http\Controllers\Vendor\VendorAuthController;
use App\Http\Controllers\Vendor\VendorDashboardController;
use App\Http\Controllers\Vendor\VendorOrderController;
use App\Http\Controllers\Vendor\VendorProductBannerController;
use App\Http\Controllers\Vendor\VendorProductController;
use Illuminate\Support\Facades\Route;

Route::get("vendor/register", [VendorAuthController::class,"register"])->middleware("guest")->name("vendor.register");
Route::get("vendor/login", [VendorAuthController::class,"login"])->middleware("guest")->name("vendor.login");

Route::middleware(["vendor","user.role:vendor"])
        ->prefix("vendor")
        ->name("vendor.")
        ->group(function () {

            Route::get("/dashboard", [VendorDashboardController::class,"index"])->name("dashboard");

            // Products
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
                Route::post("/{id}/restore", "restore")->name("restore");
                Route::delete("/{id}/force-delete", "forceDelete")->name("forceDelete");
                Route::get("/permanently-delete", "permanentlyDelete")->name("permanentlyDelete");
            });
            Route::delete('products/{product_id}/images/{image_id}', [MultiImageController::class,"destroy"])->name("image.destroy");


            // Product Banner
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
                        Route::post("/{id}/restore", "restore")->name("restore");
                        Route::delete("/{id}/force-delete", "forceDelete")->name("forceDelete");
                        Route::post("/{id}/show", "handleShow")->name("show");
                        Route::post("/{id}/hide", "handleHide")->name("hide");
                        Route::get("/permanently-delete", "permanentlyDelete")->name("permanentlyDelete");
                    });


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
