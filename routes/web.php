<?php

use App\Http\Controllers\Ecommerce\CollectionController;
use App\Http\Controllers\Ecommerce\HomeController;
use App\Http\Controllers\Ecommerce\ProductController;
use App\Http\Controllers\MyAccountController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [HomeController::class,"index"])->name("home");
Route::get('/products/{product}', [ProductController::class,"show"])->name("products.show");
Route::get('/collections', [CollectionController::class,"index"])->name("collections.index");
Route::get('/collections/{collection}/products', [CollectionController::class,"show"])->name("collections.show");


Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth'])->name('user.dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/my-account', [MyAccountController::class, 'edit'])->name('my-account.edit');
    Route::post('/my-account', [MyAccountController::class, 'update'])->name('my-account.update');
    Route::delete('/my-account', [MyAccountController::class, 'destroy'])->name('my-account.destroy');
});




require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
require __DIR__.'/vendor.php';
