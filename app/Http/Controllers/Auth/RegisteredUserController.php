<?php

namespace App\Http\Controllers\Auth;

use App\Actions\CreateUserAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use App\Notifications\RegisteredUserNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Notification;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(RegisterRequest $request): RedirectResponse
    {
        $user=(new CreateUserAction())->execute($request->validated()+["role"=>$request->role?? "user","status"=>$request->status?? "active"]);

        event(new Registered($user));

        Auth::login($user);

        return to_route(User::find(auth()->id())->getRedirectRouteName())->with("success", "Account is created successfully");
    }
}
