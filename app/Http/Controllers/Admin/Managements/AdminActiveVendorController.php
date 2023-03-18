<?php

namespace App\Http\Controllers\Admin\Managements;

use App\Http\Controllers\Controller;
use App\Http\Resources\ActiveVendorResource;
use App\Models\User;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;

class AdminActiveVendorController extends Controller
{
    public function index(): Response
    {
        $activeVendors=ActiveVendorResource::collection(User::search(request("search"))->where("role", "vendor")->where("status", "active")->paginate(15));

        return inertia("Admin/Managements/Vendors/ActiveVendors/Index", compact("activeVendors"));
    }

    public function show($id): Response
    {
        $activeVendor=new ActiveVendorResource(User::find($id));

        return inertia("Admin/Managements/Vendors/ActiveVendors/Details", compact("activeVendor"));
    }

    public function update($id): RedirectResponse
    {
        $activeVendor=new ActiveVendorResource(User::find($id));

        $activeVendor->update(["status"=>'inactive']);

        return to_route('admin.vendors.active.index')->with("success", "Vendor has been successfully inactivated");
    }
}
