<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Services\CategoryImageUploadService;
use Illuminate\Database\Eloquent\Builder;
use Inertia\Response;
use Inertia\ResponseFactory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AdminCategoryController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        $categories=Category::search(request("search"))
                            ->query(function (Builder $builder) {
                                $builder->with("children");
                            })
                            ->orderBy(request("sort", "id"), request("direction", "desc"))
                            ->paginate(request("per_page", 10))
                            ->appends(request()->all());

        return inertia("Admin/Categories/Index", compact("categories"));
    }

    public function create(): Response|ResponseFactory
    {
        $per_page=request("per_page");

        $categories=Category::select("id", "parent_id", "name")->get();

        return inertia("Admin/Categories/Create", compact("per_page", "categories"));
    }

    public function store(CategoryRequest $request, CategoryImageUploadService $categoryImageUploadService): RedirectResponse
    {
        Category::create($request->validated()+["image"=>$categoryImageUploadService->createImage($request)]);

        return to_route("admin.categories.index", "per_page=$request->per_page")->with("success", "Category has been successfully created.");
    }

    public function edit(Category $category): Response|ResponseFactory
    {
        $paginate=[ "page"=>request("page"),"per_page"=>request("per_page")];

        $categories=Category::select("id", "parent_id", "name")->get();

        return inertia("Admin/Categories/Edit", compact("category", "paginate", "categories"));
    }

    public function update(CategoryRequest $request, Category $category, CategoryImageUploadService $categoryImageUploadService): RedirectResponse
    {
        $category->update($request->validated()+["image"=>$categoryImageUploadService->updateImage($request, $category)]);

        return to_route("admin.categories.index", "page=$request->page&per_page=$request->per_page")->with("success", "Category has been successfully updated.");
    }

    public function destroy(Request $request, Category $category): RedirectResponse
    {
        $category->delete();

        return to_route("admin.categories.index", "page=$request->page&per_page=$request->per_page")->with("success", "Category has been successfully deleted.");
    }

    public function trash(): Response|ResponseFactory
    {
        $trashCategories=Category::search(request("search"))
                                 ->onlyTrashed()
                                 ->orderBy(request("sort", "id"), request("direction", "desc"))
                                 ->paginate(request("per_page", 10))
                                 ->appends(request()->all());

        return inertia("Admin/Categories/Trash", compact("trashCategories"));
    }

    public function restore(Request $request, int $id): RedirectResponse
    {
        $category = Category::onlyTrashed()->findOrFail($id);

        $category->restore();

        return to_route('admin.categories.trash', "page=$request->page&per_page=$request->per_page")->with("success", "Category has been successfully restored.");
    }

    public function forceDelete(Request $request, int $id): RedirectResponse
    {
        $category = Category::onlyTrashed()->findOrFail($id);

        Category::deleteImage($category);

        $category->forceDelete();

        return to_route('admin.categories.trash', "page=$request->page&per_page=$request->per_page")->with("success", "The category has been permanently deleted.");
    }

    public function permanentlyDelete(Request $request): RedirectResponse
    {
        $categories = Category::onlyTrashed()->get();

        $categories->each(function ($category) {

            Category::deleteImage($category);

            $category->forceDelete();

        });

        return to_route('admin.categories.trash', "page=$request->page&per_page=$request->per_page")->with("success", "Categories have been successfully deleted.");
    }
}
