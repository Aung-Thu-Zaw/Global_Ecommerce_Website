<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class SocialiteFacebookAuthController extends Controller
{
    public function redirectToProvider(): RedirectResponse
    {
        return Socialite::driver("facebook")->redirect();
    }

    public function handelProviderCallback(): RedirectResponse
    {
        try {
            $facebookUser= Socialite::driver("facebook")->stateless()->user();
        } catch(Exception $err) {
            return redirect()->back()->with("status", "Something Went Wrong!");
        }

        $existingUser=User::where("facebook_id", $facebookUser->id)->first();

        if (!$existingUser) {
            $newUser=User::create([
                "facebook_id"=>$facebookUser->id,
                "name"=>$facebookUser->name,
                "email"=>$facebookUser->email,
                "avatar"=>$facebookUser->avatar,
                "email_verified_at"=>now()
            ]);
            Auth::login($newUser);
        } else {
            Auth::login($existingUser);
        }

        return to_route('user.dashboard');
    }
}
