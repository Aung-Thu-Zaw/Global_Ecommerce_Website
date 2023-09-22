<?php

namespace App\Http\Controllers\Admin\ShippingAreas;

use App\Actions\Admin\ShippingAreas\PermanentlyDeleteAllTrashCountryAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\CountryRequest;
use App\Http\Traits\HandlesQueryStringParameters;
use App\Models\Country;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\ResponseFactory;
use Illuminate\Database\Eloquent\Builder;

class AdminCountryController extends Controller
{
    use HandlesQueryStringParameters;

    public function index(): Response|ResponseFactory
    {
        $countries = Country::search(request("search"))
                            ->query(function (Builder $builder) {
                                $builder->with("regions");
                            })
                            ->orderBy(request("sort", "id"), request("direction", "desc"))
                            ->paginate(request("per_page", 10))
                            ->appends(request()->all());

        return inertia("Admin/ShippingAreas/Countries/Index", compact("countries"));
    }

    public function create(): Response|ResponseFactory
    {
        $per_page = request("per_page");

        return inertia("Admin/ShippingAreas/Countries/Create", compact("per_page"));
    }

    public function store(CountryRequest $request): RedirectResponse
    {
        Country::create(["name" => $request->name]);

        return to_route("admin.countries.index", $this->getQueryStringParams($request))->with("success", "COUNTRY_HAS_BEEN_SUCCESSFULLY_CREATED");
    }

    public function edit(Request $request, Country $country): Response|ResponseFactory
    {
        $queryStringParams = $this->getQueryStringParams($request);

        return inertia("Admin/ShippingAreas/Countries/Edit", compact("country", "queryStringParams"));
    }

    public function update(CountryRequest $request, Country $country): RedirectResponse
    {
        $country->update(["name" => $request->name]);

        return to_route("admin.countries.index", $this->getQueryStringParams($request))->with("success", "COUNTRY_HAS_BEEN_SUCCESSFULLY_UPDATED");
    }

    public function destroy(Request $request, Country $country): RedirectResponse
    {
        $country->delete();

        return to_route("admin.countries.index", $this->getQueryStringParams($request))->with("success", "COUNTRY_HAS_BEEN_SUCCESSFULLY_DELETED");
    }

    public function trash(): Response|ResponseFactory
    {
        $trashCountries = Country::search(request("search"))
                                 ->onlyTrashed()
                                 ->orderBy(request("sort", "id"), request("direction", "desc"))
                                 ->paginate(request("per_page", 10))
                                 ->appends(request()->all());

        return inertia("Admin/ShippingAreas/Countries/Trash", compact("trashCountries"));
    }

    public function restore(Request $request, int $trashCountryId): RedirectResponse
    {
        $trashCountry = Country::onlyTrashed()->findOrFail($trashCountryId);

        $trashCountry->restore();

        return to_route('admin.countries.trash', $this->getQueryStringParams($request))->with("success", "COUNTRY_HAS_BEEN_SUCCESSFULLY_RESTORED");
    }


    public function forceDelete(Request $request, int $trashCountryId): RedirectResponse
    {
        $trashCountry = Country::onlyTrashed()->findOrFail($trashCountryId);

        $trashCountry->forceDelete();

        return to_route('admin.countries.trash', $this->getQueryStringParams($request))->with("success", "THE_COUNTRY_HAS_BEEN_PERMANENTLY_DELETED");
    }

    public function permanentlyDelete(Request $request): RedirectResponse
    {
        $trashCountries = Country::onlyTrashed()->get();

        (new PermanentlyDeleteAllTrashCountryAction())->handle($trashCountries);

        return to_route('admin.countries.trash', $this->getQueryStringParams($request))->with("success", "COUNTRIES_HAVE_BEEN_PERMANENTLY_DELETED");
    }
}
