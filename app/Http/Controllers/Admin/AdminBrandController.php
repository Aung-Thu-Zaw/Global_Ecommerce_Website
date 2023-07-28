<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\Brands\CreateBrandAction;
use App\Actions\Admin\Brands\UpdateBrandAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\BrandRequest;
use App\Models\Brand;
use App\Models\Category;
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
                         $builder->with("products:id,brand_id");
                     })
                     ->orderBy(request("sort", "id"), request("direction", "desc"))
                     ->paginate(request("per_page", 10))
                     ->appends(request()->all());

        return inertia("Admin/Brands/Index", compact("brands"));
    }

    public function create(): Response|ResponseFactory
    {
        $per_page=request("per_page");

        $categories=Category::all();

        return inertia("Admin/Brands/Create", compact("per_page", "categories"));
    }

    public function store(BrandRequest $request): RedirectResponse
    {
        (new CreateBrandAction())->handle($request->validated());

        $urlStringQuery="page=1&per_page=$request->per_page&sort=id&direction=desc";

        return to_route("admin.brands.index", $urlStringQuery)->with("success", "Brand has been successfully created.");
    }

    public function edit(Request $request, Brand $brand): Response|ResponseFactory
    {
        $categories=Category::all();

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return inertia("Admin/Brands/Edit", compact("brand", "categories", "queryStringParams"));
    }

    public function update(BrandRequest $request, Brand $brand): RedirectResponse
    {
        (new UpdateBrandAction())->handle($request->validated(), $brand);

        $urlStringQuery="page=$request->page&per_page=$request->per_page&sort=$request->sort&direction=$request->direction";

        return to_route("admin.brands.index", $urlStringQuery)->with("success", "Brand has been successfully updated.");
    }

    public function destroy(Request $request, Brand $brand): RedirectResponse
    {
        $brand->delete();

        $urlStringQuery="page=$request->page&per_page=$request->per_page&sort=$request->sort&direction=$request->direction";

        return to_route("admin.brands.index", $urlStringQuery)->with("success", "Brand has been successfully deleted.");
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

    public function restore(Request $request, int $trashBrandId): RedirectResponse
    {
        $brand = Brand::onlyTrashed()->findOrFail($trashBrandId);

        $brand->restore();

        $urlStringQuery="page=$request->page&per_page=$request->per_page&sort=$request->sort&direction=$request->direction";

        return to_route('admin.brands.trash', $urlStringQuery)->with("success", "Brand has been successfully restored.");
    }

    public function forceDelete(Request $request, int $trashBrandId): RedirectResponse
    {
        $brand = Brand::onlyTrashed()->findOrFail($trashBrandId);

        Brand::deleteImage($brand->image);

        $brand->forceDelete();

        $urlStringQuery="page=$request->page&per_page=$request->per_page&sort=$request->sort&direction=$request->direction";

        return to_route('admin.brands.trash', $urlStringQuery)->with("success", "The brand has been permanently deleted");
    }

    public function permanentlyDelete(Request $request): RedirectResponse
    {
        $brands = Brand::onlyTrashed()->get();

        $brands->each(function ($brand) {

            Brand::deleteImage($brand->image);

            $brand->forceDelete();

        });

        $urlStringQuery="page=$request->page&per_page=$request->per_page&sort=$request->sort&direction=$request->direction";

        return to_route('admin.brands.trash', $urlStringQuery)->with("success", "Brands have been successfully deleted.");
    }
}
