<?php

namespace App\Notifications\AccountRegistered;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RegisteredUserEmailNotification extends Notification
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
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage())
        ->subject("New User Registered")
        ->greeting("Dear ".$notifiable->name.",")
        ->line("A new user has registered on our platform. Please review the details below:")
        ->line("Name: ".$this->user->name)
        ->line("Email: ".$this->user->email)
        ->line("Registration Date: ".Carbon::parse($this->user->created_at)->format("Y-m-d"))
        ->action('See More Details', route('admin.registered-accounts.show', $this->user->id));

    }

}
