<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class VendorDashboardNotificationController extends Controller
{
    public function reatNotification(string $notificationId): RedirectResponse
    {
        $user=User::findOrFail(auth()->id());

        $notification=$user->notifications()->findOrFail($notificationId);

        $notification->update(['read_at' => now()]);

        return back();
    }

    public function markAllAsRead(Request $request): RedirectResponse
    {
        $request->validate([
            "notifications" => ["required", "array"]
        ]);

        $user=User::findOrFail(auth()->id());

        foreach($request->notifications as $notification) {
            $notification=$user->notifications()->findOrFail($notification["id"]);
            $notification->update(['read_at' => now()]);
        }

        return back();
    }
}
