<?php

namespace App\Http\Controllers\Admin\Managements;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminActiveVendorController extends Controller
{
    public function index()
    {
        $search=request("search");
        $activeVendors=User::where([["role","vendor"],["status", "active"]])->orderBy("id", "desc")->paginate(15);

        return inertia("Admin/Managements/Vendors/ActiveVendors/Index", compact("activeVendors"));
    }

    public function show($id)
    {
        $activeVendor=User::where("id", $id)->first();

        return inertia("Admin/Managements/Vendors/ActiveVendors/Details", compact("activeVendor"));
    }

    public function update(Request $request, $id)
    {
        $activeVendor=User::where("id", $id)->first();

        $activeVendor->status="inactive";

        $activeVendor->update();

        return back();
    }
}
