<?php

namespace App\Actions\Admin\BlogManagements\BlogPosts;

use App\Models\BlogPost;
use Illuminate\Support\Collection;

class PermanentlyDeleteAllTrashBlogPostAction
{
    /**
    * @param Collection<int,BlogPost> $blogPosts
    */

    public function handle(Collection $blogPosts): void
    {
        $blogPosts->each(function ($blogPost) {

            BlogPost::deleteImage($blogPost->image);

            $blogPost->forceDelete();

        });
    }
}
