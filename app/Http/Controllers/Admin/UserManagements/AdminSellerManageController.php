<?php

namespace App\Http\Controllers\Admin\UserManagements;

use App\Actions\Admin\UserManagements\PermanentlyDeleteAllTrashUserAction;
use App\Http\Controllers\Controller;
use App\Models\User;
use Inertia\Response;
use Inertia\ResponseFactory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AdminSellerManageController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        $sellers=User::search(request("search"))
                     ->where("role", "seller")
                     ->orderBy(request("sort", "id"), request("direction", "desc"))
                     ->paginate(request("per_page", 10))
                     ->appends(request()->all());

        return inertia("Admin/UserManagements/SellerManage/Index", compact("sellers"));
    }

    public function show(Request $request, User $user): Response|ResponseFactory
    {
        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return inertia("Admin/UserManagements/SellerManage/Details", compact("user", "queryStringParams"));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $user->update(["status"=>$request->status]);

        $message=$request->status==="inactive" ? "Seller has been successfully inactive" : "Seller has been successfully active";

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route('admin.seller-manage.index', $queryStringParams)->with("success", $message);
    }

    public function destroy(Request $request, User $user): RedirectResponse
    {
        $user->delete();

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route('admin.seller-manage.index', $queryStringParams)->with("success", "The seller has been successfully moved to the trash.");
    }

    public function trash(): Response|ResponseFactory
    {
        $trashSellers=User::search(request("search"))
                          ->onlyTrashed()
                          ->where("role", "seller")
                          ->orderBy(request("sort", "id"), request("direction", "desc"))
                          ->paginate(request("per_page", 10))
                          ->appends(request()->all());

        return inertia("Admin/UserManagements/SellerManage/Trash", compact("trashSellers"));
    }

    public function restore(Request $request, int $trashSellerId): RedirectResponse
    {
        $trashSeller=User::onlyTrashed()->findOrFail($trashSellerId);

        $trashSeller->restore();

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route('admin.seller-manage.trash', $queryStringParams)->with("success", "seller has been successfully restored.");
    }

    public function forceDelete(Request $request, int $trashSellerId): RedirectResponse
    {
        $trashSeller=User::onlyTrashed()->findOrFail($trashSellerId);

        User::deleteUserAvatar($trashSeller->avatar);

        $trashSeller->forceDelete();

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route('admin.seller-manage.trash', $queryStringParams)->with("success", "Seller has been successfully deleted.");
    }

    public function permanentlyDelete(Request $request): RedirectResponse
    {
        $trashSellers = User::onlyTrashed()->where("role", "seller")->get();

        (new PermanentlyDeleteAllTrashUserAction())->handle($trashSellers);

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route('admin.seller-manage.trash', $queryStringParams)->with("success", "Sellers have been successfully deleted.");
    }
}
