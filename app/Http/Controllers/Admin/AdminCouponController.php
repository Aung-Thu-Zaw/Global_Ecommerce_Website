<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\Coupons\CreateCouponAction;
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

        return to_route("admin.coupons.index", $queryStringParams)->with("success", "Coupon has been successfully created.");
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

        return to_route("admin.coupons.index", $queryStringParams)->with("success", "Coupon has been successfully updated.");
    }

    public function destroy(Request $request, Coupon $coupon): RedirectResponse
    {
        $coupon->delete();

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route("admin.coupons.index", $queryStringParams)->with("success", "Coupon has been successfully deleted.");
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
        $coupon =Coupon::onlyTrashed()->findOrFail($trashCouponId);

        $coupon->restore();

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route('admin.coupons.trash', $queryStringParams)->with("success", "Coupon has been successfully restored.");
    }

    public function forceDelete(Request $request, int $trashCouponId): RedirectResponse
    {
        $coupon = Coupon::onlyTrashed()->findOrFail($trashCouponId);

        $coupon->forceDelete();

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route('admin.coupons.trash', $queryStringParams)->with("success", "The coupon has been permanently deleted.");
    }

    public function permanentlyDelete(Request $request): RedirectResponse
    {
        $coupons = Coupon::onlyTrashed()->get();

        $coupons->each(function ($coupon) {

            $coupon->forceDelete();

        });

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route('admin.coupons.trash', $queryStringParams)->with("success", "Coupons have been successfully deleted.");
    }
}
