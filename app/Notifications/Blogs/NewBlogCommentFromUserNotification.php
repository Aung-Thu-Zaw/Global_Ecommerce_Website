<?php

namespace App\Notifications\Blogs;

use App\Models\BlogComment;
use App\Models\BlogPost;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class NewBlogCommentFromUserNotification extends Notification implements ShouldBroadcast
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(protected BlogPost $blogPost, protected BlogComment $blogComment)
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
            'message' => 'YOUR_BLOG_RECEIVED_A_NEW_COMMENT_FROM_A_USER',
            'blog' => $this->blogPost->slug,
            'comment' => $this->blogComment->comment,

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
            'message' => 'YOUR_BLOG_RECEIVED_A_NEW_COMMENT_FROM_A_USER',
            'blog' => $this->blogPost->slug,
            'comment' => $this->blogComment->comment,
        ]);
    }
}
