<?php

namespace App\Http\Controllers\Admin;

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
        Coupon::create($request->validated());

        return to_route("admin.coupons.index", "per_page=$request->per_page")->with("success", "Coupon has been successfully created.");
    }

    public function edit(Coupon $coupon): Response|ResponseFactory
    {
        $paginate=[ "page"=>request("page"),"per_page"=>request("per_page")];

        return inertia("Admin/Coupons/Edit", compact("coupon", "paginate"));
    }

    public function update(CouponRequest $request, Coupon $coupon): RedirectResponse
    {
        $coupon->update($request->validated());

        return to_route("admin.coupons.index", "page=$request->page&per_page=$request->per_page")->with("success", "Coupon has been successfully updated.");
    }

    public function destroy(Request $request, Coupon $coupon): RedirectResponse
    {
        $coupon->delete();

        return to_route("admin.coupons.index", "page=$request->page&per_page=$request->per_page")->with("success", "Coupon has been successfully deleted.");
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

    public function restore(Request $request, int $id): RedirectResponse
    {
        $coupon =Coupon::onlyTrashed()->where("id", $id)->first();

        $coupon->restore();

        return to_route('admin.coupons.trash', "page=$request->page&per_page=$request->per_page")->with("success", "Coupon has been successfully restored.");
    }

    public function forceDelete(Request $request, int $id): RedirectResponse
    {
        $coupon = Coupon::onlyTrashed()->where("id", $id)->first();

        $coupon->forceDelete();

        return to_route('admin.coupons.trash', "page=$request->page&per_page=$request->per_page")->with("success", "The coupon has been permanently deleted");
    }

    public function permanentlyDelete(Request $request): RedirectResponse
    {
        $coupons = Coupon::onlyTrashed()->get();

        $coupons->each(function ($coupon) {
            $coupon->forceDelete();
        });

        return to_route('admin.coupons.trash', "page=$request->page&per_page=$request->per_page")->with("success", "Coupons have been successfully deleted.");
    }
}
