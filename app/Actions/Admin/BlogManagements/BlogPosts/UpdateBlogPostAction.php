<?php

namespace App\Actions\Admin\BlogManagements\BlogPosts;

use App\Models\BlogPost;
use App\Services\BlogPostImageUploadService;

class UpdateBlogPostAction
{
    /**
     * @param array<mixed> $data
     */
    public function handle(array $data, BlogPost $blogPost): void
    {
        $image = isset($data["image"]) ? (new BlogPostImageUploadService())->updateImage($data["image"], $blogPost->image) : $blogPost->image;

        $blogPost->update([
            "blog_category_id"=>$data["blog_category_id"],
            "author_id"=>$data["author_id"],
            "title"=>$data["title"],
            "description"=>$data["description"],
            "image"=>$image
        ]);
    }
}
