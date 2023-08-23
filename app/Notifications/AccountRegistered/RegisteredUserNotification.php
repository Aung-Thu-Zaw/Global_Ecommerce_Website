<?php

namespace App\Notifications\AccountRegistered;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class RegisteredUserNotification extends Notification implements ShouldBroadcast
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
            "message" => $this->user->role === 'seller' ? "NEW_SELLER_REGISTERED" : "NEW_USER_REGISTERED",
            "user" => $this->user
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
            "message" => $this->user->role === 'seller' ? "NEW_SELLER_REGISTERED" : "NEW_USER_REGISTERED",
            "user" => $this->user
        ]);
    }
}
