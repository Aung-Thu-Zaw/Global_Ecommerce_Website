<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\Coupons\CreateCouponAction;
use App\Actions\Admin\Coupons\PermanentlyDeleteAllTrashCouponAction;
use App\Actions\Admin\Coupons\UpdateCouponAction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\CouponRequest;
use App\Models\Coupon;
use Inertia\Response;
use Inertia\ResponseFactory;
use Illuminate\Http\RedirectResponse;

class AdminCouponController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        $coupons=Coupon::search(request("search"))
                       ->orderBy(request("sort", "id"), request("direction", "desc"))
                       ->paginate(request("per_page", 10))
                       ->appends(request()->all());

        return inertia("Admin/Coupons/Index", compact("coupons"));
    }

    public function create(): Response|ResponseFactory
    {
        $per_page=request("per_page");

        return inertia("Admin/Coupons/Create", compact("per_page"));
    }

    public function store(CouponRequest $request): RedirectResponse
    {
        (new CreateCouponAction())->handle($request->validated());

        $queryStringParams=["page"=>"1","per_page"=>$request->per_page,"sort"=>"id","direction"=>"desc"];

        return to_route("admin.coupons.index", $queryStringParams)->with("success", "COUPON_HAS_BEEN_SUCCESSFULLY_CREATED");
    }

    public function edit(Request $request, Coupon $coupon): Response|ResponseFactory
    {
        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return inertia("Admin/Coupons/Edit", compact("coupon", "queryStringParams"));
    }

    public function update(CouponRequest $request, Coupon $coupon): RedirectResponse
    {
        (new UpdateCouponAction())->handle($request->validated(), $coupon);

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route("admin.coupons.index", $queryStringParams)->with("success", "COUPON_HAS_BEEN_SUCCESSFULLY_UPDATED");
    }

    public function destroy(Request $request, Coupon $coupon): RedirectResponse
    {
        $coupon->delete();

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route("admin.coupons.index", $queryStringParams)->with("success", "COUPON_HAS_BEEN_SUCCESSFULLY_DELETED");
    }

    public function trash(): Response|ResponseFactory
    {
        $trashCoupons=Coupon::search(request("search"))
                            ->onlyTrashed()
                            ->orderBy(request("sort", "id"), request("direction", "desc"))
                            ->paginate(request("per_page", 10))
                            ->appends(request()->all());

        return inertia("Admin/Coupons/Trash", compact("trashCoupons"));
    }

    public function restore(Request $request, int $trashCouponId): RedirectResponse
    {
        $trashCoupon=Coupon::onlyTrashed()->findOrFail($trashCouponId);

        $trashCoupon->restore();

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route('admin.coupons.trash', $queryStringParams)->with("success", "COUPON_HAS_BEEN_SUCCESSFULLY_RESTORED");
    }

    public function forceDelete(Request $request, int $trashCouponId): RedirectResponse
    {
        $trashCoupon= Coupon::onlyTrashed()->findOrFail($trashCouponId);

        $trashCoupon->forceDelete();

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route('admin.coupons.trash', $queryStringParams)->with("success", "THE_COUPON_HAS_BEEN_PERMANENTLY_DELETED");
    }

    public function permanentlyDelete(Request $request): RedirectResponse
    {
        $trashCoupon = Coupon::onlyTrashed()->get();

        (new PermanentlyDeleteAllTrashCouponAction())->handle($trashCoupon);

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route('admin.coupons.trash', $queryStringParams)->with("success", "COUPONS_HAVE_BEEN_PERMANENTLY_DELETED");
    }
}
