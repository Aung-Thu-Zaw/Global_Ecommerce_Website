<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\Categories\CreateCategoryAction;
use App\Actions\Admin\Categories\UpdateCategoryAction;
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

    public function store(CategoryRequest $request): RedirectResponse
    {
        (new CreateCategoryAction())->handle($request->validated());

        $urlStringQuery="page=1&per_page=$request->per_page&sort=id&direction=desc";

        return to_route("admin.categories.index", $urlStringQuery)->with("success", "Category has been successfully created.");
    }

    public function edit(Category $category): Response|ResponseFactory
    {
        $queryStringParams=["page"=>request("page"),"per_page"=>request("per_page"),"sort"=>request("sort"),"direction"=>request("direction")];

        $categories=Category::select("id", "parent_id", "name")->get();

        return inertia("Admin/Categories/Edit", compact("category", "queryStringParams", "categories"));
    }

    public function update(CategoryRequest $request, Category $category): RedirectResponse
    {
        (new UpdateCategoryAction())->handle($request->validated(), $category);

        $urlStringQuery="page=".request("page")."&per_page=".request("per_page")."&sort=".request("sort")."&direction=".request("direction");

        return to_route("admin.categories.index", $urlStringQuery)->with("success", "Category has been successfully updated.");
    }

    public function destroy(Category $category): RedirectResponse
    {
        $category->delete();

        $urlStringQuery="page=".request("page")."&per_page=".request("per_page")."&sort=".request("sort")."&direction=".request("direction");

        return to_route("admin.categories.index", $urlStringQuery)->with("success", "Category has been successfully deleted.");
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

    public function restore(int $trashCategoryId): RedirectResponse
    {
        $category = Category::onlyTrashed()->findOrFail($trashCategoryId);

        $category->restore();

        $urlStringQuery="page=".request("page")."&per_page=".request("per_page")."&sort=".request("sort")."&direction=".request("direction");

        return to_route('admin.categories.trash', $urlStringQuery)->with("success", "Category has been successfully restored.");
    }

    public function forceDelete(int $trashCategoryId): RedirectResponse
    {
        $category = Category::onlyTrashed()->findOrFail($trashCategoryId);

        Category::deleteImage($category->image);

        $category->forceDelete();

        $urlStringQuery="page=".request("page")."&per_page=".request("per_page")."&sort=".request("sort")."&direction=".request("direction");

        return to_route('admin.categories.trash', $urlStringQuery)->with("success", "The category has been permanently deleted.");
    }

    public function permanentlyDelete(): RedirectResponse
    {
        $categories = Category::onlyTrashed()->get();

        $categories->each(function ($category) {

            Category::deleteImage($category->image);

            $category->forceDelete();

        });

        $urlStringQuery="page=".request("page")."&per_page=".request("per_page")."&sort=".request("sort")."&direction=".request("direction");

        return to_route('admin.categories.trash', $urlStringQuery)->with("success", "Categories have been successfully deleted.");
    }
}
