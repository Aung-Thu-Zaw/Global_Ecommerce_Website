<?php

namespace App\Http\Controllers\Admin\Managements;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminInactiveVendorController extends Controller
{
    public function index()
    {
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

        return back();
    }

    public function softDelete($id)
    {
        $inactiveVendor = User::where("id", $id)->first();

        $inactiveVendor->delete();
    }

    public function restore($id)
    {
        $inactiveVendor = User::onlyTrashed()->where("id", $id)->first();

        $inactiveVendor->restore();
    }

    public function forceDelete($id)
    {
        $inactiveVendor = User::onlyTrashed()->where("id", $id)->first();

        $inactiveVendor->forceDelete();
    }

    public function trash()
    {
        $inactiveTrashVendors=User::onlyTrashed()->where([["role","vendor"],["status","inactive"]])->get();

        return inertia("Admin/Managements/Vendors/InactiveVendors/Trash", compact("inactiveTrashVendors"));
    }
}
