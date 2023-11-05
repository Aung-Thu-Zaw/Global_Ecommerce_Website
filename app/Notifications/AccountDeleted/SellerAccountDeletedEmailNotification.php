<?php

namespace App\Notifications\AccountDeleted;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SellerAccountDeletedEmailNotification extends Notification
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
                    ->subject('Seller Account Deleted')
                    ->greeting('Hello '.$notifiable->name.',')
                    ->line('The following seller account has been deleted:')
                    ->line('Id: '.$this->user->id)
                    ->line('Shop Name: '.$this->user->name)
                    ->line('Name: '.$this->user->name)
                    ->line('Email: '.$this->user->email)
                    ->line('Deleted Date: '.Carbon::parse($this->user->deleted_at)->format('Y-m-d'))
                    ->line('Please review the deletion and take any necessary actions.')
                    ->action('See More Details', route('admin.registered-accounts.trash', ['page' => 1, 'per_page' => 10, 'sort' => 'id', 'direction' => 'desc']));
    }
}
