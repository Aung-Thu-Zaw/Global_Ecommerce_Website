<?php

namespace App\Http\Controllers\Admin\ShippingArea;

use App\Http\Controllers\Controller;
use App\Http\Requests\TownshipRequest;
use App\Models\City;
use App\Models\Country;
use App\Models\Region;
use App\Models\Township;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Inertia\Response;
use Inertia\ResponseFactory;
use Illuminate\Database\Eloquent\Builder;

class AdminTownshipController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        $townships=Township::search(request("search"))
                            ->query(function (Builder $builder) {
                                $builder->with("city.region.country");
                            })
                            ->orderBy(request("sort", "id"), request("direction", "desc"))
                            ->paginate(request("per_page", 10))
                            ->appends(request()->all());


        return inertia("Admin/ShippingAreas/Townships/Index", compact("townships"));
    }

    public function create(): Response|ResponseFactory
    {
        $per_page=request("per_page");

        $countries=Country::all();

        $regions=Region::all();

        $cities=City::all();

        return inertia("Admin/ShippingAreas/Townships/Create", compact("per_page", "countries", "regions", "cities"));
    }

    public function store(TownshipRequest $request): RedirectResponse
    {
        Township::create($request->validated());

        return to_route("admin.townships.index", "per_page=$request->per_page")->with("success", "Township has been successfully created.");
    }

    public function edit(City $city): Response|ResponseFactory
    {
        $paginate=[ "page"=>request("page"),"per_page"=>request("per_page")];

        $countries=Country::all();

        $regions=Region::all();

        $cities=City::all();

        return inertia("Admin/ShippingAreas/Townships/Edit", compact("city", "paginate", "countries", "regions", "cities"));
    }

    public function update(TownshipRequest $request, Township $township): RedirectResponse
    {

        $township->update($request->validated());

        return to_route("admin.townships.index", "page=$request->page&per_page=$request->per_page")->with("success", "Township has been successfully updated.");
    }

    public function destroy(Request $request, Township $township): RedirectResponse
    {
        $township->delete();

        return to_route("admin.townships.index", "page=$request->page&per_page=$request->per_page")->with("success", "Township has been successfully deleted.");
    }

    public function trash(): Response|ResponseFactory
    {
        $trashTownships=Township::search(request("search"))
                                ->onlyTrashed()
                                ->orderBy(request("sort", "id"), request("direction", "desc"))
                                ->paginate(request("per_page", 10))
                                ->appends(request()->all());

        return inertia("Admin/ShippingAreas/Townships/Trash", compact("trashTownships"));
    }

    public function restore(Request $request, int $id): RedirectResponse
    {
        $township = Township::onlyTrashed()->where("id", $id)->first();

        $township->restore();

        return to_route('admin.townships.trash', "page=$request->page&per_page=$request->per_page")->with("success", "Township has been successfully restored.");
    }

    public function forceDelete(Request $request, int $id): RedirectResponse
    {
        $township = Township::onlyTrashed()->where("id", $id)->first();

        $township->forceDelete();

        return to_route('admin.townships.trash', "page=$request->page&per_page=$request->per_page")->with("success", "The Township has been permanently deleted.");
    }

    public function permanentlyDelete(Request $request): RedirectResponse
    {
        $township = Township::onlyTrashed()->get();

        $township->each(function ($township) {
            $township->forceDelete();
        });

        return to_route('admin.townships.trash', "page=$request->page&per_page=$request->per_page")->with("success", "Townships have been successfully deleted.");
    }
}
