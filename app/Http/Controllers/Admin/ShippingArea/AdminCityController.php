<?php

namespace App\Http\Controllers\Admin\ShippingArea;

use App\Http\Controllers\Controller;
use App\Http\Requests\CityRequest;
use App\Http\Requests\RegionRequest;
use App\Models\City;
use App\Models\Country;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Inertia\Response;
use Inertia\ResponseFactory;
use Illuminate\Database\Eloquent\Builder;

class AdminCityController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        $cities=City::search(request("search"))
                            ->query(function (Builder $builder) {
                                $builder->with(["region.country", "townships"]);
                            })
                            ->orderBy(request("sort", "id"), request("direction", "desc"))
                            ->paginate(request("per_page", 10))
                            ->appends(request()->all());


        return inertia("Admin/ShippingAreas/Cities/Index", compact("cities"));
    }

    public function create(): Response|ResponseFactory
    {
        $per_page=request("per_page");

        $countries=Country::all();

        $regions=Region::all();

        return inertia("Admin/ShippingAreas/Cities/Create", compact("per_page", "countries", "regions"));
    }

    public function store(CityRequest $request): RedirectResponse
    {
        City::create($request->validated());

        return to_route("admin.cities.index", "per_page=$request->per_page")->with("success", "City has been successfully created.");
    }

    public function edit(City $city): Response|ResponseFactory
    {
        $paginate=[ "page"=>request("page"),"per_page"=>request("per_page")];

        $countries=Country::all();

        $regions=Region::all();

        return inertia("Admin/ShippingAreas/Cities/Edit", compact("city", "paginate", "countries", "regions"));
    }

    public function update(CityRequest $request, City $city): RedirectResponse
    {

        $city->update($request->validated());

        return to_route("admin.cities.index", "page=$request->page&per_page=$request->per_page")->with("success", "City has been successfully updated.");
    }

    public function destroy(Request $request, City $city): RedirectResponse
    {
        $city->delete();

        return to_route("admin.cities.index", "page=$request->page&per_page=$request->per_page")->with("success", "City has been successfully deleted.");
    }

    public function trash(): Response|ResponseFactory
    {
        $trashCities=City::search(request("search"))
                                ->onlyTrashed()
                                ->orderBy(request("sort", "id"), request("direction", "desc"))
                                ->paginate(request("per_page", 10))
                                ->appends(request()->all());

        return inertia("Admin/ShippingAreas/Cities/Trash", compact("trashCities"));
    }

    public function restore(Request $request, int $id): RedirectResponse
    {
        $city = City::onlyTrashed()->findOrFail($id);

        $city->restore();

        return to_route('admin.cities.trash', "page=$request->page&per_page=$request->per_page")->with("success", "City has been successfully restored.");
    }

    public function forceDelete(Request $request, int $id): RedirectResponse
    {
        $city = City::onlyTrashed()->findOrFail($id);

        $city->forceDelete();

        return to_route('admin.cities.trash', "page=$request->page&per_page=$request->per_page")->with("success", "The City has been permanently deleted.");
    }

    public function permanentlyDelete(Request $request): RedirectResponse
    {
        $cities = City::onlyTrashed()->get();

        $cities->each(function ($city) {
            $city->forceDelete();
        });

        return to_route('admin.cities.trash', "page=$request->page&per_page=$request->per_page")->with("success", "Cities have been successfully deleted.");
    }
}
