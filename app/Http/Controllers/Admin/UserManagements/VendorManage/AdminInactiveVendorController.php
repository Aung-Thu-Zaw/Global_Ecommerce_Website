<?php

namespace App\Http\Controllers\Admin\UserManagements\VendorManage;

use App\Http\Controllers\Controller;
use App\Models\User;
use Inertia\Response;
use Inertia\ResponseFactory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AdminInactiveVendorController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        $inactiveVendors=User::search(request("search"))
                              ->where("role", "vendor")
                              ->where("status", "inactive")
                              ->orderBy(request("sort", "id"), request("direction", "desc"))
                              ->paginate(request("per_page", 10))
                              ->appends(request()->all());

        return inertia("Admin/UserManagements/VendorManage/InactiveVendors/Index", compact("inactiveVendors"));
    }

    public function show(int $id): Response|ResponseFactory
    {
        $paginate=[ "page"=>request("page"),"per_page"=>request("per_page")];

        $inactiveVendor=User::findOrFail($id);

        return inertia("Admin/UserManagements/VendorManage/InactiveVendors/Details", compact("inactiveVendor", "paginate"));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $inactiveVendor=User::findOrFail($id);

        $inactiveVendor->update(["status"=>"active"]);

        return to_route('admin.vendors.inactive.index', "page=$request->page&per_page=$request->per_page")->with("success", "Vendor has been successfully activated.");
    }

    public function destroy(Request $request, int  $id): RedirectResponse
    {
        $inactiveVendor = User::findOrFail($id);

        $inactiveVendor->delete();

        return to_route('admin.vendors.inactive.index', "page=$request->page&per_page=$request->per_page")->with("success", "The vendor has been successfully moved to the trash.");
    }

    public function trash(): Response|ResponseFactory
    {
        $inactiveTrashVendors=User::search(request("search"))
                                   ->onlyTrashed()
                                   ->where("role", "vendor")
                                   ->where("status", "inactive")
                                   ->orderBy(request("sort", "id"), request("direction", "desc"))
                                   ->paginate(request("per_page", 10))
                                   ->appends(request()->all());

        return inertia("Admin/UserManagements/VendorManage/InactiveVendors/Trash", compact("inactiveTrashVendors"));
    }

    public function restore(Request $request, int $id): RedirectResponse
    {
        $inactiveVendor = User::onlyTrashed()->findOrFail($id);

        $inactiveVendor->restore();

        return to_route('admin.vendors.inactive.trash', "page=$request->page&per_page=$request->per_page")->with("success", "vendor has been successfully restored.");
    }

    public function forceDelete(Request $request, int $id): RedirectResponse
    {
        $inactiveVendor = User::onlyTrashed()->findOrFail($id);

        User::deleteUserAvatar($inactiveVendor);

        $inactiveVendor->forceDelete();

        return to_route('admin.vendors.inactive.trash', "page=$request->page&per_page=$request->per_page")->with("success", "Vendor has been successfully deleted.");
    }

    public function permanentlyDelete(Request $request): RedirectResponse
    {
        $inactiveVendors = User::onlyTrashed()->get();

        $inactiveVendors->each(function ($inactiveVendor) {
            User::deleteUserAvatar($inactiveVendor);
            $inactiveVendor->forceDelete();
        });

        return to_route('admin.vendors.inactive.trash', "page=$request->page&per_page=$request->per_page")->with("success", "Inactive Vendors have been successfully deleted.");
    }
}
