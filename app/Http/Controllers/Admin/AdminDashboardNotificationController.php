<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Services\ReadNotificationService;

class AdminDashboardNotificationController extends Controller
{
    public function reatNotification(Request $request, string $notificationId): RedirectResponse
    {
        (new ReadNotificationService())->read($request->notifiable_id, $notificationId);

        return back();
    }

    public function markAllAsRead(Request $request): RedirectResponse
    {
        $request->validate([
            "notifications" => ["required", "array"]
        ]);

        (new ReadNotificationService())->readAll($request->notifications);

        return back();
    }
}
