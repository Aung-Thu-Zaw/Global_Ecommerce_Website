<?php

namespace App\Notifications\Chats;

use App\Models\LiveChat;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewLiveChatAssignementFromUserNotification extends Notification implements ShouldBroadcast
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(protected User $user)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array<string>
     */
    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    /**
    * Get the array representation of the notification.
    *
    * @param  mixed  $notifiable
    * @return array<string|int>
    */
    public function toArray($notifiable)
    {
        return [
            "message" => "YOU_GET_A_NEW_LIVE_CHAT_ASSIGNMENT_FROM_THE_USER",
            "name" => $this->user->name,
        ];
    }


    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return BroadcastMessage
     */
    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            "message" => "YOU_GET_A_NEW_LIVE_CHAT_ASSIGNMENT_FROM_THE_USER",
            "name" => $this->user->name,
        ]);
    }
}
