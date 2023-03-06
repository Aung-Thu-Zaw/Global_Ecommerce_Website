<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Rules\RecaptchaRule;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;
use Laravolt\Avatar\Avatar;

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
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'company_name'=>['nullable'],
            'shop_name'=>['nullable'],
            'email' => 'required|string|email|max:255|unique:'.User::class,
            'phone'=>['nullable','numeric'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'gender'=>["nullable",Rule::in(['male','female','other'])],
            'birthday'=>["nullable","date"],
            'role'=>["required",Rule::in(["admin","vendor","user"])],
            'status'=>["required",Rule::in(["active","inactive"])],
            'captcha_token'  => ['required',new RecaptchaRule()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'company_name' => $request->company_name,
            'shop_name' => $request->shop_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'gender'=>$request->gender,
            'birthday'=>$request->birthday,
            'role'=>$request->role,
            'status'=>$request->status
        ]);

        $colors=[
        "#f44336",
        "#E91E63",
        "#9C27B0",
        "#673AB7",
        "#3F51B5",
        "#2196F3",
        "#03A9F4",
        "#00BCD4",
        "#009688",
        "#4CAF50",
        "#8BC34A",
        "#CDDC39",
        "#FFC107",
        "#FF9800",
        "#FF5722",
    ];

        $randomColor=array_rand($colors, 1);

        $avatar=new Avatar();

        $avatar->create($request->name)->setBackground($colors[$randomColor])->setBorder(0, "background")->save(storage_path("app/public/avatars/default-avatar-$user->id.png"));

        event(new Registered($user));

        Auth::login($user);

        return to_route(User::find(auth()->id())->getRedirectRouteName());

        // return redirect(RouteServiceProvider::HOME)->with("user-create", "<strong>Account is created successfully.</strong> Check your email box, Please verify your email.");
    }
}
