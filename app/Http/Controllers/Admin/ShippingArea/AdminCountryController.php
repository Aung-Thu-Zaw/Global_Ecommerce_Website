<?php

namespace App\Http\Controllers\Admin\ShippingArea;

use App\Http\Controllers\Controller;
use App\Http\Requests\CountryRequest;
use App\Models\Country;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\ResponseFactory;
use Illuminate\Database\Eloquent\Builder;

class AdminCountryController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        $countries=Country::search(request("search"))
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
        $per_page=request("per_page");

        return inertia("Admin/ShippingAreas/Countries/Create", compact("per_page"));
    }

    public function store(CountryRequest $request): RedirectResponse
    {

        Country::create($request->validated());

        return to_route("admin.countries.index", "per_page=$request->per_page")->with("success", "Country has been successfully created.");
    }

    public function edit(Country $country): Response|ResponseFactory
    {
        $paginate=[ "page"=>request("page"),"per_page"=>request("per_page")];

        return inertia("Admin/ShippingAreas/Countries/Edit", compact("country", "paginate"));
    }

    public function update(CountryRequest $request, Country $country): RedirectResponse
    {

        $country->update($request->validated());

        return to_route("admin.countries.index", "page=$request->page&per_page=$request->per_page&sort=$request->sort&direction=$request->direction")->with("success", "Country has been successfully updated.");
    }

    public function destroy(Request $request, Country $country): RedirectResponse
    {
        $country->delete();

        return to_route("admin.countries.index", "page=$request->page&per_page=$request->per_page&sort=$request->sort&direction=$request->direction")->with("success", "Country has been successfully deleted.");
    }

    public function trash(): Response|ResponseFactory
    {
        $trashCountries=Country::search(request("search"))
                                ->onlyTrashed()
                                ->orderBy(request("sort", "id"), request("direction", "desc"))
                                ->paginate(request("per_page", 10))
                                ->appends(request()->all());

        return inertia("Admin/ShippingAreas/Countries/Trash", compact("trashCountries"));
    }

    public function restore(Request $request, int $id): RedirectResponse
    {
        $country = Country::onlyTrashed()->findOrFail($id);

        $country->restore();

        return to_route('admin.countries.trash', "page=$request->page&per_page=$request->per_page&sort=$request->sort&direction=$request->direction")->with("success", "Country has been successfully restored.");
    }

    public function forceDelete(Request $request, int $id): RedirectResponse
    {
        $country = Country::onlyTrashed()->findOrFail($id);

        $country->forceDelete();

        return to_route('admin.countries.trash', "page=$request->page&per_page=$request->per_page&sort=$request->sort&direction=$request->direction")->with("success", "The country has been permanently deleted.");
    }

    public function permanentlyDelete(Request $request): RedirectResponse
    {
        $countries = Country::onlyTrashed()->get();

        $countries->each(function ($country) {
            $country->forceDelete();
        });

        return to_route('admin.countries.trash', "page=$request->page&per_page=$request->per_page&sort=$request->sort&direction=$request->direction")->with("success", "Countries have been successfully deleted.");
    }
}
