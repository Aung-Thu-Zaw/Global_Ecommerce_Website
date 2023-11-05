<?php

namespace App\Services\BroadcastNotifications;

use App\Models\LiveChat;
use App\Models\User;
use App\Notifications\Chats\NewLiveChatAssignementFromUserNotification;
use Illuminate\Support\Facades\Notification;

class NewLiveChatAssignmentNotificationSendToAdminDashboardService
{
    public function send(LiveChat $liveChat): void
    {
        $admins = User::where('role', 'admin')->get();

        $user = User::findOrFail($liveChat->user_id);

        Notification::send($admins, new NewLiveChatAssignementFromUserNotification($user));
    }
}
