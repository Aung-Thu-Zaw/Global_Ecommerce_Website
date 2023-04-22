<?php

namespace App\Http\Controllers\Admin\ShippingArea;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegionRequest;
use App\Models\Country;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Inertia\Response;
use Inertia\ResponseFactory;
use Illuminate\Database\Eloquent\Builder;

class AdminRegionController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        $regions=Region::search(request("search"))
                            ->query(function (Builder $builder) {
                                $builder->with(["cities", "country"]);
                            })
                            ->orderBy(request("sort", "id"), request("direction", "desc"))
                            ->paginate(request("per_page", 10))
                            ->appends(request()->all());


        return inertia("Admin/ShippingAreas/Regions/Index", compact("regions"));
    }

    public function create(): Response|ResponseFactory
    {
        $per_page=request("per_page");

        $countries=Country::all();

        return inertia("Admin/ShippingAreas/Regions/Create", compact("per_page", "countries"));
    }

    public function store(RegionRequest $request): RedirectResponse
    {
        Region::create($request->validated());

        return to_route("admin.regions.index", "per_page=$request->per_page")->with("success", "Region has been successfully created.");
    }

    public function edit(Region $region): Response|ResponseFactory
    {
        $paginate=[ "page"=>request("page"),"per_page"=>request("per_page")];

        $countries=Country::all();

        return inertia("Admin/ShippingAreas/Regions/Edit", compact("re$region", "paginate", "countries"));
    }

    public function update(RegionRequest $request, Region $region): RedirectResponse
    {

        $region->update($request->validated());

        return to_route("admin.regions.index", "page=$request->page&per_page=$request->per_page")->with("success", "Region has been successfully updated.");
    }

    public function destroy(Request $request, Region $region): RedirectResponse
    {
        $region->delete();

        return to_route("admin.regions.index", "page=$request->page&per_page=$request->per_page")->with("success", "Region has been successfully deleted.");
    }

    public function trash(): Response|ResponseFactory
    {
        $trashRegions=Region::search(request("search"))
                                ->onlyTrashed()
                                ->orderBy(request("sort", "id"), request("direction", "desc"))
                                ->paginate(request("per_page", 10))
                                ->appends(request()->all());

        return inertia("Admin/ShippingAreas/Regions/Trash", compact("trashRegions"));
    }

    public function restore(Request $request, int $id): RedirectResponse
    {
        $region = Region::onlyTrashed()->where("id", $id)->first();

        $region->restore();

        return to_route('admin.regions.trash', "page=$request->page&per_page=$request->per_page")->with("success", "Region has been successfully restored.");
    }

    public function forceDelete(Request $request, int $id): RedirectResponse
    {
        $region = Region::onlyTrashed()->where("id", $id)->first();

        $region->forceDelete();

        return to_route('admin.regions.trash', "page=$request->page&per_page=$request->per_page")->with("success", "The Region has been permanently deleted.");
    }

    public function permanentlyDelete(Request $request): RedirectResponse
    {
        $regions = Region::onlyTrashed()->get();

        $regions->each(function ($region) {
            $region->forceDelete();
        });

        return to_route('admin.regions.trash', "page=$request->page&per_page=$request->per_page")->with("success", "Regions have been successfully deleted.");
    }
}
