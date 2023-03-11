<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\Managements\AdminActiveVendorController;
use App\Http\Controllers\Admin\Managements\AdminInactiveVendorController;
use App\Http\Controllers\Auth\SocialiteFacebookAuthController;
use App\Http\Controllers\Auth\SocialiteGoogleAuthController;
use App\Http\Controllers\MyAccountController;
use App\Http\Controllers\Vendor\VendorAuthController;
use App\Http\Controllers\Vendor\VendorDashboardController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::prefix("/auth/redirect")
        ->name("redirect.")
        ->group(function () {
            Route::get('/facebook', [SocialiteFacebookAuthController::class,"redirectToProvider"])->name("facebook");
            Route::get('/google', [SocialiteGoogleAuthController::class,"redirectToProvider"])->name("google");
        });

Route::prefix("/auth/callback")
        ->group(function () {
            Route::get('/facebook', [SocialiteFacebookAuthController::class,"handelProviderCallback"]);
            Route::get('/google', [SocialiteGoogleAuthController::class,"handelProviderCallback"]);
        });

Route::get('/', function () {
    return Inertia::render('Ecommerce/Home/Index', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name("home");

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth'])->name('user.dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/my-account', [MyAccountController::class, 'edit'])->name('my-account.edit');
    Route::post('/my-account', [MyAccountController::class, 'update'])->name('my-account.update');
    Route::delete('/my-account', [MyAccountController::class, 'destroy'])->name('my-account.destroy');
});

require __DIR__.'/auth.php';


Route::get("admin/login", [AdminAuthController::class,"login"])->name("admin.login");

Route::get("vendor/register", [VendorAuthController::class,"register"])->name("vendor.register");
Route::get("vendor/login", [VendorAuthController::class,"login"])->name("vendor.login");


Route::middleware(["auth","user.role:admin"])->name("admin.")->group(function () {
    Route::get("/admin/dashboard", [AdminDashboardController::class,"index"])->name("dashboard");

    Route::get("/admin/managements/inactive-vendors", [AdminInactiveVendorController::class,"index"])->name("vendors.inactive.index");
    Route::post("/admin/managements/inactive-vendors/{id}/soft-delete", [AdminInactiveVendorController::class,"softDelete"])->name("vendors.inactive.softDelete");
    Route::post("/admin/managements/inactive-vendors/{id}/restore", [AdminInactiveVendorController::class,"restore"])->name("vendors.inactive.restore");
    Route::delete("/admin/managements/inactive-vendors/{id}/force-delete", [AdminInactiveVendorController::class,"forceDelete"])->name("vendors.inactive.forceDelete");
    Route::get("/admin/managements/inactive-vendors/trash", [AdminInactiveVendorController::class,"trash"])->name("vendors.inactive.trash");
    Route::post("/admin/managements/inactive-vendors/{id}/active", [AdminInactiveVendorController::class,"update"])->name("vendors.inactive.update");
    Route::get("admin/managements/inactive-vendors/details/{id}", [AdminInactiveVendorController::class,"show"])->name("vendors.inactive.details");

    Route::get("/admin/managements/active-vendors", [AdminActiveVendorController::class,"index"])->name("vendors.active.index");
    Route::post("/admin/managements/active-vendors/{id}/inactive", [AdminActiveVendorController::class,"update"])->name("vendors.active.update");
    Route::get("admin/managements/active-vendors/details/{id}", [AdminActiveVendorController::class,"show"])->name("vendors.active.details");

    Route::get("/admin/categories", [AdminCategoryController::class,"index"])->name("categories.index");
    Route::get("/admin/categories/create", [AdminCategoryController::class,"create"])->name("categories.create");
    Route::get("/admin/categories/{category}/edit", [AdminCategoryController::class,"edit"])->name("categories.edit");
    Route::post("/admin/categories", [AdminCategoryController::class,"store"])->name("categories.store");
    Route::post("/admin/categories/{category}", [AdminCategoryController::class,"update"])->name("categories.update");
    Route::get("/admin/categories/trash", [AdminCategoryController::class,"trash"])->name("categories.trash");
});



Route::middleware(["auth","user.role:vendor"])->group(function () {
    Route::get("/vendor/dashboard", [VendorDashboardController::class,"index"])->name("vendor.dashboard");
});
