<?php

namespace App\Http\Controllers\Admin\ShippingAreas;

use App\Actions\Admin\ShippingAreas\PermanentlyDeleteAllTrashTownshipAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\TownshipRequest;
use App\Http\Traits\HandlesQueryStringParameters;
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
    use HandlesQueryStringParameters;

    public function index(): Response|ResponseFactory
    {
        $townships = Township::search(request("search"))
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
        $per_page = request("per_page");

        $countries = Country::all();

        $regions = Region::all();

        $cities = City::all();

        return inertia("Admin/ShippingAreas/Townships/Create", compact("per_page", "countries", "regions", "cities"));
    }

    public function store(TownshipRequest $request): RedirectResponse
    {
        Township::create(["name" => $request->name,"city_id" => $request->city_id]);

        return to_route("admin.townships.index", $this->getQueryStringParams($request))->with("success", "TOWNSHIP_HAS_BEEN_SUCCESSFULLY_CREATED");
    }

    public function edit(Request $request, Township $township): Response|ResponseFactory
    {
        $countries = Country::all();

        $regions = Region::all();

        $cities = City::all();

        $township->load(["city.region.country"]);

        $queryStringParams = $this->getQueryStringParams($request);

        return inertia("Admin/ShippingAreas/Townships/Edit", compact("township", "queryStringParams", "countries", "regions", "cities"));
    }

    public function update(TownshipRequest $request, Township $township): RedirectResponse
    {
        $township->update(["name" => $request->name,"city_id" => $request->city_id]);

        return to_route("admin.townships.index", $this->getQueryStringParams($request))->with("success", "TOWNSHIP_HAS_BEEN_SUCCESSFULLY_UPDATED");
    }

    public function destroy(Request $request, Township $township): RedirectResponse
    {
        $township->delete();

        return to_route("admin.townships.index", $this->getQueryStringParams($request))->with("success", "TOWNSHIP_HAS_BEEN_SUCCESSFULLY_DELETED");
    }

    public function trash(): Response|ResponseFactory
    {
        $trashTownships = Township::search(request("search"))
                                  ->onlyTrashed()
                                  ->orderBy(request("sort", "id"), request("direction", "desc"))
                                  ->paginate(request("per_page", 10))
                                  ->appends(request()->all());

        return inertia("Admin/ShippingAreas/Townships/Trash", compact("trashTownships"));
    }

    public function restore(Request $request, int $trashTownshipId): RedirectResponse
    {
        $trashTownship = Township::onlyTrashed()->findOrFail($trashTownshipId);

        $trashTownship->restore();

        return to_route('admin.townships.trash', $this->getQueryStringParams($request))->with("success", "TOWNSHIP_HAS_BEEN_SUCCESSFULLY_RESTORED");
    }

    public function forceDelete(Request $request, int $trashTownshipId): RedirectResponse
    {
        $trashTownship = Township::onlyTrashed()->findOrFail($trashTownshipId);

        $trashTownship->forceDelete();

        return to_route('admin.townships.trash', $this->getQueryStringParams($request))->with("success", "THE_TOWNSHIP_HAS_BEEN_PERMANENTLY_DELETED");
    }

    public function permanentlyDelete(Request $request): RedirectResponse
    {
        $trashTownships = Township::onlyTrashed()->get();

        (new PermanentlyDeleteAllTrashTownshipAction())->handle($trashTownships);

        return to_route('admin.townships.trash', $this->getQueryStringParams($request))->with("success", "TOWNSHIPS_HAVE_BEEN_PERMANENTLY_DELETED");
    }
}
