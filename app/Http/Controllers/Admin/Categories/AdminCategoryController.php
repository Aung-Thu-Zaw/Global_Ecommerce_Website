<?php

namespace App\Http\Controllers\Admin\Categories;

/*
*
* @return \Illuminate\Pagination\LengthAwarePaginator
*/

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Services\CategoryImageUploadService;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AdminCategoryController extends Controller
{
    public function index(): Response
    {
        $categories=Category::search(request("search"))
                            ->orderBy(request("sort", "id"), request("direction", "desc"))
                            ->paginate(request("per_page", 10))
                            ->appends(request()->all());


        return inertia("Admin/Categories/Category/Index", compact("categories"));
    }

    public function create(): Response
    {
        $per_page=request("per_page");

        return inertia("Admin/Categories/Category/Create", compact("per_page"));
    }

    public function store(CategoryRequest $request, CategoryImageUploadService $categoryImageUploadService): RedirectResponse
    {
        Category::create($request->validated()+["image"=>$categoryImageUploadService->uploadImage($request)]);

        return to_route("admin.categories.index", "per_page=$request->per_page")->with("success", "Category is created successfully.");
    }

    public function edit(Category $category): Response
    {
        $paginate=[ "page"=>request("page"),"per_page"=>request("per_page")];

        return inertia("Admin/Categories/Category/Edit", compact("category", "paginate"));
    }

    public function update(CategoryRequest $request, Category $category, CategoryImageUploadService $categoryImageUploadService): RedirectResponse
    {
        $image=$categoryImageUploadService->updateImage($request, $category);

        $category->update($request->validated()+["image"=>$image]);

        return to_route("admin.categories.index", "page=$request->page&per_page=$request->per_page")->with("success", "Category is updated successfully.");
    }

    public function destroy(Request $request, Category $category): RedirectResponse
    {
        $category->delete();

        return to_route("admin.categories.index", "page=$request->page&per_page=$request->per_page")->with("success", "Category is deleted successfully.");
    }

    public function trash(): Response
    {
        $trashCategories=Category::search(request("search"))
                                ->onlyTrashed()
                                ->orderBy(request("sort", "id"), request("direction", "desc"))
                                ->paginate(request("per_page", 10))
                                ->appends(request()->all());

        return inertia("Admin/Categories/Category/Trash", compact("trashCategories"));
    }

    public function restore(Request $request, int $id): RedirectResponse
    {
        $category = Category::onlyTrashed()->where("id", $id)->first();

        $category->restore();

        return to_route('admin.categories.trash', "page=$request->page&per_page=$request->per_page")->with("success", "Category is restored successfully.");
    }

    public function forceDelete(Request $request, int $id): RedirectResponse
    {
        $category = Category::onlyTrashed()->where("id", $id)->first();

        $category->forceDelete();

        return to_route('admin.categories.trash', "page=$request->page&per_page=$request->per_page")->with("success", "Category is deleted successfully");
    }
}
