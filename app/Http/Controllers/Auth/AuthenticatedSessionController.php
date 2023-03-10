<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => session('status'),
        ]);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $gender=auth()->user()->gender==="male" || auth()->user()->gender === "other" ? "Mr." : "Mrs.";

        return to_route(User::find(auth()->id())->getRedirectRouteName())->with("success", "Welcome Back $gender".auth()->user()->name." 😍");
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $userId=auth()->user()->id;

        $name=auth()->user()->name;

        $gender=auth()->user()->gender==="male" || auth()->user()->gender === "other" ? "Mr." : "Mrs.";

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return to_route(User::find($userId)->logoutRedirect())->with("success", "See you later $gender$name 🤗");
    }
}
