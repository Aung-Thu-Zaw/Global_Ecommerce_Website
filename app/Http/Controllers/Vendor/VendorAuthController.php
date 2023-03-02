<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use Inertia\Response;

class VendorAuthController extends Controller
{
    public function create(): Response
    {
        return inertia('Vendor/Auth/Login', [
            'canResetPassword' => Route::has("password.request"),
            'status' => session('status'),
        ]);
    }
}
