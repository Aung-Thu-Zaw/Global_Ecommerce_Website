<?php

namespace App\Http\Controllers\Admin\Categories;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Services\CategoryImageUploadService;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;

class AdminCategoryController extends Controller
{
    public function index(): Response
    {
        $categories=Category::paginate(15);

        return inertia("Admin/Categories/Category/Index", compact("categories"));
    }

    public function create(): Response
    {
        return inertia("Admin/Categories/Category/Create");
    }

    public function store(CategoryRequest $request, CategoryImageUploadService $categoryImageUploadService): RedirectResponse
    {
        Category::create($request->validated()+["image"=>$categoryImageUploadService->uploadImage($request)]);

        return to_route("admin.categories.index")->with("success", "Category is created successfully.");
    }

    public function edit(Category $category): Response
    {
        return inertia("Admin/Categories/Category/Edit", compact("category"));
    }

    public function update(CategoryRequest $request, Category $category, CategoryImageUploadService $categoryImageUploadService): RedirectResponse
    {
        $image=$categoryImageUploadService->updateImage($request, $category);

        $category->update($request->validated()+["image"=>$image]);

        return to_route("admin.categories.index")->with("success", "Category is updated successfully.");
    }

    public function destroy(Category $category): RedirectResponse
    {
        $category->delete();

        return to_route("admin.categories.index")->with("success", "Category is deleted successfully.");
    }

    public function trash(): Response
    {
        $trashCategories=Category::onlyTrashed()->paginate(15);

        return inertia("Admin/Categories/Category/Trash", compact("trashCategories"));
    }

    public function restore($id): RedirectResponse
    {
        $category = Category::onlyTrashed()->where("id", $id)->first();

        $category->restore();

        return to_route('admin.categories.trash')->with("success", "Category is restored successfully.");
    }

    public function forceDelete($id): RedirectResponse
    {
        $category = Category::onlyTrashed()->where("id", $id)->first();

        $category->forceDelete();

        return to_route('admin.categories.trash')->with("success", "Category is deleted successfully");
    }
}
