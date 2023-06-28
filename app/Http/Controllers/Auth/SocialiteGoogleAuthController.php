<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Jobs\AccountRegistered\SendNewUserRegisteredWithSocialiteEmailNotificationForAdmin;
use App\Jobs\AccountRegistered\SendNewUserRegisteredWithSocialiteNotificationForAdminDashboard;
use App\Jobs\AccountRegistered\SendWelcomeEmailToRegisteredWithSocialiteAccount;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\InvalidStateException;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Illuminate\Support\Str;

class SocialiteGoogleAuthController extends Controller
{
    public function redirectToProvider(): RedirectResponse
    {
        return Socialite::driver("google")->redirect();
    }

    public function handelProviderCallback(): RedirectResponse
    {
        try {
            $googleUser= Socialite::driver("google")->user();
        } catch(InvalidStateException $e) {
            return redirect()->back()->with("status", "Something Went Wrong!");
        }

        $existingUser=User::where("google_id", $googleUser->getId())->first();

        if (!$existingUser) {
            $newUser=User::create([
                'uuid'=>Str::uuid(),
                "google_id"=>$googleUser->getId(),
                "name"=>$googleUser->getName(),
                "email"=>$googleUser->getEmail(),
                "avatar"=>$googleUser->getAvatar(),
                "email_verified_at"=>now(),
                'offical'=>false,
            ]);

            SendNewUserRegisteredWithSocialiteNotificationForAdminDashboard::dispatch($newUser);

            SendNewUserRegisteredWithSocialiteEmailNotificationForAdmin::dispatch($newUser);

            SendWelcomeEmailToRegisteredWithSocialiteAccount::dispatch($newUser);

            Auth::login($newUser);
        } else {
            Auth::login($existingUser);
        }

        return to_route('home');
    }
}
