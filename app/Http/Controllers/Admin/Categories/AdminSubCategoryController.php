<?php

namespace App\Http\Controllers\Admin\Categories;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubCategoryRequest;
use App\Models\Category;
use App\Models\SubCategory;
use App\Services\SubCategoryImageUploadService;
use Illuminate\Database\Eloquent\Builder;
use Inertia\Response;
use Inertia\ResponseFactory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AdminSubCategoryController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        $subCategories=SubCategory::search(request("search"))
                                  ->query(function (Builder $builder) {
                                      $builder->with(["category:id,name", "products:id,sub_category_id,name"]);
                                  })
                                  ->orderBy(request("sort", "id"), request("direction", "desc"))
                                  ->paginate(request("per_page", 10))
                                  ->appends(request()->all());


        return inertia("Admin/Categories/SubCategory/Index", compact("subCategories"));
    }

    public function create(): Response|ResponseFactory
    {
        $categories=Category::select("id", "name")->get();

        $per_page=request("per_page");

        return inertia("Admin/Categories/SubCategory/Create", compact("categories", "per_page"));
    }

    public function store(SubCategoryRequest $request, SubCategoryImageUploadService $subCategoryImageUploadService): RedirectResponse
    {
        SubCategory::create($request->validated()+["image"=>$subCategoryImageUploadService->createImage($request)]);

        return to_route("admin.subcategories.index", "per_page=$request->per_page")->with("success", "SubCategory has been successfully created.");
    }

    public function edit(SubCategory $subCategory): Response|ResponseFactory
    {
        $paginate=[ "page"=>request("page"),"per_page"=>request("per_page")];

        $categories=Category::select("id", "name")->get();

        $subCategory->load("category:id,name");

        return inertia("Admin/Categories/SubCategory/Edit", compact("subCategory", "categories", "paginate"));
    }

    public function update(SubCategoryRequest $request, SubCategory $subCategory, SubCategoryImageUploadService $subCategoryImageUploadService): RedirectResponse
    {
        $subCategory->update($request->validated()+["image"=>$subCategoryImageUploadService->updateImage($request, $subCategory)]);

        return to_route("admin.subcategories.index", "page=$request->page&per_page=$request->per_page")->with("success", "SubCategory has been successfully updated.");
    }

    public function destroy(Request $request, SubCategory $subCategory): RedirectResponse
    {
        $subCategory->delete();

        return to_route("admin.subcategories.index", "page=$request->page&per_page=$request->per_page")->with("success", "SubCategory has been successfully deleted.");
    }

    public function trash(): Response|ResponseFactory
    {
        $trashSubCategories=SubCategory::search(request("search"))
                                       ->query(function (Builder $builder) {
                                           $builder->with("category:id,name");
                                       })
                                       ->onlyTrashed()
                                       ->orderBy(request("sort", "id"), request("direction", "desc"))
                                       ->paginate(request("per_page", 10))
                                       ->appends(request()->all());


        return inertia("Admin/Categories/SubCategory/Trash", compact("trashSubCategories"));
    }

    public function restore(Request $request, int $id): RedirectResponse
    {
        $subCategory = SubCategory::onlyTrashed()->where("id", $id)->first();

        $subCategory->restore();

        return to_route('admin.subcategories.trash', "page=$request->page&per_page=$request->per_page")->with("success", "SubCategory has been successfully restored.");
    }

    public function forceDelete(Request $request, int $id): RedirectResponse
    {
        $subCategory = SubCategory::onlyTrashed()->where("id", $id)->first();

        SubCategory::deleteImage($subCategory);

        $subCategory->forceDelete();

        return to_route('admin.subcategories.trash', "page=$request->page&per_page=$request->per_page")->with("success", "The SubCategory has been permanently deleted");
    }
}
