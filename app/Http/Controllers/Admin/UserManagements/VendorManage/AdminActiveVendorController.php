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

    public function show(int $id): Response|ResponseFactory
    {
        $paginate=[ "page"=>request("page"),"per_page"=>request("per_page")];

        $activeVendor=User::findOrFail($id);

        return inertia("Admin/UserManagements/VendorManage/ActiveVendors/Details", compact("activeVendor", "paginate"));
    }

    public function update(Request $request, int $id): RedirectResponse
    {

        $activeVendor=User::findOrFail($id);

        $message="";


        if($request->status==="inactive") {

            $activeVendor->update(["status"=>'inactive']);
            $message="Vendor has been successfully inactivated";
        } elseif ($request->offical==1) {


            $activeVendor->update(["offical"=>true]);
            $message= "Vendor has been successfully set offical";
        } elseif ($request->offical==0) {

            $activeVendor->update(["offical"=>false]);
            $message= "Vendor has been successfully set unoffical";
        }

        return to_route('admin.vendors.active.index', "page=$request->page&per_page=$request->per_page")->with("success", $message);


    }
}
