<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use Inertia\Response;
use Inertia\ResponseFactory;

class VendorAuthController extends Controller
{
    public function register(): Response|ResponseFactory
    {
        return inertia('Vendor/Auth/Register');
    }


    public function login(): Response|ResponseFactory
    {
        return inertia('Vendor/Auth/Login', [
            'canResetPassword' => Route::has("password.request"),
            'status' => session('status'),
        ]);
    }
}
