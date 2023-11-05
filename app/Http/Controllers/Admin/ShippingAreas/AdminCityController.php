<?php

namespace App\Http\Controllers\Admin\ShippingAreas;

use App\Actions\Admin\ShippingAreas\PermanentlyDeleteAllTrashCityAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\CityRequest;
use App\Http\Traits\HandlesQueryStringParameters;
use App\Models\City;
use App\Models\Country;
use App\Models\Region;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\ResponseFactory;

class AdminCityController extends Controller
{
    use HandlesQueryStringParameters;

    public function index(): Response|ResponseFactory
    {
        $cities = City::search(request('search'))
                      ->query(function (Builder $builder) {
                          $builder->with(['region.country', 'townships']);
                      })
                      ->orderBy(request('sort', 'id'), request('direction', 'desc'))
                      ->paginate(request('per_page', 10))
                      ->appends(request()->all());

        return inertia('Admin/ShippingAreas/Cities/Index', compact('cities'));
    }

    public function create(): Response|ResponseFactory
    {
        $per_page = request('per_page');

        $countries = Country::all();

        $regions = Region::all();

        return inertia('Admin/ShippingAreas/Cities/Create', compact('per_page', 'countries', 'regions'));
    }

    public function store(CityRequest $request): RedirectResponse
    {
        City::create(['name' => $request->name, 'region_id' => $request->region_id]);

        return to_route('admin.cities.index', $this->getQueryStringParams($request))->with('success', 'CITY_HAS_BEEN_SUCCESSFULLY_CREATED');
    }

    public function edit(Request $request, City $city): Response|ResponseFactory
    {
        $countries = Country::all();

        $regions = Region::all();

        $city->load(['region.country']);

        $queryStringParams = $this->getQueryStringParams($request);

        return inertia('Admin/ShippingAreas/Cities/Edit', compact('city', 'queryStringParams', 'countries', 'regions'));
    }

    public function update(CityRequest $request, City $city): RedirectResponse
    {
        $city->update(['name' => $request->name, 'region_id' => $request->region_id]);

        return to_route('admin.cities.index', $this->getQueryStringParams($request))->with('success', 'CITY_HAS_BEEN_SUCCESSFULLY_UPDATED');
    }

    public function destroy(Request $request, City $city): RedirectResponse
    {
        $city->delete();

        return to_route('admin.cities.index', $this->getQueryStringParams($request))->with('success', 'CITY_HAS_BEEN_SUCCESSFULLY_DELETED');
    }

    public function trash(): Response|ResponseFactory
    {
        $trashCities = City::search(request('search'))
                           ->onlyTrashed()
                           ->orderBy(request('sort', 'id'), request('direction', 'desc'))
                           ->paginate(request('per_page', 10))
                           ->appends(request()->all());

        return inertia('Admin/ShippingAreas/Cities/Trash', compact('trashCities'));
    }

    public function restore(Request $request, int $trashCityId): RedirectResponse
    {
        $trashCity = City::onlyTrashed()->findOrFail($trashCityId);

        $trashCity->restore();

        return to_route('admin.cities.trash', $this->getQueryStringParams($request))->with('success', 'CITY_HAS_BEEN_SUCCESSFULLY_RESTORED');
    }

    public function forceDelete(Request $request, int $trashCityId): RedirectResponse
    {
        $trashCity = City::onlyTrashed()->findOrFail($trashCityId);

        $trashCity->forceDelete();

        return to_route('admin.cities.trash', $this->getQueryStringParams($request))->with('success', 'THE_CITY_HAS_BEEN_PERMANENTLY_DELETED');
    }

    public function permanentlyDelete(Request $request): RedirectResponse
    {
        $trashCities = City::onlyTrashed()->get();

        (new PermanentlyDeleteAllTrashCityAction())->handle($trashCities);

        return to_route('admin.cities.trash', $this->getQueryStringParams($request))->with('success', 'CITIES_HAVE_BEEN_PERMANENTLY_DELETED');
    }
}
