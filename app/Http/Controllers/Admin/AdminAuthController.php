<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use Inertia\Response;
use Inertia\ResponseFactory;

class AdminAuthController extends Controller
{
    public function login(): Response|ResponseFactory
    {
        return inertia('Admin/Auth/Login', [
            'canResetPassword' => Route::has("password.request"),
            'status' => session('status'),
        ]);
    }
}
