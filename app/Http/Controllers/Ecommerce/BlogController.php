<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\BlogTag;
use Inertia\Response;
use Inertia\ResponseFactory;

class BlogController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        $blogCategories=BlogCategory::withCount("blogPosts")->where("status", "show")->get();

        $blogPosts=BlogPost::with(["author:id,name","blogCategory:id,name"])
                           ->filterBy(request(["search_blog","blog_category"]))
                           ->orderBy(request("sort", "id"), request("direction", "desc"))
                           ->paginate(20)
                           ->withQueryString();

        return inertia("Ecommerce/Blogs/Index", compact("blogCategories", "blogPosts"));
    }

    public function tagBlog(string $blogTagSlug): Response|ResponseFactory
    {
        $blogCategories=BlogCategory::withCount("blogPosts")->where("status", "show")->get();

        $blogTag=BlogTag::where("slug", $blogTagSlug)->first();

        if($blogTag) {
            $blogPosts=$blogTag->blogPosts()->with(["author:id,name","blogCategory:id,name"])
                               ->filterBy(request(["search_blog"]))
                               ->orderBy(request("sort", "id"), request("direction", "desc"))
                               ->paginate(20)
                               ->withQueryString();
            return inertia("Ecommerce/Blogs/TagBlogs", compact("blogCategories", "blogTag", "blogPosts"));
        }

        return inertia("Ecommerce/Blogs/TagBlogs", compact("blogCategories", "blogTag"));
    }

    public function show(BlogPost $blogPost): Response|ResponseFactory
    {
        $blogCategories=BlogCategory::withCount("blogPosts")->where("status", "show")->get();

        $blogPost->load(["author:id,name","blogCategory:id,name","blogTags:id,name,slug"]);

        $relatedBlogPosts=BlogPost::with(["author:id,name","blogCategory:id,name"])
                                  ->where("blog_category_id", $blogPost->blog_category_id)
                                  ->where("slug", "!=", $blogPost->slug)
                                  ->limit(10)
                                  ->get();

        return inertia("Ecommerce/Blogs/Details", compact('blogPost', 'blogCategories', 'relatedBlogPosts'));
    }
}
