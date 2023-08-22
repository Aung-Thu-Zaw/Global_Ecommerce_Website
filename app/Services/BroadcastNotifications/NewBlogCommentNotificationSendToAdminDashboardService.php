<?php

namespace App\Services\BroadcastNotifications;

use App\Models\BlogComment;
use App\Models\BlogPost;
use App\Models\Product;
use App\Models\User;
use App\Notifications\Blogs\NewBlogCommentFromUserNotification;
use Illuminate\Support\Facades\Notification;

class NewBlogCommentNotificationSendToAdminDashboardService
{
    public function send(BlogComment $blogComment): void
    {
        $blogPost = BlogPost::findOrFail($blogComment->blog_post_id);

        $admins = User::where("role", "admin")->get();

        Notification::send($admins, new NewBlogCommentFromUserNotification($blogPost, $blogComment));
    }
}
