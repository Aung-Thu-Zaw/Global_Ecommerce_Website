<?php

use App\Http\Controllers\Admin\Auth\AdminAuthController;
use App\Http\Controllers\Admin\AdminBrandController;
use App\Http\Controllers\Admin\Banners\AdminCampaignBannerController;
use App\Http\Controllers\Admin\AdminCollectionController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminCouponController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminMultiImageController;
use App\Http\Controllers\Admin\Banners\AdminProductBannerController;
use App\Http\Controllers\Admin\Managements\VendorManage\AdminActiveVendorController;
use App\Http\Controllers\Admin\Managements\VendorManage\AdminInactiveVendorController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\SiteSettings\AdminSeoSettingController;
use App\Http\Controllers\Admin\SiteSettings\AdminWebsiteSettingController;
use App\Http\Controllers\Admin\Banners\AdminSliderBannerController;
use App\Http\Controllers\Admin\OrderManagements\AdminPendingOrderController;
use App\Http\Controllers\Admin\ShippingArea\AdminCityController;
use App\Http\Controllers\Admin\ShippingArea\AdminCountryController;
use App\Http\Controllers\Admin\ShippingArea\AdminRegionController;
use App\Http\Controllers\Admin\ShippingArea\AdminTownshipController;
use Illuminate\Support\Facades\Route;

Route::get("/admin/login", [AdminAuthController::class,"login"])->name("admin.login");

Route::middleware(["auth","verified","user.role:admin"])
       ->prefix("admin")
       ->name("admin.")
       ->group(function () {

           Route::get("/dashboard", [AdminDashboardController::class,"index"])->name("dashboard");

           // Brands
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

           // Collections
           Route::controller(AdminCollectionController::class)
           ->prefix("/collections")
           ->name("collections.")
           ->group(function () {
               Route::get("/", "index")->name("index");
               Route::get("/create", "create")->name("create");
               Route::post("/", "store")->name("store");
               Route::get("/{collection}/edit", "edit")->name("edit");
               Route::post("/{collection}", "update")->name("update");
               Route::delete("/{collection}", "destroy")->name("destroy");
               Route::get("/trash", "trash")->name("trash");
               Route::post("/{id}/restore", "restore")->name("restore");
               Route::delete("/{id}/force-delete", "forceDelete")->name("forceDelete");
               Route::get("/permanently-delete", "permanentlyDelete")->name("permanentlyDelete");
           });

           // Categories
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

           // Products
           Route::controller(AdminProductController::class)
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
           Route::delete('products/{product_id}/images/{image_id}', [AdminMultiImageController::class,"destroy"])->name("image.destroy");

           // Coupons
           Route::controller(AdminCouponController::class)
           ->prefix("/coupons")
           ->name("coupons.")
           ->group(function () {
               Route::get("/", "index")->name("index");
               Route::get("/create", "create")->name("create");
               Route::post("/", "store")->name("store");
               Route::get("/{coupon}/edit", "edit")->name("edit");
               Route::post("/{coupon}", "update")->name("update");
               Route::delete("/{coupon}", "destroy")->name("destroy");
               Route::get("/trash", "trash")->name("trash");
               Route::post("/{id}/restore", "restore")->name("restore");
               Route::delete("/{id}/force-delete", "forceDelete")->name("forceDelete");
               Route::get("/permanently-delete", "permanentlyDelete")->name("permanentlyDelete");
           });

           // Slider Banner
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

           // Product Banner
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

           // Campaign Banner
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

           // Shipping Area ( Country )
           Route::controller(AdminCountryController::class)
           ->prefix("/countries")
           ->name("countries.")
           ->group(function () {
               Route::get("/", "index")->name("index");
               Route::get("/create", "create")->name("create");
               Route::post("/", "store")->name("store");
               Route::get("/{country}/edit", "edit")->name("edit");
               Route::post("/{country}", "update")->name("update");
               Route::delete("/{country}", "destroy")->name("destroy");
               Route::get("/trash", "trash")->name("trash");
               Route::post("/{id}/restore", "restore")->name("restore");
               Route::delete("/{id}/force-delete", "forceDelete")->name("forceDelete");
               Route::get("/permanently-delete", "permanentlyDelete")->name("permanentlyDelete");
           });

           //  Shipping Area ( Region )
           Route::controller(AdminRegionController::class)
           ->prefix("/regions")
           ->name("regions.")
           ->group(function () {
               Route::get("/", "index")->name("index");
               Route::get("/create", "create")->name("create");
               Route::post("/", "store")->name("store");
               Route::get("/{region}/edit", "edit")->name("edit");
               Route::post("/{region}", "update")->name("update");
               Route::delete("/{region}", "destroy")->name("destroy");
               Route::get("/trash", "trash")->name("trash");
               Route::post("/{id}/restore", "restore")->name("restore");
               Route::delete("/{id}/force-delete", "forceDelete")->name("forceDelete");
               Route::get("/permanently-delete", "permanentlyDelete")->name("permanentlyDelete");
           });

           //  Shipping Area ( City )
           Route::controller(AdminCityController::class)
           ->prefix("/cities")
           ->name("cities.")
           ->group(function () {
               Route::get("/", "index")->name("index");
               Route::get("/create", "create")->name("create");
               Route::post("/", "store")->name("store");
               Route::get("/{city}/edit", "edit")->name("edit");
               Route::post("/{city}", "update")->name("update");
               Route::delete("/{city}", "destroy")->name("destroy");
               Route::get("/trash", "trash")->name("trash");
               Route::post("/{id}/restore", "restore")->name("restore");
               Route::delete("/{id}/force-delete", "forceDelete")->name("forceDelete");
               Route::get("/permanently-delete", "permanentlyDelete")->name("permanentlyDelete");
           });

           //  Shipping Area ( Township )
           Route::controller(AdminTownshipController::class)
           ->prefix("/townships")
           ->name("townships.")
           ->group(function () {
               Route::get("/", "index")->name("index");
               Route::get("/create", "create")->name("create");
               Route::post("/", "store")->name("store");
               Route::get("/{township}/edit", "edit")->name("edit");
               Route::post("/{township}", "update")->name("update");
               Route::delete("/{township}", "destroy")->name("destroy");
               Route::get("/trash", "trash")->name("trash");
               Route::post("/{id}/restore", "restore")->name("restore");
               Route::delete("/{id}/force-delete", "forceDelete")->name("forceDelete");
               Route::get("/permanently-delete", "permanentlyDelete")->name("permanentlyDelete");
           });

           // Pending Order Management
           Route::controller(AdminPendingOrderController::class)
                   ->prefix("/order-manage/pending-orders")
                   ->name("orders.pending.")
                   ->group(function () {
                       Route::get("/", "index")->name("index");
                       Route::get("/details/{id}", "show")->name("show");
                       //    Route::post("/{id}", "update")->name("update");
                       //    Route::delete("/{id}", "destroy")->name("destroy");
                       //    Route::get("/trash", "trash")->name("trash");
                       //    Route::post("/{id}/restore", "restore")->name("restore");
                       //    Route::delete("/{id}/force-delete", "forceDelete")->name("forceDelete");
                       //    Route::get("/permanently-delete", "permanentlyDelete")->name("permanentlyDelete");
                   });

           // Confirmed Order Management
           //    Route::controller(AdminConfirmedOrderController::class)
           //            ->prefix("/order-manage/pending-orders")
           //            ->name("orders.pending.")
           //            ->group(function () {
           //                Route::get("/", "index")->name("index");
           //    Route::get("/details/{id}", "show")->name("show");
           //    Route::post("/{id}", "update")->name("update");
           //    Route::delete("/{id}", "destroy")->name("destroy");
           //    Route::get("/trash", "trash")->name("trash");
           //    Route::post("/{id}/restore", "restore")->name("restore");
           //    Route::delete("/{id}/force-delete", "forceDelete")->name("forceDelete");
           //    Route::get("/permanently-delete", "permanentlyDelete")->name("permanentlyDelete");
           //    });

           // Processing Order Management
           //    Route::controller(AdminPendingOrderController::class)
           //            ->prefix("/order-manage/pending-orders")
           //            ->name("orders.pending.")
           //            ->group(function () {
           //                Route::get("/", "index")->name("index");
           //    Route::get("/details/{id}", "show")->name("show");
           //    Route::post("/{id}", "update")->name("update");
           //    Route::delete("/{id}", "destroy")->name("destroy");
           //    Route::get("/trash", "trash")->name("trash");
           //    Route::post("/{id}/restore", "restore")->name("restore");
           //    Route::delete("/{id}/force-delete", "forceDelete")->name("forceDelete");
           //    Route::get("/permanently-delete", "permanentlyDelete")->name("permanentlyDelete");
           //    });

           // Shipped Order Management
           //    Route::controller(AdminPendingOrderController::class)
           //            ->prefix("/order-manage/pending-orders")
           //            ->name("orders.pending.")
           //            ->group(function () {
           //                Route::get("/", "index")->name("index");
           //    Route::get("/details/{id}", "show")->name("show");
           //    Route::post("/{id}", "update")->name("update");
           //    Route::delete("/{id}", "destroy")->name("destroy");
           //    Route::get("/trash", "trash")->name("trash");
           //    Route::post("/{id}/restore", "restore")->name("restore");
           //    Route::delete("/{id}/force-delete", "forceDelete")->name("forceDelete");
           //    Route::get("/permanently-delete", "permanentlyDelete")->name("permanentlyDelete");
           //    });

           // Inactive Vendors Management
           Route::controller(AdminInactiveVendorController::class)
                   ->prefix("/vendor-manage/inactive-vendors")
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

           // Active Vendors Management
           Route::controller(AdminActiveVendorController::class)
                   ->prefix("/vendor-manage/active-vendors")
                   ->name("vendors.active.")
                   ->group(function () {
                       Route::get("/", "index")->name("index");
                       Route::get("/details/{id}", "show")->name("show");
                       Route::post("/{id}", "update")->name("update");
                   });

           // Website Settings
           Route::controller(AdminWebsiteSettingController::class)
           ->prefix("/website-settings")
           ->name("website-settings.")
           ->group(function () {
               Route::get("/", "edit")->name("edit");
               Route::post("/{website_setting}", "update")->name("update");
           });

           // SEO Settings
           Route::controller(AdminSeoSettingController::class)
           ->prefix("/seo-settings")
           ->name("seo-settings.")
           ->group(function () {
               Route::get("/", "edit")->name("edit");
               Route::post("/{seo_setting}", "update")->name("update");
           });
       });
