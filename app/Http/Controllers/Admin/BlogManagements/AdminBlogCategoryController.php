<?php

namespace App\Http\Controllers\Admin\BlogManagements;

use App\Actions\Admin\BlogManagements\BlogCategories\CreateBlogCategoryAction;
use App\Actions\Admin\BlogManagements\BlogCategories\PermanentlyDeleteAllTrashBlogCategoryAction;
use App\Actions\Admin\BlogManagements\BlogCategories\UpdateBlogCategoryAction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\BlogCategoryRequest;
use App\Models\BlogCategory;
use Inertia\Response;
use Inertia\ResponseFactory;
use Illuminate\Http\RedirectResponse;

class AdminBlogCategoryController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        $blogCategories=BlogCategory::search(request("search"))
                                    ->orderBy(request("sort", "id"), request("direction", "desc"))
                                    ->paginate(request("per_page", 10))
                                    ->appends(request()->all());

        return inertia("Admin/BlogManagements/BlogCategories/Index", compact("blogCategories"));
    }

    public function create(): Response|ResponseFactory
    {
        $per_page=request("per_page");

        return inertia("Admin/BlogManagements/BlogCategories/Create", compact("per_page"));
    }

    public function store(BlogCategoryRequest $request): RedirectResponse
    {
        (new CreateBlogCategoryAction())->handle($request->validated());

        $queryStringParams=["page"=>"1","per_page"=>$request->per_page,"sort"=>"id","direction"=>"desc"];

        return to_route("admin.blogs.categories.index", $queryStringParams)->with("success", "Blog category has been successfully created.");
    }

    public function edit(Request $request, BlogCategory $blogCategory): Response|ResponseFactory
    {
        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return inertia("Admin/BlogManagements/BlogCategories/Edit", compact("blogCategory", "queryStringParams"));
    }

    public function update(BlogCategoryRequest $request, BlogCategory $blogCategory): RedirectResponse
    {
        (new UpdateBlogCategoryAction())->handle($request->validated(), $blogCategory);

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route("admin.blogs.categories.index", $queryStringParams)->with("success", "Blog category has been successfully updated.");
    }

    public function destroy(Request $request, BlogCategory $blogCategory): RedirectResponse
    {
        $blogCategory->delete();

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route("admin.blogs.categories.index", $queryStringParams)->with("success", "Blog category has been successfully deleted.");
    }

    public function trash(): Response|ResponseFactory
    {
        $trashBlogCategories=BlogCategory::search(request("search"))
                                         ->onlyTrashed()
                                         ->orderBy(request("sort", "id"), request("direction", "desc"))
                                         ->paginate(request("per_page", 10))
                                         ->appends(request()->all());

        return inertia("Admin/BlogManagements/BlogCategories/Trash", compact("trashBlogCategories"));
    }

    public function restore(Request $request, int $trashBlogCategoryId): RedirectResponse
    {
        $blogCategory = BlogCategory::onlyTrashed()->findOrFail($trashBlogCategoryId);

        $blogCategory->restore();

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route('admin.blogs.categories.trash', $queryStringParams)->with("success", "Blog category has been successfully restored.");
    }

    public function forceDelete(Request $request, int $trashBlogCategoryId): RedirectResponse
    {
        $blogCategory = BlogCategory::onlyTrashed()->findOrFail($trashBlogCategoryId);

        BlogCategory::deleteImage($blogCategory->image);

        $blogCategory->forceDelete();

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route('admin.blogs.categories.trash', $queryStringParams)->with("success", "The blog category has been permanently deleted.");
    }

    public function permanentlyDelete(Request $request): RedirectResponse
    {
        $blogCategories = BlogCategory::onlyTrashed()->get();

        (new PermanentlyDeleteAllTrashBlogCategoryAction())->handle($blogCategories);

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route('admin.blogs.categories.trash', $queryStringParams)->with("success", "Blog categories have been successfully deleted.");
    }
}
