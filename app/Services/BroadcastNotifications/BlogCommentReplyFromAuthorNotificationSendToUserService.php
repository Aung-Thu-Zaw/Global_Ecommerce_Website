<?php

namespace App\Services\BroadcastNotifications;

use App\Models\BlogComment;
use App\Models\BlogCommentReply;
use App\Models\BlogPost;
use App\Models\User;
use App\Notifications\Blogs\BlogCommentReplyFromAuthorNotification;

class BlogCommentReplyFromAuthorNotificationSendToUserService
{
    public function send(BlogCommentReply $blogCommentReply): void
    {
        $blogComment = BlogComment::findOrFail($blogCommentReply->blog_comment_id);

        $blogPost = BlogPost::findOrFail($blogComment->blog_post_id);

        $user = User::findOrFail($blogComment->user_id);

        $user->notify(new BlogCommentReplyFromAuthorNotification($blogPost, $blogCommentReply));
    }
}
