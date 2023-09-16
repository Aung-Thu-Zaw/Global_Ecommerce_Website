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

        $filteredTags = array_unique(array_map('strtolower', $tags));

        $attachedTagIds = $blogPost->blogTags()->pluck('id')->toArray();

        foreach ($filteredTags as $tag) {
            $existedTag = BlogTag::where("name", $tag)->first();

            if (!$existedTag) {
                $tagModel = BlogTag::create(["name" => $tag]);

                $blogPost->blogTags()->attach($tagModel);
            } elseif (!in_array($existedTag->id, $attachedTagIds)) {
                $blogPost->blogTags()->attach($existedTag);
            }
        }
    }
}
