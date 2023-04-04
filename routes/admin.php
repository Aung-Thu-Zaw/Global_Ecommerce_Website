<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminBrandController;
use App\Http\Controllers\Admin\AdminCampaignBannerController;
use App\Http\Controllers\Admin\Categories\AdminCategoryController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminMultiImageController;
use App\Http\Controllers\Admin\AdminProductBannerController;
use App\Http\Controllers\Admin\Categories\AdminSubCategoryController;
use App\Http\Controllers\Admin\Managements\AdminActiveVendorController;
use App\Http\Controllers\Admin\Managements\AdminInactiveVendorController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminSliderBannerController;
use Illuminate\Support\Facades\Route;

Route::get("/admin/login", [AdminAuthController::class,"login"])->name("admin.login");

Route::middleware(["auth","verified","user.role:admin"])
        ->prefix("admin")
        ->name("admin.")
        ->group(function () {
            Route::get("/dashboard", [AdminDashboardController::class,"index"])->name("dashboard");

            Route::controller(AdminInactiveVendorController::class)
                    ->prefix("/managements/inactive-vendors")
                    ->name("vendors.inactive.")
                    ->group(function () {
                        Route::get("/", "index")->name("index");
                        Route::get("/details/{id}", "show")->name("show");
                        Route::post("/{id}", "update")->name("update");
                        Route::delete("/{id}", "destroy")->name("destroy");
                        Route::get("/trash", "trash")->name("trash");
                        Route::post("/{id}/restore", "restore")->name("restore");
                        Route::delete("/{id}/force-delete", "forceDelete")->name("forceDelete");
                        Route::get("/permanently-delete", "permanentlyDelete")->name("permanentlyDelete");
                    });

            Route::controller(AdminActiveVendorController::class)
                    ->prefix("/managements/active-vendors")
                    ->name("vendors.active.")
                    ->group(function () {
                        Route::get("/", "index")->name("index");
                        Route::get("/details/{id}", "show")->name("show");
                        Route::post("/{id}", "update")->name("update");
                    });

            Route::controller(AdminCategoryController::class)
                    ->prefix("/categories")
                    ->name("categories.")
                    ->group(function () {
                        Route::get("/", "index")->name("index");
                        Route::get("/create", "create")->name("create");
                        Route::post("/", "store")->name("store");
                        Route::get("/{category}/edit", "edit")->name("edit");
                        Route::post("/{category}", "update")->name("update");
                        Route::delete("/{category}", "destroy")->name("destroy");
                        Route::get("/trash", "trash")->name("trash");
                        Route::post("/{id}/restore", "restore")->name("restore");
                        Route::delete("/{id}/force-delete", "forceDelete")->name("forceDelete");
                        Route::get("/permanently-delete", "permanentlyDelete")->name("permanentlyDelete");
                    });

            Route::controller(AdminSubCategoryController::class)
                    ->prefix("/sub-categories")
                    ->name("sub-categories.")
                    ->group(function () {
                        Route::get("/", "index")->name("index");
                        Route::get("/create", "create")->name("create");
                        Route::post("/", "store")->name("store");
                        Route::get("/{sub_category}/edit", "edit")->name("edit");
                        Route::post("/{sub_category}", "update")->name("update");
                        Route::delete("/{sub_category}", "destroy")->name("destroy");
                        Route::get("/trash", "trash")->name("trash");
                        Route::post("/{id}/restore", "restore")->name("restore");
                        Route::delete("/{id}/force-delete", "forceDelete")->name("forceDelete");
                        Route::get("/permanently-delete", "permanentlyDelete")->name("permanentlyDelete");
                    });

            Route::controller(AdminBrandController::class)
                    ->prefix("/brands")
                    ->name("brands.")
                    ->group(function () {
                        Route::get("/", "index")->name("index");
                        Route::get("/create", "create")->name("create");
                        Route::post("/", "store")->name("store");
                        Route::get("/{brand}/edit", "edit")->name("edit");
                        Route::post("/{brand}", "update")->name("update");
                        Route::delete("/{brand}", "destroy")->name("destroy");
                        Route::get("/trash", "trash")->name("trash");
                        Route::post("/{id}/restore", "restore")->name("restore");
                        Route::delete("/{id}/force-delete", "forceDelete")->name("forceDelete");
                        Route::get("/permanently-delete", "permanentlyDelete")->name("permanentlyDelete");
                    });

            Route::controller(AdminProductController::class)
                    ->prefix("/products")
                    ->name("products.")
                    ->group(function () {
                        Route::get("/", "index")->name("index");
                        Route::get("/create", "create")->name("create");
                        Route::post("/", "store")->name("store");
                        // Route::get("/{product}", "show")->name("show");
                        Route::get("/{product}/edit", "edit")->name("edit");
                        Route::post("/{product}", "update")->name("update");
                        Route::delete("/{product}", "destroy")->name("destroy");
                        Route::get("/trash", "trash")->name("trash");
                        Route::post("/{id}/restore", "restore")->name("restore");
                        Route::delete("/{id}/force-delete", "forceDelete")->name("forceDelete");
                        Route::get("/permanently-delete", "permanentlyDelete")->name("permanentlyDelete");
                    });



            Route::delete('products/{product_id}/images/{image_id}', [AdminMultiImageController::class,"destroy"])->name("image.destroy");


            Route::controller(AdminSliderBannerController::class)
                    ->prefix("/slider-banners")
                    ->name("slider-banners.")
                    ->group(function () {
                        Route::get("/", "index")->name("index");
                        Route::get("/create", "create")->name("create");
                        Route::post("/", "store")->name("store");
                        Route::get("/{slider_banner}/edit", "edit")->name("edit");
                        Route::post("/{slider_banner}", "update")->name("update");
                        Route::delete("/{slider_banner}", "destroy")->name("destroy");
                        Route::get("/trash", "trash")->name("trash");
                        Route::post("/{id}/restore", "restore")->name("restore");
                        Route::delete("/{id}/force-delete", "forceDelete")->name("forceDelete");
                        Route::post("/{id}/show", "handleShow")->name("show");
                        Route::post("/{id}/hide", "handleHide")->name("hide");
                        Route::get("/permanently-delete", "permanentlyDelete")->name("permanentlyDelete");
                    });

            Route::controller(AdminProductBannerController::class)
                    ->prefix("/product-banners")
                    ->name("product-banners.")
                    ->group(function () {
                        Route::get("/", "index")->name("index");
                        Route::get("/create", "create")->name("create");
                        Route::post("/", "store")->name("store");
                        Route::get("/{product_banner}/edit", "edit")->name("edit");
                        Route::post("/{product_banner}", "update")->name("update");
                        Route::delete("/{product_banner}", "destroy")->name("destroy");
                        Route::get("/trash", "trash")->name("trash");
                        Route::post("/{id}/restore", "restore")->name("restore");
                        Route::delete("/{id}/force-delete", "forceDelete")->name("forceDelete");
                        Route::post("/{id}/show", "handleShow")->name("show");
                        Route::post("/{id}/hide", "handleHide")->name("hide");
                        Route::get("/permanently-delete", "permanentlyDelete")->name("permanentlyDelete");
                    });

            Route::controller(AdminCampaignBannerController::class)
                    ->prefix("/campaign-banners")
                    ->name("campaign-banners.")
                    ->group(function () {
                        Route::get("/", "index")->name("index");
                        Route::get("/create", "create")->name("create");
                        Route::post("/", "store")->name("store");
                        Route::get("/{campaign_banner}/edit", "edit")->name("edit");
                        Route::post("/{campaign_banner}", "update")->name("update");
                        Route::delete("/{campaign_banner}", "destroy")->name("destroy");
                        Route::get("/trash", "trash")->name("trash");
                        Route::post("/{id}/restore", "restore")->name("restore");
                        Route::delete("/{id}/force-delete", "forceDelete")->name("forceDelete");
                        Route::post("/{id}/show", "handleShow")->name("show");
                        Route::post("/{id}/hide", "handleHide")->name("hide");
                        Route::get("/permanently-delete", "permanentlyDelete")->name("permanentlyDelete");
                    });
        });
