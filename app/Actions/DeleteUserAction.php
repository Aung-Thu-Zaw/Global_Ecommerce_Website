<?php

namespace App\Actions;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeleteUserAction
{
    public function execute(Request $request)
    {
        if (auth()->user() && !auth()->user()->google_id && !auth()->user()->facebook_id) {
            $request->validate([
                'password' => ['required', 'current-password'],
            ]);
        }

        $user = $request->user();

        User::deleteDefaultAvatar($user);

        User::deleteUserAvatar($user);

        Auth::logout();

        $user->forceDelete();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return null;
    }
}
