<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use Inertia\Response;
use Inertia\ResponseFactory;

class SellerAuthController extends Controller
{
    public function register(): Response|ResponseFactory
    {
        return inertia('Seller/Auth/Register');
    }

    public function login(): Response|ResponseFactory
    {
        return inertia('Seller/Auth/Login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => session('status'),
        ]);
    }
}
