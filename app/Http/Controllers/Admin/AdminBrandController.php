<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\Brands\CreateBrandAction;
use App\Actions\Admin\Brands\PermanentlyDeleteAllTrashBrandAction;
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

        $queryStringParams=["page"=>"1","per_page"=>$request->per_page,"sort"=>"id","direction"=>"desc"];

        return to_route("admin.brands.index", $queryStringParams)->with("success", "BRAND_HAS_BEEN_SUCCESSFULLY_CREATED");
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

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route("admin.brands.index", $queryStringParams)->with("success", "BRAND_HAS_BEEN_SUCCESSFULLY_UPDATED");
    }

    public function destroy(Request $request, Brand $brand): RedirectResponse
    {
        $brand->delete();

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route("admin.brands.index", $queryStringParams)->with("success", "BRAND_HAS_BEEN_SUCCESSFULLY_DELETED");
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
        $trashBrand = Brand::onlyTrashed()->findOrFail($trashBrandId);

        $trashBrand->restore();

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route('admin.brands.trash', $queryStringParams)->with("success", "BRAND_HAS_BEEN_SUCCESSFULLY_RESTORED");
    }

    public function forceDelete(Request $request, int $trashBrandId): RedirectResponse
    {
        $trashBrand = Brand::onlyTrashed()->findOrFail($trashBrandId);

        Brand::deleteImage($trashBrand->image);

        $trashBrand->forceDelete();

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route('admin.brands.trash', $queryStringParams)->with("success", "THE_BRAND_HAS_BEEN_PERMANENTLY_DELETED");
    }

    public function permanentlyDelete(Request $request): RedirectResponse
    {
        $trashBrands = Brand::onlyTrashed()->get();

        (new PermanentlyDeleteAllTrashBrandAction())->handle($trashBrands);

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route('admin.brands.trash', $queryStringParams)->with("success", "BRANDS_HAVE_BEEN_PERMANENTLY_DELETED");
    }
}
