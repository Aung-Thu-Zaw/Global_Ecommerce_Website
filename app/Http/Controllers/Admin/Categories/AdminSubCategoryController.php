<?php

namespace App\Http\Controllers\Admin\Categories;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubCategoryRequest;
use App\Models\Category;
use App\Models\SubCategory;
use App\Services\SubCategoryImageUploadService;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AdminSubCategoryController extends Controller
{
    public function index(): Response
    {
        $subCategories=SubCategory::search(request("search"))
                                  ->orderBy(request("sort", "id"), request("direction", "desc"))
                                  ->paginate(request("per_page", 10))
                                  ->withQueryString();

        $subCategories->load("category:id,name");

        return inertia("Admin/Categories/SubCategory/Index", compact("subCategories"));
    }

    public function create(): Response
    {
        $categories=Category::select("id", "name")->get();

        $per_page=request("per_page");

        return inertia("Admin/Categories/SubCategory/Create", compact("categories", "per_page"));
    }

    public function store(SubCategoryRequest $request, SubCategoryImageUploadService $subCategoryImageUploadService): RedirectResponse
    {
        SubCategory::create($request->validated()+["image"=>$subCategoryImageUploadService->uploadImage($request)]);

        return to_route("admin.subcategories.index", "per_page=$request->per_page")->with("success", "SubCategory is created successfully.");
    }

    public function edit(SubCategory $subCategory): Response
    {
        $paginate=[ "page"=>request("page"),"per_page"=>request("per_page")];

        $categories=Category::select("id", "name")->get();

        $subCategory->load("category:id,name");

        return inertia("Admin/Categories/SubCategory/Edit", compact("subCategory", "categories", "paginate"));
    }

    public function update(SubCategoryRequest $request, SubCategory $subCategory, SubCategoryImageUploadService $subCategoryImageUploadService): RedirectResponse
    {
        $image=$subCategoryImageUploadService->updateImage($request, $subCategory);

        $subCategory->update($request->validated()+["image"=>$image]);

        return to_route("admin.subcategories.index", "page=$request->page&per_page=$request->per_page")->with("success", "SubCategory is updated successfully.");
    }

    public function destroy(Request $request, SubCategory $subCategory): RedirectResponse
    {
        $subCategory->delete();

        return to_route("admin.subcategories.index", "page=$request->page&per_page=$request->per_page")->with("success", "SubCategory is deleted successfully.");
    }

    public function trash(): Response
    {
        $trashSubCategories=SubCategory::search(request("search"))
                                       ->onlyTrashed()
                                       ->orderBy(request("sort", "id"), request("direction", "desc"))
                                       ->paginate(request("per_page", 10))
                                       ->withQueryString();

        $trashSubCategories->load("category:id,name");

        return inertia("Admin/Categories/SubCategory/Trash", compact("trashSubCategories"));
    }

    public function restore(Request $request, $id): RedirectResponse
    {
        $subCategory = SubCategory::onlyTrashed()->where("id", $id)->first();

        $subCategory->restore();

        return to_route('admin.subcategories.trash', "page=$request->page&per_page=$request->per_page")->with("success", "SubCategory is restored successfully.");
    }

    public function forceDelete(Request $request, $id): RedirectResponse
    {
        $subCategory = SubCategory::onlyTrashed()->where("id", $id)->first();

        $subCategory->forceDelete();

        return to_route('admin.subcategories.trash', "page=$request->page&per_page=$request->per_page")->with("success", "SubCategory is deleted successfully");
    }
}
