<?php

namespace App\Http\Controllers\Auth;

use App\Events\RegisteredWithSocialite;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\InvalidStateException;
use Symfony\Component\HttpFoundation\RedirectResponse;

class SocialiteFacebookAuthController extends Controller
{
    public function redirectToProvider(): RedirectResponse
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handelProviderCallback(): RedirectResponse
    {
        try {
            $facebookUser = Socialite::driver('facebook')->user();
        } catch(InvalidStateException $e) {
            return redirect()->back()->with('status', 'Something Went Wrong!');
        }

        $existingUser = User::where('facebook_id', $facebookUser->getId())->first();

        if (! $existingUser) {
            $newUser = User::create([
                'uuid' => Str::uuid(),
                'facebook_id' => $facebookUser->getId(),
                'name' => $facebookUser->getName(),
                'email' => $facebookUser->getEmail(),
                'avatar' => $facebookUser->getAvatar(),
                'role' => 'user',
                'email_verified_at' => now(),
                'offical' => false,
            ]);

            event(new RegisteredWithSocialite($newUser));

            Auth::login($newUser);
        } else {
            Auth::login($existingUser);
        }

        return to_route('home');
    }
}
