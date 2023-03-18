<?php

namespace App\Http\Controllers\Admin\Categories;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubCategoryRequest;
use App\Http\Resources\SubCategoryResource;
use App\Models\Category;
use App\Models\SubCategory;
use App\Services\SubCategoryImageUploadService;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;

class AdminSubCategoryController extends Controller
{
    public function index(): Response
    {
        $getSubCategories=SubCategory::search(request("search"))->paginate(15);

        $getSubCategories->load("category:id,name");

        $subCategories=SubCategoryResource::collection($getSubCategories);

        return inertia("Admin/Categories/SubCategory/Index", compact("subCategories"));
    }

    public function create(): Response
    {
        $categories=Category::select("id", "name")->get();

        return inertia("Admin/Categories/SubCategory/Create", compact("categories"));
    }

    public function store(SubCategoryRequest $request, SubCategoryImageUploadService $subCategoryImageUploadService): RedirectResponse
    {
        SubCategory::create($request->validated()+["image"=>$subCategoryImageUploadService->uploadImage($request)]);

        return to_route("admin.subcategories.index")->with("success", "SubCategory is created successfully.");
    }

    public function edit(SubCategory $subCategory): Response
    {
        $categories=Category::select("id", "name")->get();

        $subCategory->load("category:id,name");

        return inertia("Admin/Categories/SubCategory/Edit", compact("subCategory", "categories"));
    }

    public function update(SubCategoryRequest $request, SubCategory $subCategory, SubCategoryImageUploadService $subCategoryImageUploadService): RedirectResponse
    {
        $image=$subCategoryImageUploadService->updateImage($request, $subCategory);

        $subCategory->update($request->validated()+["image"=>$image]);

        return to_route("admin.subcategories.index")->with("success", "SubCategory is updated successfully.");
    }

    public function destroy(SubCategory $subCategory): RedirectResponse
    {
        $subCategory->delete();

        return to_route("admin.subcategories.index")->with("success", "SubCategory is deleted successfully.");
    }

    public function trash(): Response
    {
        $trashSubCategories=SubCategory::search(request("search"))->onlyTrashed()->paginate(15);

        $trashSubCategories->load("category:id,name");

        return inertia("Admin/Categories/SubCategory/Trash", compact("trashSubCategories"));
    }

    public function restore($id): RedirectResponse
    {
        $subCategory = SubCategory::onlyTrashed()->where("id", $id)->first();

        $subCategory->restore();

        return to_route('admin.subcategories.trash')->with("success", "SubCategory is restored successfully.");
    }

    public function forceDelete($id): RedirectResponse
    {
        $subCategory = SubCategory::onlyTrashed()->where("id", $id)->first();

        $subCategory->forceDelete();

        return to_route('admin.subcategories.trash')->with("success", "SubCategory is deleted successfully");
    }
}
