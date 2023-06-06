<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use Illuminate\Database\Eloquent\Builder;
use Inertia\Response;
use Inertia\ResponseFactory;

class BlogController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        $blogCategories=BlogCategory::with("blogPosts")->where("status", "show")->get();

        $blogPosts=BlogPost::search(request("search_blog"))
                           ->query(function (Builder $builder) {
                               $builder->with("author:id,name");
                           })
                           ->orderBy(request("sort", "id"), request("direction", "desc"))
                           ->paginate(20)
                           ->appends(request()->all());
        ;

        return inertia("Ecommerce/Blogs/Index", compact("blogCategories", "blogPosts"));
    }
}
