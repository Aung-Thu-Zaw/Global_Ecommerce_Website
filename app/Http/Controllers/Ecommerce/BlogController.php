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
        $blogCategories=BlogCategory::with("blogPosts")->where("status", "show")->get();


        $blogPosts=BlogPost::with("author:id,name")
                           ->filterBy(request(["search_blog","blog_category"]))
                           ->orderBy(request("sort", "id"), request("direction", "desc"))
                           ->paginate(20)
                           ->appends(request()->all());


        return inertia("Ecommerce/Blogs/Index", compact("blogCategories", "blogPosts"));
    }
}
