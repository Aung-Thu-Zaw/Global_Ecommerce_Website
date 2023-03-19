<?php

namespace App\Http\Controllers\Admin\Managements;

use App\Http\Controllers\Controller;
use App\Models\User;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AdminActiveVendorController extends Controller
{
    public function index(): Response
    {
        $activeVendors=User::search(request("search"))->where("role", "vendor")->where("status", "active")->paginate(request("per_page", 10))->withQueryString();

        return inertia("Admin/Managements/Vendors/ActiveVendors/Index", compact("activeVendors"));
    }

    public function show($id): Response
    {
        $paginate=[ "page"=>request("page"),"per_page"=>request("per_page")];

        $activeVendor=User::find($id);

        return inertia("Admin/Managements/Vendors/ActiveVendors/Details", compact("activeVendor", "paginate"));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $activeVendor=User::find($id);

        $activeVendor->update(["status"=>'inactive']);

        return to_route('admin.vendors.active.index', "page=$request->page&per_page=$request->per_page")->with("success", "Vendor has been successfully inactivated");
    }
}
