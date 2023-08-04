<?php

namespace App\Http\Controllers\Admin\BlogManagements;

use App\Actions\Admin\BlogManagements\BlogPosts\CreateBlogPostAction;
use App\Actions\Admin\BlogManagements\BlogPosts\PermanentlyDeleteAllTrashBlogPostAction;
use App\Actions\Admin\BlogManagements\BlogPosts\UpdateBlogPostAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\BlogPostRequest;
use App\Models\BlogCategory;
use App\Models\BlogPost;
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

    public function store(BlogPostRequest $request): RedirectResponse
    {
        (new CreateBlogPostAction())->handle($request->validated());

        $queryStringParams=["page"=>"1","per_page"=>$request->per_page,"sort"=>"id","direction"=>"desc"];

        return to_route("admin.blogs.posts.index", $queryStringParams)->with("success", "Post has been successfully created.");
    }

    public function edit(Request $request, BlogPost $blogPost): Response|ResponseFactory
    {
        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        $blogCategories=BlogCategory::all();

        $blogPost->load(["blogTags"]);

        return inertia("Admin/BlogManagements/BlogPosts/Edit", compact("blogPost", "queryStringParams", "blogCategories"));
    }

    public function update(BlogPostRequest $request, BlogPost $blogPost): RedirectResponse
    {
        (new UpdateBlogPostAction())->handle($request->validated(), $blogPost);

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route("admin.blogs.posts.index", $queryStringParams)->with("success", "Post has been successfully updated.");
    }

    public function destroy(Request $request, BlogPost $blogPost): RedirectResponse
    {
        $blogPost->delete();

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route("admin.blogs.posts.index", $queryStringParams)->with("success", "Post has been successfully deleted.");
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

    public function restore(Request $request, int $trashBlogPostId): RedirectResponse
    {
        $blogPost = BlogPost::onlyTrashed()->findOrFail($trashBlogPostId);

        $blogPost->restore();

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route('admin.blogs.posts.trash', $queryStringParams)->with("success", "Post has been successfully restored.");
    }

    public function forceDelete(Request $request, int $trashBlogPostId): RedirectResponse
    {
        $blogPost = BlogPost::onlyTrashed()->findOrFail($trashBlogPostId);

        BlogPost::deleteImage($blogPost->image);

        $blogPost->forceDelete();

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route('admin.blogs.posts.trash', $queryStringParams)->with("success", "The post has been permanently deleted.");
    }

    public function permanentlyDelete(Request $request): RedirectResponse
    {
        $blogPosts = BlogPost::onlyTrashed()->get();

        (new PermanentlyDeleteAllTrashBlogPostAction())->handle($blogPosts);

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route('admin.blogs.posts.trash', $queryStringParams)->with("success", "Posts have been successfully deleted.");
    }
}
