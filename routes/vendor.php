<?php

use App\Http\Controllers\Vendor\VendorAuthController;
use App\Http\Controllers\Vendor\VendorDashboardController;
use Illuminate\Support\Facades\Route;

Route::get("vendor/register", [VendorAuthController::class,"register"])->name("vendor.register");
Route::get("vendor/login", [VendorAuthController::class,"login"])->name("vendor.login");

Route::middleware(["auth","user.role:vendor"])
        ->prefix("vendor")
        ->name("vendor.")->group(function () {
            Route::get("/dashboard", [VendorDashboardController::class,"index"])->name("dashboard");
        });
