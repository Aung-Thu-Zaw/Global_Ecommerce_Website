<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BrandRequest;
use App\Models\Brand;
use App\Services\BrandImageUploadService;
use Illuminate\Database\Eloquent\Builder;
use Inertia\Response;
use Inertia\ResponseFactory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AdminBrandController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        $brands=Brand::search(request("search"))
                     ->query(function (Builder $builder) {
                         $builder->with("products:id,brand_id,name");
                     })
                     ->orderBy(request("sort", "id"), request("direction", "desc"))
                     ->paginate(request("per_page", 10))
                     ->appends(request()->all());

        return inertia("Admin/Brands/Index", compact("brands"));
    }

    public function create(): Response|ResponseFactory
    {
        $per_page=request("per_page");

        return inertia("Admin/Brands/Create", compact("per_page"));
    }

    public function store(BrandRequest $request, BrandImageUploadService $brandImageUploadService): RedirectResponse
    {
        Brand::create($request->validated()+["image"=>$brandImageUploadService->createImage($request)]);

        return to_route("admin.brands.index", "per_page=$request->per_page")->with("success", "Brand has been successfully created.");
    }

    public function edit(Brand $brand): Response|ResponseFactory
    {
        $paginate=[ "page"=>request("page"),"per_page"=>request("per_page")];

        return inertia("Admin/Brands/Edit", compact("brand", "paginate"));
    }

    public function update(BrandRequest $request, Brand $brand, BrandImageUploadService $brandImageUploadService): RedirectResponse
    {
        $brand->update($request->validated()+["image"=>$brandImageUploadService->updateImage($request, $brand)]);

        return to_route("admin.brands.index", "page=$request->page&per_page=$request->per_page")->with("success", "Brand has been successfully updated.");
    }

    public function destroy(Request $request, Brand $brand): RedirectResponse
    {
        $brand->delete();

        return to_route("admin.brands.index", "page=$request->page&per_page=$request->per_page")->with("success", "Brand has been successfully deleted.");
    }

    public function trash(): Response|ResponseFactory
    {
        $trashBrands=Brand::search(request("search"))
                          ->onlyTrashed()
                          ->orderBy(request("sort", "id"), request("direction", "desc"))
                          ->paginate(request("per_page", 10))
                          ->appends(request()->all());

        return inertia("Admin/Brands/Trash", compact("trashBrands"));
    }

    public function restore(Request $request, int $id): RedirectResponse
    {
        $brand = Brand::onlyTrashed()->findOrFail($id);

        $brand->restore();

        return to_route('admin.brands.trash', "page=$request->page&per_page=$request->per_page")->with("success", "Brand has been successfully restored.");
    }

    public function forceDelete(Request $request, int $id): RedirectResponse
    {
        $brand = Brand::onlyTrashed()->findOrFail($id);

        Brand::deleteImage($brand);

        $brand->forceDelete();

        return to_route('admin.brands.trash', "page=$request->page&per_page=$request->per_page")->with("success", "The brand has been permanently deleted");
    }

    public function permanentlyDelete(Request $request): RedirectResponse
    {
        $brands = Brand::onlyTrashed()->get();

        $brands->each(function ($brand) {
            Brand::deleteImage($brand);
            $brand->forceDelete();
        });

        return to_route('admin.brands.trash', "page=$request->page&per_page=$request->per_page")->with("success", "Brands have been successfully deleted.");
    }
}
