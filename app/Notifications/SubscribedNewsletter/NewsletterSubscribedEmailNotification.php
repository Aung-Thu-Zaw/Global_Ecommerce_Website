<?php

namespace App\Notifications\SubscribedNewsletter;

use App\Models\Subscriber;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewsletterSubscribedEmailNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(protected Subscriber $subscriber)
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
        ->subject("New Newsletter Subscription")
        ->greeting("Dear ".$notifiable->name.",")
        ->line("A new subscriber has subscribed to the website newsletter. Here are the details:")
        ->line("Subscriber Email: ".$this->subscriber->email)
        ->line("Subscribe Date: ".Carbon::parse($this->subscriber->created_at)->format("Y-m-d"));
    }
}
