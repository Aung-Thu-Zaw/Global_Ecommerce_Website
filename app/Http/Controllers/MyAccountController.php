<?php

namespace App\Http\Controllers;

use Laravolt\Avatar\Avatar;
use App\Http\Requests\MyAccountUpdateRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class MyAccountController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): Response
    {
        return Inertia::render('MyAccount/Edit', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(MyAccountUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }



        if ($request->user()->isDirty('name')) {
            $userId=$request->user()->id;


            if (empty($request->user()->avatar) && file_exists(storage_path("app/public/avatars/default-avatar-$userId.png"))) {
                unlink(storage_path("app/public/avatars/default-avatar-$userId.png"));
            }


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
            $avatar->create($request->name)->setBackground($colors[$randomColor])->setBorder(0, "background")->save(storage_path("app/public/avatars/default-avatar-$userId.png"));
        }



        if ($request->hasFile("avatar")) {
            $user=$request->user();

            if (file_exists(storage_path("app/public/avatars/default-avatar-$user->id.png"))) {
                unlink(storage_path("app/public/avatars/default-avatar-$user->id.png"));
            }

            if (!empty($request->user()->avatar) && file_exists(storage_path("app/public/avatars/$user->avatar"))) {
                unlink(storage_path("app/public/avatars/$user->avatar"));
            }

            $extension=$request->file("avatar")->extension();

            $finalName="avatar-$user->id.$extension";

            $request->file("avatar")->move(storage_path("app/public/avatars/"), $finalName);


            $request->user()->avatar=$finalName;
        }

        $request->user()->save();

        return Redirect::route('my-account.edit');
    }


    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        if (auth()->user() && !auth()->user()->google_id && !auth()->user()->facebook_id) {
            $request->validate([
                'password' => ['required', 'current-password'],
            ]);
        }

        $user = $request->user();

        Auth::logout();

        if (file_exists(storage_path("app/public/avatars/default-avatar-$user->id.png"))) {
            unlink(storage_path("app/public/avatars/default-avatar-$user->id.png"));
        }

        if (!empty($user->avatar) && file_exists(storage_path("app/public/avatars/$user->avatar"))) {
            unlink(storage_path("app/public/avatars/$user->avatar"));
        }

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
