<?php

namespace App\Http\Controllers\Admin\Managements;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminInactiveVendorController extends Controller
{
    public function index()
    {
        $search=request("search");
        $inactiveVendors=User::where([["role","vendor"],["status", "inactive"]])->orderBy("id", "desc")->paginate(15);

        return inertia("Admin/Managements/Vendors/InactiveVendors/Index", compact("inactiveVendors"));
    }

    public function show($id)
    {
        $inactiveVendor=User::where("id", $id)->first();

        return inertia("Admin/Managements/Vendors/InactiveVendors/Details", compact("inactiveVendor"));
    }

    public function update(Request $request, $id)
    {
        $inactiveVendor=User::where("id", $id)->first();

        $inactiveVendor->status="active";

        $inactiveVendor->update();

        return to_route('admin.vendors.inactive.index')->with("success", "Vendor activated successfully.");
    }

    public function softDelete($id)
    {
        $inactiveVendor = User::where("id", $id)->first();

        $inactiveVendor->delete();

        return to_route('admin.vendors.inactive.index')->with("success", "The vendor has been successfully moved to the trash.");
    }

    public function restore($id)
    {
        $inactiveVendor = User::onlyTrashed()->where("id", $id)->first();

        $inactiveVendor->restore();

        return to_route('admin.vendors.inactive.trash')->with("success", "You have successfully restored the vendor.");
    }

    public function forceDelete($id)
    {
        $inactiveVendor = User::onlyTrashed()->where("id", $id)->first();

        $inactiveVendor->forceDelete();

        return to_route('admin.vendors.inactive.trash')->with("success", "You have successfully deleted the vendor.");
    }

    public function trash()
    {
        $inactiveTrashVendors=User::onlyTrashed()->where([["role","vendor"],["status","inactive"]])->paginate(15);

        return inertia("Admin/Managements/Vendors/InactiveVendors/Trash", compact("inactiveTrashVendors"));
    }
}
