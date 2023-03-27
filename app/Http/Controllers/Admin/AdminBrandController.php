<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BrandRequest;
use App\Models\Brand;
use App\Services\BrandImageUploadService;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AdminBrandController extends Controller
{
    public function index(): Response
    {
        $brands=Brand::search(request("search"))
                            ->orderBy(request("sort", "id"), request("direction", "desc"))
                            ->paginate(request("per_page", 10))
                            ->appends(request()->all());


        return inertia("Admin/Brands/Index", compact("brands"));
    }

    public function create(): Response
    {
        $per_page=request("per_page");

        return inertia("Admin/Brands/Create", compact("per_page"));
    }

    public function store(BrandRequest $request, BrandImageUploadService $brandImageUploadService): RedirectResponse
    {
        Brand::create($request->validated()+["image"=>$brandImageUploadService->createImage($request)]);

        return to_route("admin.brands.index", "per_page=$request->per_page")->with("success", "Brand is created successfully.");
    }

    public function edit(Brand $brand): Response
    {
        $paginate=[ "page"=>request("page"),"per_page"=>request("per_page")];

        return inertia("Admin/Brands/Edit", compact("brand", "paginate"));
    }

    public function update(BrandRequest $request, Brand $brand, BrandImageUploadService $brandImageUploadService): RedirectResponse
    {
        $image=$brandImageUploadService->updateImage($request, $brand);

        $brand->update($request->validated()+["image"=>$image]);

        return to_route("admin.brands.index", "page=$request->page&per_page=$request->per_page")->with("success", "Brand is updated successfully.");
    }

    public function destroy(Request $request, Brand $brand): RedirectResponse
    {
        $brand->delete();

        return to_route("admin.brands.index", "page=$request->page&per_page=$request->per_page")->with("success", "Brand is deleted successfully.");
    }

    public function trash(): Response
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
        $brand = Brand::onlyTrashed()->where("id", $id)->first();

        $brand->restore();

        return to_route('admin.brands.trash', "page=$request->page&per_page=$request->per_page")->with("success", "Brand is restored successfully.");
    }

    public function forceDelete(Request $request, int $id): RedirectResponse
    {
        $brand = Brand::onlyTrashed()->where("id", $id)->first();

        Brand::deleteImage($brand);

        $brand->forceDelete();

        return to_route('admin.brands.trash', "page=$request->page&per_page=$request->per_page")->with("success", "Brand is deleted successfully");
    }
}
