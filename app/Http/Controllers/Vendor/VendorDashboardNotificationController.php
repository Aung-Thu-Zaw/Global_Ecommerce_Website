<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;

class VendorDashboardNotificationController extends Controller
{
    public function reatNotification(string $notificationId): RedirectResponse
    {
        $user=User::findOrFail(auth()->id());

        $notification=$user->notifications()->findOrFail($notificationId);

        $notification->update(['read_at' => now()]);

        return back();
    }
}
