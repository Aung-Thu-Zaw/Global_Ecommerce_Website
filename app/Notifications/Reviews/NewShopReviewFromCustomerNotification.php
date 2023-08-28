<?php

namespace App\Notifications\Reviews;

use App\Models\ShopReview;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewShopReviewFromCustomerNotification extends Notification implements ShouldBroadcast
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(protected ShopReview $shopReview)
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
            "message" => "RECEIVED_A_NEW_SHOP_REVIEW_FROM_A_CUSTOMER",
            "review" => $this->shopReview,

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
            "message" => "RECEIVED_A_NEW_SHOP_REVIEW_FROM_A_CUSTOMER",
            "review" => $this->shopReview,
        ]);
    }
}
