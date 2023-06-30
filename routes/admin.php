<?php

use App\Http\Controllers\Admin\Auth\AdminAuthController;
use App\Http\Controllers\Admin\AdminBrandController;
use App\Http\Controllers\Admin\Banners\AdminCampaignBannerController;
use App\Http\Controllers\Admin\AdminCollectionController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminCouponController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\MultiImageController;
use App\Http\Controllers\Admin\Banners\AdminProductBannerController;
use App\Http\Controllers\Admin\UserManagements\VendorManage\AdminActiveVendorController;
use App\Http\Controllers\Admin\UserManagements\VendorManage\AdminInactiveVendorController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AuthorityManagements\AdminRoleInPermissionController;
use App\Http\Controllers\Admin\SiteSettings\AdminSeoSettingController;
use App\Http\Controllers\Admin\SiteSettings\AdminWebsiteSettingController;
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
use App\Http\Controllers\Admin\FromTheSubmitters\AdminWebsiteFeedbackController;
use App\Http\Controllers\Admin\FromTheSubmitters\AdminSubscriberController;
use App\Http\Controllers\Admin\FromTheSubmitters\AdminSuggestionController;
use App\Http\Controllers\Admin\UserManagements\AdminManage\AdminManageController;
use Illuminate\Support\Facades\Route;

Route::get("/admin/login", [AdminAuthController::class,"login"])->middleware("guest")->name("admin.login");

Route::middleware(["admin","verified","user.role:admin"])
       ->prefix("admin")
       ->name("admin.")
       ->group(function () {

           Route::get("/dashboard", [AdminDashboardController::class,"index"])->name("dashboard");

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
                    Route::post("/{id}/restore", "restore")->middleware('permission:brand.trash.restore')->name("restore");
                    Route::delete("/{id}/force-delete", "forceDelete")->middleware('permission:brand.trash.delete')->name("forceDelete");
                    Route::get("/permanently-delete", "permanentlyDelete")->middleware('permission:brand.trash.delete')->name("permanentlyDelete");
                });

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
                    Route::post("/{id}/restore", "restore")->middleware('permission:collection.trash.restore')->name("restore");
                    Route::delete("/{id}/force-delete", "forceDelete")->middleware('permission:collection.trash.delete')->name("forceDelete");
                    Route::get("/permanently-delete", "permanentlyDelete")->middleware('permission:collection.trash.delete')->name("permanentlyDelete");
                });

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
                    Route::post("/{id}/restore", "restore")->middleware('permission:category.trash.restore')->name("restore");
                    Route::delete("/{id}/force-delete", "forceDelete")->middleware('permission:category.trash.delete')->name("forceDelete");
                    Route::get("/permanently-delete", "permanentlyDelete")->middleware('permission:category.trash.delete')->name("permanentlyDelete");
                });

           Route::controller(AdminProductController::class)
                ->prefix("/products")
                ->name("products.")
                ->group(function () {
                    Route::get("/", "index")->middleware('permission:product.menu')->name("index");
                    Route::get("/details/{product}", "show")->middleware('permission:product.detail')->name("show");
                    Route::get("/create", "create")->middleware('permission:product.add')->name("create");
                    Route::post("/", "store")->middleware('permission:product.add')->name("store");
                    Route::get("/{product}/edit", "edit")->middleware('permission:product.edit')->name("edit");
                    Route::post("/{product}", "update")->middleware('permission:product.edit')->name("update");
                    Route::delete("/{product}", "destroy")->middleware('permission:product.delete')->name("destroy");
                    Route::get("/trash", "trash")->middleware('permission:product.trash.list')->name("trash");
                    Route::post("/{id}/restore", "restore")->middleware('permission:product.trash.restore')->name("restore");
                    Route::delete("/{id}/force-delete", "forceDelete")->middleware('permission:product.trash.delete')->name("forceDelete");
                    Route::get("/permanently-delete", "permanentlyDelete")->middleware('permission:product.trash.delete')->name("permanentlyDelete");
                });
           Route::delete('products/{product_id}/images/{image_id}', [MultiImageController::class,"destroy"])->name("image.destroy");

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
                    Route::delete("/{id}/force-delete", "forceDelete")->middleware('permission:coupon.trash.delete')->name("forceDelete");
                    Route::get("/permanently-delete", "permanentlyDelete")->middleware('permission:coupon.trash.delete')->name("permanentlyDelete");
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
                    Route::delete("/{id}/force-delete", "forceDelete")->middleware('permission:banner.trash.delete')->name("forceDelete");
                    Route::get("/permanently-delete", "permanentlyDelete")->middleware('permission:banner.trash.delete')->name("permanentlyDelete");
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
                    Route::delete("/{id}/force-delete", "forceDelete")->middleware('permission:banner.trash.delete')->name("forceDelete");
                    Route::get("/permanently-delete", "permanentlyDelete")->middleware('permission:banner.trash.delete')->name("permanentlyDelete");
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
                    Route::delete("/{id}/force-delete", "forceDelete")->middleware('permission:banner.trash.delete')->name("forceDelete");
                    Route::get("/permanently-delete", "permanentlyDelete")->middleware('permission:banner.trash.delete')->name("permanentlyDelete");
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
                    Route::delete("/{id}/force-delete", "forceDelete")->middleware('permission:shipping-area.trash.delete')->name("forceDelete");
                    Route::get("/permanently-delete", "permanentlyDelete")->middleware('permission:shipping-area.trash.delete')->name("permanentlyDelete");
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
                    Route::delete("/{id}/force-delete", "forceDelete")->middleware('permission:shipping-area.trash.delete')->name("forceDelete");
                    Route::get("/permanently-delete", "permanentlyDelete")->middleware('permission:shipping-area.trash.delete')->name("permanentlyDelete");
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
                    Route::delete("/{id}/force-delete", "forceDelete")->middleware('permission:shipping-area.trash.delete')->name("forceDelete");
                    Route::get("/permanently-delete", "permanentlyDelete")->middleware('permission:shipping-area.trash.delete')->name("permanentlyDelete");
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
                    Route::delete("/{id}/force-delete", "forceDelete")->middleware('permission:shipping-area.trash.delete')->name("forceDelete");
                    Route::get("/permanently-delete", "permanentlyDelete")->middleware('permission:shipping-area.trash.delete')->name("permanentlyDelete");
                });

           Route::controller(AdminPendingOrderController::class)
                ->prefix("/order-manage/pending-orders")
                ->name("orders.pending.")
                ->group(function () {
                    Route::get("/", "index")->middleware('permission:order-manage.menu')->name("index");
                    Route::get("/details/{id}", "show")->middleware('permission:order-manage.detail')->name("show");
                    Route::post("/{id}", "update")->middleware('permission:order-manage.control')->name("update");
                });

           Route::controller(AdminConfirmedOrderController::class)
                ->prefix("/order-manage/confirmed-orders")
                ->name("orders.confirmed.")
                ->group(function () {
                    Route::get("/", "index")->middleware('permission:order-manage.menu')->name("index");
                    Route::get("/details/{id}", "show")->middleware('permission:order-manage.detail')->name("show");
                    Route::post("/{id}", "update")->middleware('permission:order-manage.control')->name("update");
                });

           Route::controller(AdminProcessingOrderController::class)
                ->prefix("/order-manage/processing-orders")
                ->name("orders.processing.")
                ->group(function () {
                    Route::get("/", "index")->middleware('permission:order-manage.menu')->name("index");
                    Route::get("/details/{id}", "show")->middleware('permission:order-manage.detail')->name("show");
                    Route::post("/{id}", "update")->middleware('permission:order-manage.control')->name("update");
                });

           Route::controller(AdminShippedOrderController::class)
                ->prefix("/order-manage/shipped-orders")
                ->name("orders.shipped.")
                ->group(function () {
                    Route::get("/", "index")->middleware('permission:order-manage.menu')->name("index");
                    Route::get("/details/{id}", "show")->middleware('permission:order-manage.detail')->name("show");
                    Route::post("/{id}", "update")->middleware('permission:order-manage.control')->name("update");
                });

           Route::controller(AdminDeliveredOrderController::class)
                 ->prefix("/order-manage/delivered-orders")
                 ->name("orders.delivered.")
                 ->group(function () {
                     Route::get("/", "index")->middleware('permission:order-manage.menu')->name("index");
                     Route::get("/details/{id}", "show")->middleware('permission:order-manage.detail')->name("show");
                 });


           Route::controller(AdminRequestedReturnOrderController::class)
                ->prefix("/return-order-manage/requested-return")
                ->name("return-orders.requested.")
                ->group(function () {
                    Route::get("/", "index")->middleware('permission:return-order-manage.menu')->name("index");
                    Route::get("/details/{id}", "show")->middleware('permission:return-order-manage.detail')->name("show");
                    Route::post("/{id}", "update")->middleware('permission:return-order-manage.control')->name("update");
                });

           Route::controller(AdminApprovedReturnOrderController::class)
                ->prefix("/return-order-manage/approved-return")
                ->name("return-orders.approved.")
                ->group(function () {
                    Route::get("/", "index")->middleware('permission:return-order-manage.menu')->name("index");
                    Route::get("/details/{id}", "show")->middleware('permission:return-order-manage.detail')->name("show");
                    Route::post("/{id}", "update")->middleware('permission:return-order-manage.control')->name("update");
                });

           Route::controller(AdminRefundedReturnOrderController::class)
                ->prefix("/return-order-manage/refunded-return")
                ->name("return-orders.refunded.")
                ->group(function () {
                    Route::get("/", "index")->middleware('permission:return-order-manage.menu')->name("index");
                    Route::get("/details/{id}", "show")->middleware('permission:return-order-manage.detail')->name("show");
                });

           Route::controller(AdminRequestedCancelOrderController::class)
           ->prefix("/cancel-order-manage/requested-cancel")
           ->name("cancel-orders.requested.")
           ->group(function () {
               Route::get("/", "index")->middleware('permission:cancel-order-manage.menu')->name("index");
               Route::get("/details/{id}", "show")->middleware('permission:cancel-order-manage.detail')->name("show");
               Route::post("/{id}", "update")->middleware('permission:cancel-order-manage.control')->name("update");
           });

           Route::controller(AdminApprovedCancelOrderController::class)
                ->prefix("/cancel-order-manage/approved-cancel")
                ->name("cancel-orders.approved.")
                ->group(function () {
                    Route::get("/", "index")->middleware('permission:cancel-order-manage.menu')->name("index");
                    Route::get("/details/{id}", "show")->middleware('permission:cancel-order-manage.detail')->name("show");
                });

           Route::controller(AdminInactiveVendorController::class)
                ->prefix("/vendor-manage/inactive-vendors")
                ->name("vendors.inactive.")
                ->group(function () {
                    Route::get("/", "index")->middleware('permission:vendor-manage.menu')->name("index");
                    Route::get("/details/{id}", "show")->middleware('permission:vendor-manage.detail')->name("show");
                    Route::post("/{id}", "update")->middleware('permission:vendor-manage.control')->name("update");
                    Route::delete("/{id}", "destroy")->middleware('permission:vendor-manage.delete')->name("destroy");
                    Route::get("/trash", "trash")->middleware('permission:vendor-manage.trash.list')->name("trash");
                    Route::post("/{id}/restore", "restore")->middleware('permission:vendor-manage.trash.restore')->name("restore");
                    Route::delete("/{id}/force-delete", "forceDelete")->middleware('permission:vendor-manage.trash.delete')->name("forceDelete");
                    Route::get("/permanently-delete", "permanentlyDelete")->middleware('permission:vendor-manage.trash.delete')->name("permanentlyDelete");
                });

           Route::controller(AdminActiveVendorController::class)
                ->prefix("/vendor-manage/active-vendors")
                ->name("vendors.active.")
                ->group(function () {
                    Route::get("/", "index")->middleware('permission:vendor-manage.menu')->name("index");
                    Route::get("/details/{id}", "show")->middleware('permission:vendor-manage.detail')->name("show");
                    Route::post("/{id}", "update")->middleware('permission:vendor-manage.control')->name("update");
                });

           Route::controller(AdminRegisterUserController::class)
                ->prefix("/user-manage/register-users")
                ->name("users.register.")
                ->group(function () {
                    Route::get("/", "index")->middleware('permission:user-manage.menu')->name("index");
                    Route::get("/details/{user}", "show")->middleware('permission:user-manage.detail')->name("show");
                    Route::delete("/{user}", "destroy")->middleware('permission:user-manage.delete')->name("destroy");
                    Route::get("/trash", "trash")->middleware('permission:user-manage.trash.list')->name("trash");
                    Route::post("/{id}/restore", "restore")->middleware('permission:user-manage.trash.restore')->name("restore");
                    Route::delete("/{id}/force-delete", "forceDelete")->middleware('permission:user-manage.trash.delete')->name("forceDelete");
                    Route::get("/permanently-delete", "permanentlyDelete")->middleware('permission:user-manage.trash.delete')->name("permanentlyDelete");
                });

           Route::controller(AdminRegisterVendorController::class)
                ->prefix("/user-manage/register-vendors")
                ->name("vendors.register.")
                ->group(function () {
                    Route::get("/", "index")->middleware('permission:user-manage.menu')->name("index");
                    Route::get("/details/{user}", "show")->middleware('permission:user-manage.detail')->name("show");
                    Route::delete("/{user}", "destroy")->middleware('permission:user-manage.delete')->name("destroy");
                    Route::get("/trash", "trash")->middleware('permission:user-manage.trash.list')->name("trash");
                    Route::post("/{id}/restore", "restore")->middleware('permission:user-manage.trash.restore')->name("restore");
                    Route::delete("/{id}/force-delete", "forceDelete")->middleware('permission:user-manage.trash.delete')->name("forceDelete");
                    Route::get("/permanently-delete", "permanentlyDelete")->middleware('permission:user-manage.trash.delete')->name("permanentlyDelete");
                });

           Route::controller(AdminManageController::class)
                ->prefix("/admin-manage")
                ->name("admin-manage.")
                ->group(function () {
                    Route::get("/", "index")->middleware('permission:admin-manage.menu')->name("index");
                    Route::get("/details/{user}", "show")->middleware('permission:admin-manage.detail')->name("show");
                    Route::get("/create", "create")->middleware('permission:admin-manage.add')->name("create");
                    Route::post("/", "store")->middleware('permission:admin-manage.add')->name("store");
                    Route::get("/{user}/edit", "edit")->middleware('permission:admin-manage.edit')->name("edit");
                    Route::post("/{user}", "update")->middleware('permission:admin-manage.edit')->name("update");
                    Route::delete("/{user}", "destroy")->middleware('permission:admin-manage.delete')->name("destroy");
                    Route::get("/trash", "trash")->middleware('permission:admin-manage.trash.list')->name("trash");
                    Route::post("/{id}/restore", "restore")->middleware('permission:admin-manage.trash.restore')->name("restore");
                    Route::delete("/{id}/force-delete", "forceDelete")->middleware('permission:admin-manage.trash.delete')->name("forceDelete");
                    Route::get("/permanently-delete", "permanentlyDelete")->middleware('permission:admin-manage.trash.delete')->name("permanentlyDelete");
                });

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
                    Route::delete("/{id}/force-delete", "forceDelete")->middleware('permission:role-and-permission.trash.delete')->name("forceDelete");
                    Route::get("/permanently-delete", "permanentlyDelete")->middleware('permission:role-and-permission.trash.delete')->name("permanentlyDelete");
                });

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
                    Route::delete("/{id}/force-delete", "forceDelete")->middleware('permission:role-and-permission.trash.delete')->name("forceDelete");
                    Route::get("/permanently-delete", "permanentlyDelete")->middleware('permission:role-and-permission.trash.delete')->name("permanentlyDelete");
                });

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
                    Route::post("/{id}/restore", "restore")->middleware('permission:blog-category.trash.restore')->name("restore");
                    Route::delete("/{id}/force-delete", "forceDelete")->middleware('permission:blog-category.trash.delete')->name("forceDelete");
                    Route::get("/permanently-delete", "permanentlyDelete")->middleware('permission:blog-category.trash.delete')->name("permanentlyDelete");
                });

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
                    Route::post("/{id}/restore", "restore")->middleware('permission:blog-post.trash.restore')->name("restore");
                    Route::delete("/{id}/force-delete", "forceDelete")->middleware('permission:blog-post.trash.delete')->name("forceDelete");
                    Route::get("/permanently-delete", "permanentlyDelete")->middleware('permission:blog-post.trash.delete')->name("permanentlyDelete");
                });

           Route::controller(AdminWebsiteSettingController::class)
                ->prefix("/website-settings")
                ->name("website-settings.")
                ->group(function () {
                    Route::get("/", "edit")->middleware('permission:website-setting.menu')->name("edit");
                    Route::post("/{website_setting}", "update")->middleware('permission:website-setting.edit')->name("update");
                });

           Route::controller(AdminSeoSettingController::class)
                ->prefix("/seo-settings")
                ->name("seo-settings.")
                ->group(function () {
                    Route::get("/", "edit")->middleware('permission:seo-setting.menu')->name("edit");
                    Route::post("/{seo_setting}", "update")->middleware('permission:seo-setting.edit')->name("update");
                });






           // Admin Dashboard Subscriber Section
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

           // Admin Dashboard Suggestion Section
           Route::controller(AdminSuggestionController::class)
           ->prefix("/suggestions")
           ->name("suggestions.")
           ->group(function () {
               Route::get("/", "index")->middleware('permission:suggestion.menu')->name("index");
               Route::get("/details/{suggestion}", "show")->middleware('permission:suggestion.detail')->name("show");
               Route::delete("/{suggestion}", "destroy")->middleware('permission:suggestion.delete')->name("destroy");
               Route::get("/trash", "trash")->middleware('permission:suggestion.trash.list')->name("trash");
               Route::post("/{suggestion}/restore", "restore")->middleware('permission:suggestion.trash.restore')->name("restore");
               Route::delete("/{suggestion}/force-delete", "forceDelete")->middleware('permission:suggestion.trash.delete')->name("force.delete");
               Route::get("/permanently-delete", "permanentlyDelete")->middleware('permission:suggestion.trash.delete')->name("permanently.delete");
           });

           // Admin Dashboard Website Feedback Section
           Route::controller(AdminWebsiteFeedbackController::class)
           ->prefix("/website-feedbacks")
           ->name("website-feedbacks.")
           ->group(function () {
               Route::get("/", "index")->middleware('permission:website-feedback.menu')->name("index");
               Route::get("/details/{website_feedback}", "show")->middleware('permission:website-feedback.detail')->name("show");
               Route::delete("/{website_feedback}", "destroy")->middleware('permission:website-feedback.delete')->name("destroy");
               Route::get("/trash", "trash")->middleware('permission:website-feedback.trash.list')->name("trash");
               Route::post("/{website_feedback}/restore", "restore")->middleware('permission:website-feedback.trash.restore')->name("restore");
               Route::delete("/{website_feedback}/force-delete", "forceDelete")->middleware('permission:website-feedback.trash.delete')->name("force.delete");
               Route::get("/permanently-delete", "permanentlyDelete")->middleware('permission:website-feedback.trash.delete')->name("permanently.delete");
           });
       });
