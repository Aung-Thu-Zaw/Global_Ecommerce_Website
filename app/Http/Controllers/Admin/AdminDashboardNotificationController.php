<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AdminDashboardNotificationController extends Controller
{
    // public function seenOverview(int $notifiableId): RedirectResponse
    // {
    //     $user=User::findOrFail($notifiableId);

    //     $notifications=$user->notifications()->whereNull("seen_overview")->get();

    //     $notifications->each(function ($notification) {
    //         $notification->update(['seen_overview' => now()]);
    //     });

    //     return back();
    // }

    public function reatNotification(string $notificationId): RedirectResponse
    {
        $user=User::findOrFail(auth()->user()->id);

        $notification=$user->notifications()->where("id", $notificationId)->first();

        $notification->update(['read_at' => now()]);

        return back();
    }
}
