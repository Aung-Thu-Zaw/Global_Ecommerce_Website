<?php

namespace App\Notifications\Reviews;

use App\Models\Product;
use App\Models\Reply;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class ProductReviewReplyFromSellerNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(protected Reply $reply, protected Product $product)
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
            'message' => 'YOUR_PRODUCT_REVIEW_HAS_BEEN_REPLIED_TO_BY_THE_SELLER',
            'reply' => $this->reply->reply_text,
            'slug' => $this->product->slug,
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
            'message' => 'YOUR_PRODUCT_REVIEW_HAS_BEEN_REPLIED_TO_BY_THE_SELLER',
            'reply' => $this->reply->reply_text,
            'slug' => $this->product->slug,
        ]);
    }
}
