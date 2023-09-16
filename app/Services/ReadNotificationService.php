<?php

namespace App\Services;

use App\Models\User;

class ReadNotificationService
{
    public function read(int $notifiableId, string $notificationId): void
    {
        $user = User::findOrFail($notifiableId);

        $notification = $user->notifications()->findOrFail($notificationId);

        $notification->update(['read_at' => now()]);
    }

    /**
     * @param array<mixed> $notifications
     */
    public function readAll(array $notifications): void
    {
        foreach($notifications as $notification) {

            $user = User::findOrFail($notification["notifiable_id"]);

            $notification = $user->notifications()->findOrFail($notification["id"]);

            $notification->update(['read_at' => now()]);
        }
    }
}
