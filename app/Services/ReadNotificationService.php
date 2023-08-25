<?php

namespace App\Services;

use App\Models\User;

class ReadNotificationService
{
    public function read(string $notificationId): void
    {
        $user = User::findOrFail(auth()->id());

        $notification = $user->notifications()->findOrFail($notificationId);

        $notification->update(['read_at' => now()]);
    }

    /**
     * @param array<mixed> $notifications
     */
    public function readAll(array $notifications): void
    {
        $user = User::findOrFail(auth()->id());

        foreach($notifications as $notification) {

            $notification = $user->notifications()->findOrFail($notification["id"]);

            $notification->update(['read_at' => now()]);
        }
    }
}
