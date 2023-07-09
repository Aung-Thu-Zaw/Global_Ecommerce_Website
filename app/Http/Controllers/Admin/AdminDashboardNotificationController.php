<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AdminDashboardNotificationController extends Controller
{
    public function reatNotification(string $notificationId): RedirectResponse
    {
        $user=User::findOrFail(auth()->user()->id);

        $notification=$user->notifications()->where("id", $notificationId)->first();

        $notification->update(['read_at' => now()]);

        return back();
    }
}
