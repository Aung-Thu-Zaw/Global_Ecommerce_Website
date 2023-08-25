<?php

namespace App\Http\Controllers\Admin\UserManagements;

use App\Http\Controllers\Controller;
use Inertia\Response;
use Inertia\ResponseFactory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\User;
use App\Actions\Admin\UserManagements\PermanentlyDeleteAllTrashUserAction;
use App\Http\Traits\HandlesQueryStringParameters;

class AdminSellerManageController extends Controller
{
    use HandlesQueryStringParameters;

    public function index(): Response|ResponseFactory
    {
        $sellers = User::filterBy(request(["search","created_from","created_until"]))
                       ->where("role", "seller")
                       ->orderBy(request("sort", "id"), request("direction", "desc"))
                       ->paginate(request("per_page", 10))
                       ->appends(request()->all());

        return inertia("Admin/UserManagements/SellerManage/Index", compact("sellers"));
    }

    public function show(Request $request, User $user): Response|ResponseFactory
    {
        $queryStringParams = $this->getQueryStringParams($request);

        return inertia("Admin/UserManagements/SellerManage/Detail", compact("user", "queryStringParams"));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $user->update(["status" => $request->status]);

        $message = $request->status === "inactive" ? "SELLER_HAS_BEEN_SUCCESSFULLY_INACTIVE" : "SELLER_HAS_BEEN_SUCCESSFULLY_ACTIVE";

        return to_route('admin.seller-manage.index', $this->getQueryStringParams($request))->with("success", $message);
    }

    public function destroy(Request $request, User $user): RedirectResponse
    {
        $user->delete();

        return to_route('admin.seller-manage.index', $this->getQueryStringParams($request))->with("success", "SELLER_HAS_BEEN_SUCCESSFULLY_DELETED");
    }

    public function trash(): Response|ResponseFactory
    {
        $trashSellers = User::filterBy(request(["search","deleted_from","deleted_until"]))
                            ->onlyTrashed()
                            ->where("role", "seller")
                            ->orderBy(request("sort", "id"), request("direction", "desc"))
                            ->paginate(request("per_page", 10))
                            ->appends(request()->all());

        return inertia("Admin/UserManagements/SellerManage/Trash", compact("trashSellers"));
    }

    public function restore(Request $request, int $trashSellerId): RedirectResponse
    {
        $trashSeller = User::onlyTrashed()->findOrFail($trashSellerId);

        $trashSeller->restore();

        return to_route('admin.seller-manage.trash', $this->getQueryStringParams($request))->with("success", "SELLER_HAS_BEEN_SUCCESSFULLY_RESTORED");
    }

    public function forceDelete(Request $request, int $trashSellerId): RedirectResponse
    {
        $trashSeller = User::onlyTrashed()->findOrFail($trashSellerId);

        User::deleteUserAvatar($trashSeller->avatar);

        $trashSeller->forceDelete();

        return to_route('admin.seller-manage.trash', $this->getQueryStringParams($request))->with("success", "THE_SELLER_HAS_BEEN_PERMANENTLY_DELETED");
    }

    public function permanentlyDelete(Request $request): RedirectResponse
    {
        $trashSellers = User::onlyTrashed()->where("role", "seller")->get();

        (new PermanentlyDeleteAllTrashUserAction())->handle($trashSellers);

        return to_route('admin.seller-manage.trash', $this->getQueryStringParams($request))->with("success", "SELLERS_HAVE_BEEN_PERMANENTLY_DELETED");
    }
}
