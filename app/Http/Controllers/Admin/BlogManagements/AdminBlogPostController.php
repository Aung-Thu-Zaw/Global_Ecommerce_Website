<?php

namespace App\Http\Controllers\Admin\BlogManagements;

use App\Http\Controllers\Controller;
use App\Http\Requests\BlogPostRequest;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Services\BlogPostImageUploadService;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\ResponseFactory;
use Illuminate\Http\RedirectResponse;

class AdminBlogPostController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        $blogPosts=BlogPost::search(request("search"))
                           ->orderBy(request("sort", "id"), request("direction", "desc"))
                           ->paginate(request("per_page", 10))
                           ->appends(request()->all());

        return inertia("Admin/BlogManagements/BlogPosts/Index", compact("blogPosts"));
    }

    public function create(): Response|ResponseFactory
    {
        $per_page=request("per_page");

        $blogCategories=BlogCategory::all();

        return inertia("Admin/BlogManagements/BlogPosts/Create", compact("per_page", "blogCategories"));
    }

    public function store(BlogPostRequest $request, BlogPostImageUploadService $blogPostImageUploadService): RedirectResponse
    {
        BlogPost::create($request->validated()+["image"=>$blogPostImageUploadService->createImage($request)]);

        return to_route("admin.blogs.posts.index", "per_page=$request->per_page")->with("success", "Post has been successfully created.");
    }

    public function edit(BlogPost $blogPost): Response|ResponseFactory
    {
        $queryStringParams=[ "page"=>request("page"),"per_page"=>request("per_page"),"sort"=>request("sort"),"direction"=>request("direction")];

        $blogCategories=BlogCategory::all();

        return inertia("Admin/BlogManagements/BlogPosts/Edit", compact("blogPost", "queryStringParams", "blogCategories"));
    }

    public function update(BlogPostRequest $request, BlogPost $blogPost, BlogPostImageUploadService $blogPostImageUploadService): RedirectResponse
    {
        $blogPost->update($request->validated()+["image"=>$blogPostImageUploadService->updateImage($request, $blogPost)]);

        return to_route("admin.blogs.posts.index", "page=$request->page&per_page=$request->per_page&sort=$request->sort&direction=$request->direction")
             ->with("success", "Post has been successfully updated.");
    }

    public function destroy(Request $request, BlogPost $blogPost): RedirectResponse
    {
        $blogPost->delete();

        return to_route("admin.blogs.posts.index", "page=$request->page&per_page=$request->per_page&sort=$request->sort&direction=$request->direction")
             ->with("success", "Post has been successfully deleted.");
    }

    public function trash(): Response|ResponseFactory
    {
        $trashBlogPosts=BlogPost::search(request("search"))
                                ->onlyTrashed()
                                ->orderBy(request("sort", "id"), request("direction", "desc"))
                                ->paginate(request("per_page", 10))
                                ->appends(request()->all());


        return inertia("Admin/BlogManagements/BlogPosts/Trash", compact("trashBlogPosts"));
    }

    public function restore(Request $request, int $blogPostId): RedirectResponse
    {
        $blogPost = BlogPost::onlyTrashed()->findOrFail($blogPostId);

        $blogPost->restore();

        return to_route('admin.blogs.posts.trash', "page=$request->page&per_page=$request->per_page&sort=$request->sort&direction=$request->direction")
             ->with("success", "Post has been successfully restored.");
    }

    public function forceDelete(Request $request, int $blogPostId): RedirectResponse
    {
        $blogPost = BlogPost::onlyTrashed()->findOrFail($blogPostId);

        BlogPost::deleteImage($blogPost);

        $blogPost->forceDelete();

        return to_route('admin.blogs.posts.trash', "page=$request->page&per_page=$request->per_page&sort=$request->sort&direction=$request->direction")
             ->with("success", "The post has been permanently deleted.");
    }

    public function permanentlyDelete(Request $request): RedirectResponse
    {
        $blogPosts = BlogPost::onlyTrashed()->get();

        $blogPosts->each(function ($blogPost) {

            BlogPost::deleteImage($blogPost);

            $blogPost->forceDelete();

        });

        return to_route('admin.blogs.posts.trash', "page=$request->page&per_page=$request->per_page&sort=$request->sort&direction=$request->direction")
             ->with("success", "Posts have been successfully deleted.");
    }
}
