<?php

namespace App\Actions\Ecommerce\Blogs;

use App\Models\BlogCommentReply;

class CreateBlogCommentReplyAction
{
    /**
     * @param array<mixed> $data
     */
    public function handle(array $data): BlogCommentReply
    {
        $blogCommentReply = BlogCommentReply::create([
            "blog_comment_id" => $data["blog_comment_id"],
            "author_id" => $data["author_id"],
            "reply_text" => $data["reply_text"],
        ]);

        return $blogCommentReply;
    }
}
