<?php

namespace App\Http\Controllers\Admin\UserManagements\VendorManage;

use App\Http\Controllers\Controller;
use App\Models\User;
use Inertia\Response;
use Inertia\ResponseFactory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AdminActiveVendorController extends Controller
{
    public function index(): Response|ResponseFactory
    {

        $activeVendors=User::search(request("search"))
                           ->where("role", "vendor")
                           ->where("status", "active")
                           ->orderBy(request("sort", "id"), request("direction", "desc"))
                           ->paginate(request("per_page", 10))
                           ->appends(request()->all());

        return inertia("Admin/UserManagements/VendorManage/ActiveVendors/Index", compact("activeVendors"));
    }

    public function show(Request $request, User $user): Response|ResponseFactory
    {
        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return inertia("Admin/UserManagements/VendorManage/ActiveVendors/Details", compact("user", "queryStringParams"));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $message="";

        if($request->status==="inactive") {

            $user->update(["status"=>'inactive']);
            $message="Vendor has been successfully inactivated";

        } elseif ($request->offical==1) {

            $user->update(["offical"=>true]);
            $message= "Vendor has been successfully set offical";

        } elseif ($request->offical==0) {

            $user->update(["offical"=>false]);
            $message= "Vendor has been successfully set unoffical";
        }

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route('admin.vendors.active.index', $queryStringParams)->with("success", $message);
    }
}
