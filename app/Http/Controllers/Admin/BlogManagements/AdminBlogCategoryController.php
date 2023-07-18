<?php

namespace App\Http\Controllers\Admin\BlogManagements;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\BlogCategoryRequest;
use App\Models\BlogCategory;
use App\Services\BlogCategoryImageUploadService;
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

    public function store(BlogCategoryRequest $request, BlogCategoryImageUploadService $blogCategoryImageUploadService): RedirectResponse
    {
        BlogCategory::create($request->validated()+["image"=>$blogCategoryImageUploadService->createImage($request)]);

        return to_route("admin.blogs.categories.index", "per_page=$request->per_page")->with("success", "Blog category has been successfully created.");
    }

    public function edit(BlogCategory $blogCategory): Response|ResponseFactory
    {
        $queryStringParams=[ "page"=>request("page"),"per_page"=>request("per_page"),"sort"=>request("sort"),"direction"=>request("direction")];

        return inertia("Admin/BlogManagements/BlogCategories/Edit", compact("blogCategory", "queryStringParams"));
    }

    public function update(BlogCategoryRequest $request, BlogCategory $blogCategory, BlogCategoryImageUploadService $blogCategoryImageUploadService): RedirectResponse
    {
        $blogCategory->update($request->validated()+["image"=>$blogCategoryImageUploadService->updateImage($request, $blogCategory)]);

        return to_route("admin.blogs.categories.index", "page=$request->page&per_page=$request->per_page&sort=$request->sort&direction=$request->direction")
             ->with("success", "Blog category has been successfully updated.");
    }

    public function destroy(Request $request, BlogCategory $blogCategory): RedirectResponse
    {
        $blogCategory->delete();

        return to_route("admin.blogs.categories.index", "page=$request->page&per_page=$request->per_page&sort=$request->sort&direction=$request->direction")
             ->with("success", "Blog category has been successfully deleted.");
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

    public function restore(Request $request, int $blogCategoryId): RedirectResponse
    {
        $blogCategory = BlogCategory::onlyTrashed()->findOrFail($blogCategoryId);

        $blogCategory->restore();

        return to_route('admin.blogs.categories.trash', "page=$request->page&per_page=$request->per_page&sort=$request->sort&direction=$request->direction")
             ->with("success", "Blog category has been successfully restored.");
    }

    public function forceDelete(Request $request, int $blogCategoryId): RedirectResponse
    {
        $blogCategory = BlogCategory::onlyTrashed()->findOrFail($blogCategoryId);

        BlogCategory::deleteImage($blogCategory);

        $blogCategory->forceDelete();

        return to_route('admin.blogs.categories.trash', "page=$request->page&per_page=$request->per_page&sort=$request->sort&direction=$request->direction")
             ->with("success", "The blog category has been permanently deleted.");
    }

    public function permanentlyDelete(Request $request): RedirectResponse
    {
        $blogCategories = BlogCategory::onlyTrashed()->get();

        $blogCategories->each(function ($blogCategory) {

            BlogCategory::deleteImage($blogCategory);

            $blogCategory->forceDelete();

        });

        return to_route('admin.blogs.categories.trash', "page=$request->page&per_page=$request->per_page&sort=$request->sort&direction=$request->direction")
             ->with("success", "Blog categories have been successfully deleted.");
    }
}
