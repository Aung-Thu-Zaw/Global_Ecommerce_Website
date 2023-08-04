<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use App\Models\BlogPost;
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

    public function show(BlogPost $blogPost): Response|ResponseFactory
    {
        $blogCategories=BlogCategory::withCount("blogPosts")->where("status", "show")->get();

        $blogPost->load(["author:id,name","blogCategory:id,name","blogTags:id,name,slug"]);

        return inertia("Ecommerce/Blogs/Details", compact('blogPost', 'blogCategories'));
    }
}
