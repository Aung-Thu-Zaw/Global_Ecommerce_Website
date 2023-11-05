<?php

namespace App\Http\Controllers\Admin\ShippingAreas;

use App\Actions\Admin\ShippingAreas\PermanentlyDeleteAllTrashRegionAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegionRequest;
use App\Http\Traits\HandlesQueryStringParameters;
use App\Models\Country;
use App\Models\Region;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\ResponseFactory;

class AdminRegionController extends Controller
{
    use HandlesQueryStringParameters;

    public function index(): Response|ResponseFactory
    {
        $regions = Region::search(request('search'))
                         ->query(function (Builder $builder) {
                             $builder->with(['cities', 'country']);
                         })
                         ->orderBy(request('sort', 'id'), request('direction', 'desc'))
                         ->paginate(request('per_page', 10))
                         ->appends(request()->all());

        return inertia('Admin/ShippingAreas/Regions/Index', compact('regions'));
    }

    public function create(): Response|ResponseFactory
    {
        $per_page = request('per_page');

        $countries = Country::all();

        return inertia('Admin/ShippingAreas/Regions/Create', compact('per_page', 'countries'));
    }

    public function store(RegionRequest $request): RedirectResponse
    {
        Region::create(['name' => $request->name, 'country_id' => $request->country_id]);

        return to_route('admin.regions.index', $this->getQueryStringParams($request))->with('success', 'REGION_HAS_BEEN_SUCCESSFULLY_CREATED');
    }

    public function edit(Request $request, Region $region): Response|ResponseFactory
    {
        $countries = Country::all();

        $queryStringParams = $this->getQueryStringParams($request);

        return inertia('Admin/ShippingAreas/Regions/Edit', compact('region', 'countries', 'queryStringParams'));
    }

    public function update(RegionRequest $request, Region $region): RedirectResponse
    {
        $region->update(['name' => $request->name, 'country_id' => $request->country_id]);

        return to_route('admin.regions.index', $this->getQueryStringParams($request))->with('success', 'REGION_HAS_BEEN_SUCCESSFULLY_UPDATED');
    }

    public function destroy(Request $request, Region $region): RedirectResponse
    {
        $region->delete();

        return to_route('admin.regions.index', $this->getQueryStringParams($request))->with('success', 'REGION_HAS_BEEN_SUCCESSFULLY_DELETED');
    }

    public function trash(): Response|ResponseFactory
    {
        $trashRegions = Region::search(request('search'))
                              ->onlyTrashed()
                              ->orderBy(request('sort', 'id'), request('direction', 'desc'))
                              ->paginate(request('per_page', 10))
                              ->appends(request()->all());

        return inertia('Admin/ShippingAreas/Regions/Trash', compact('trashRegions'));
    }

    public function restore(Request $request, int $trashRegionId): RedirectResponse
    {
        $trashRegion = Region::onlyTrashed()->findOrFail($trashRegionId);

        $trashRegion->restore();

        return to_route('admin.regions.trash', $this->getQueryStringParams($request))->with('success', 'REGION_HAS_BEEN_SUCCESSFULLY_RESTORED');
    }

    public function forceDelete(Request $request, int $trashRegionId): RedirectResponse
    {
        $trashRegion = Region::onlyTrashed()->findOrFail($trashRegionId);

        $trashRegion->forceDelete();

        return to_route('admin.regions.trash', $this->getQueryStringParams($request))->with('success', 'THE_REGION_HAS_BEEN_PERMANENTLY_DELETED');
    }

    public function permanentlyDelete(Request $request): RedirectResponse
    {
        $trashRegions = Region::onlyTrashed()->get();

        (new PermanentlyDeleteAllTrashRegionAction())->handle($trashRegions);

        return to_route('admin.regions.trash', $this->getQueryStringParams($request))->with('success', 'REGIONS_HAVE_BEEN_PERMANENTLY_DELETED');
    }
}
