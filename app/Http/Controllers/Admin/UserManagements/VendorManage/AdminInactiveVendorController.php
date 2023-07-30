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

    public function show(Request $request, User $user): Response|ResponseFactory
    {
        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return inertia("Admin/UserManagements/VendorManage/InactiveVendors/Details", compact("user", "queryStringParams"));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $user->update(["status"=>"active"]);

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route('admin.vendors.inactive.index', $queryStringParams)->with("success", "Vendor has been successfully activated.");
    }

    public function destroy(Request $request, User $user): RedirectResponse
    {
        $user->delete();

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route('admin.vendors.inactive.index', $queryStringParams)->with("success", "The vendor has been successfully moved to the trash.");
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

    public function restore(Request $request, int $trashInactiveVendorId): RedirectResponse
    {
        $inactiveVendor = User::onlyTrashed()->findOrFail($trashInactiveVendorId);

        $inactiveVendor->restore();

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route('admin.vendors.inactive.trash', $queryStringParams)->with("success", "vendor has been successfully restored.");
    }

    public function forceDelete(Request $request, int $trashInactiveVendorId): RedirectResponse
    {
        $inactiveVendor = User::onlyTrashed()->findOrFail($trashInactiveVendorId);

        User::deleteUserAvatar($inactiveVendor->avatar);

        $inactiveVendor->forceDelete();

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route('admin.vendors.inactive.trash', $queryStringParams)->with("success", "Vendor has been successfully deleted.");
    }

    public function permanentlyDelete(Request $request): RedirectResponse
    {
        $inactiveVendors = User::onlyTrashed()->get();

        $inactiveVendors->each(function ($inactiveVendor) {

            User::deleteUserAvatar($inactiveVendor->avatar);

            $inactiveVendor->forceDelete();

        });

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route('admin.vendors.inactive.trash', $queryStringParams)->with("success", "Inactive Vendors have been successfully deleted.");
    }
}
