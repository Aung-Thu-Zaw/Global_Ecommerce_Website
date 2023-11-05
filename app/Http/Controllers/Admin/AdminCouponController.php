<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\Coupons\CreateCouponAction;
use App\Actions\Admin\Coupons\PermanentlyDeleteAllTrashCouponAction;
use App\Actions\Admin\Coupons\UpdateCouponAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\CouponRequest;
use App\Http\Traits\HandlesQueryStringParameters;
use App\Models\Coupon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\ResponseFactory;

class AdminCouponController extends Controller
{
    use HandlesQueryStringParameters;

    public function index(): Response|ResponseFactory
    {
        $coupons = Coupon::search(request('search'))
                         ->orderBy(request('sort', 'id'), request('direction', 'desc'))
                         ->paginate(request('per_page', 10))
                         ->appends(request()->all());

        return inertia('Admin/Coupons/Index', compact('coupons'));
    }

    public function create(): Response|ResponseFactory
    {
        $per_page = request('per_page');

        return inertia('Admin/Coupons/Create', compact('per_page'));
    }

    public function store(CouponRequest $request): RedirectResponse
    {
        (new CreateCouponAction())->handle($request->validated());

        return to_route('admin.coupons.index', $this->getQueryStringParams($request))->with('success', 'COUPON_HAS_BEEN_SUCCESSFULLY_CREATED');
    }

    public function edit(Request $request, Coupon $coupon): Response|ResponseFactory
    {
        $queryStringParams = $this->getQueryStringParams($request);

        return inertia('Admin/Coupons/Edit', compact('coupon', 'queryStringParams'));
    }

    public function update(CouponRequest $request, Coupon $coupon): RedirectResponse
    {
        (new UpdateCouponAction())->handle($request->validated(), $coupon);

        return to_route('admin.coupons.index', $this->getQueryStringParams($request))->with('success', 'COUPON_HAS_BEEN_SUCCESSFULLY_UPDATED');
    }

    public function destroy(Request $request, Coupon $coupon): RedirectResponse
    {
        $coupon->delete();

        return to_route('admin.coupons.index', $this->getQueryStringParams($request))->with('success', 'COUPON_HAS_BEEN_SUCCESSFULLY_DELETED');
    }

    public function trash(): Response|ResponseFactory
    {
        $trashCoupons = Coupon::search(request('search'))
                              ->onlyTrashed()
                              ->orderBy(request('sort', 'id'), request('direction', 'desc'))
                              ->paginate(request('per_page', 10))
                              ->appends(request()->all());

        return inertia('Admin/Coupons/Trash', compact('trashCoupons'));
    }

    public function restore(Request $request, int $trashCouponId): RedirectResponse
    {
        $trashCoupon = Coupon::onlyTrashed()->findOrFail($trashCouponId);

        $trashCoupon->restore();

        return to_route('admin.coupons.trash', $this->getQueryStringParams($request))->with('success', 'COUPON_HAS_BEEN_SUCCESSFULLY_RESTORED');
    }

    public function forceDelete(Request $request, int $trashCouponId): RedirectResponse
    {
        $trashCoupon = Coupon::onlyTrashed()->findOrFail($trashCouponId);

        $trashCoupon->forceDelete();

        return to_route('admin.coupons.trash', $this->getQueryStringParams($request))->with('success', 'THE_COUPON_HAS_BEEN_PERMANENTLY_DELETED');
    }

    public function permanentlyDelete(Request $request): RedirectResponse
    {
        $trashCoupon = Coupon::onlyTrashed()->get();

        (new PermanentlyDeleteAllTrashCouponAction())->handle($trashCoupon);

        return to_route('admin.coupons.trash', $this->getQueryStringParams($request))->with('success', 'COUPONS_HAVE_BEEN_PERMANENTLY_DELETED');
    }
}
