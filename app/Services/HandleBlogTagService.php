<?php

namespace App\Services;

use App\Models\BlogPost;
use App\Models\BlogTag;

class HandleBlogTagService
{
    /**
     * @param array<string> $tags
     */

    public function handle(array $tags, BlogPost $blogPost): void
    {
        $blogPost->blogTags()->detach();

        foreach ($tags as $tag) {
            $countExisitngTags=BlogTag::where("name", $tag)->count();

            $exisitngTags=BlogTag::where("name", $tag)->get();

            if (!$countExisitngTags) {
                $BlogTagModel=new BlogTag();
                $BlogTagModel->name=$tag;
                $BlogTagModel->save();
                $blogPost->blogTags()->attach($BlogTagModel);
            }

            if ($countExisitngTags) {
                foreach ($exisitngTags as $exisitngTag) {
                    $blogPost->blogTags()->attach($exisitngTag);
                }
            }
        }
    }
}
