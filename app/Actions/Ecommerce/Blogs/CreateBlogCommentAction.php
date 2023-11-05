<?php

namespace App\Actions\Ecommerce\Blogs;

use App\Models\BlogComment;

class CreateBlogCommentAction
{
    /**
     * @param  array<mixed>  $data
     */
    public function handle(array $data): BlogComment
    {
        $blogComment = BlogComment::create([
            'blog_post_id' => $data['blog_post_id'],
            'user_id' => $data['user_id'],
            'comment' => $data['comment'],
        ]);

        return $blogComment;
    }
}
