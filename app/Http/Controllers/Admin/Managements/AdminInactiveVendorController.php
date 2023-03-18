<?php

namespace App\Http\Controllers\Admin\Managements;

use App\Http\Controllers\Controller;
use App\Http\Resources\VendorResource;
use App\Models\User;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;

class AdminInactiveVendorController extends Controller
{
    public function index(): Response
    {
        $inactiveVendors=User::search(request("search"))->where("role", "vendor")->where("status", "inactive")->paginate(request("per_page", 10))->withQueryString();

        return inertia("Admin/Managements/Vendors/InactiveVendors/Index", compact("inactiveVendors"));
    }

    public function show($id): Response
    {
        $inactiveVendor=User::find($id);

        return inertia("Admin/Managements/Vendors/InactiveVendors/Details", compact("inactiveVendor"));
    }

    public function update($id): RedirectResponse
    {
        $inactiveVendor=User::find($id);

        $inactiveVendor->update(["status"=>"active"]);

        return to_route('admin.vendors.inactive.index')->with("success", "Vendor activated successfully.");
    }

    public function destroy($id): RedirectResponse
    {
        $inactiveVendor = User::find($id);

        $inactiveVendor->delete();

        return to_route('admin.vendors.inactive.index')->with("success", "The vendor has been successfully moved to the trash.");
    }

    public function trash(): Response
    {
        $inactiveTrashVendors=User::search(request("search"))->onlyTrashed()->where("role", "vendor")->where("status", "inactive")->paginate(request("per_page", 10))->withQueryString();

        return inertia("Admin/Managements/Vendors/InactiveVendors/Trash", compact("inactiveTrashVendors"));
    }

    public function restore($id): RedirectResponse
    {
        $inactiveVendor = User::onlyTrashed()->where("id", $id)->first();

        $inactiveVendor->restore();

        return to_route('admin.vendors.inactive.trash')->with("success", "You have successfully restored the vendor.");
    }

    public function forceDelete($id): RedirectResponse
    {
        $inactiveVendor = User::onlyTrashed()->where("id", $id)->first();

        $inactiveVendor->forceDelete();

        return to_route('admin.vendors.inactive.trash')->with("success", "You have successfully deleted the vendor.");
    }
}
