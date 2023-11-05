<?php

namespace App\Notifications\Products;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class AdminApprovedCreatedNewProductNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(protected Product $product)
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
            'message' => 'AN_ADMINSITRATOR_HAS_APPROVED_YOUR_PRODUCT',
            'product' => $this->product,
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
            'message' => 'AN_ADMINSITRATOR_HAS_APPROVED_YOUR_PRODUCT',
            'product' => $this->product,
        ]);
    }
}
