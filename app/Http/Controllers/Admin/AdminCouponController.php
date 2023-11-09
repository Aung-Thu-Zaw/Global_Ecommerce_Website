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

    public function __construct()
    {
        $this->middleware('permission:coupons.view', ['only' => ['index']]);
        $this->middleware('permission:coupons.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:coupons.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:coupons.delete', ['only' => ['destroy', 'destroySelected']]);
        $this->middleware('permission:coupons.view.trash', ['only' => ['trashed']]);
        $this->middleware('permission:coupons.restore', ['only' => ['restore', 'restoreSelected']]);
        $this->middleware('permission:coupons.force.delete', ['only' => ['forceDelete', 'forceDeleteSelected', 'forceDeleteAll']]);
    }

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
        return inertia('Admin/Coupons/Create');
    }

    public function store(CouponRequest $request): RedirectResponse
    {
        (new CreateCouponAction())->handle($request->validated());

        return to_route('admin.coupons.index', $this->getQueryStringParams($request))->with('success', ':label has been successfully created.');
    }

    public function edit(Request $request, Coupon $coupon): Response|ResponseFactory
    {
        return inertia('Admin/Coupons/Edit', compact('coupon'));
    }

    public function update(CouponRequest $request, Coupon $coupon): RedirectResponse
    {
        (new UpdateCouponAction())->handle($request->validated(), $coupon);

        return to_route('admin.coupons.index', $this->getQueryStringParams($request))->with('success', ':label has been successfully updated.');
    }

    public function destroy(Request $request, Coupon $coupon): RedirectResponse
    {
        $coupon->delete();

        return to_route('admin.coupons.index', $this->getQueryStringParams($request))->with('success', ':label has been successfully deleted.');
    }

    public function destroySelected(Request $request): RedirectResponse
    {
        if (!empty($request->selectedItems)) {
            Coupon::whereIn('id', $request->selectedItems)->delete();
        }

        return to_route('admin.coupons.index', $this->getQueryStringParams($request))->with('success', 'Selected :label have been successfully deleted.');
    }

    public function trashed(): Response|ResponseFactory
    {
        $trashedCoupons = Coupon::search(request('search'))
                              ->onlyTrashed()
                              ->orderBy(request('sort', 'id'), request('direction', 'desc'))
                              ->paginate(request('per_page', 10))
                              ->appends(request()->all());

        return inertia('Admin/Coupons/Trash', compact('trashedCoupons'));
    }

    public function restore(Request $request, int $trashCouponId): RedirectResponse
    {
        $trashCoupon = Coupon::onlyTrashed()->findOrFail($trashCouponId);

        $trashCoupon->restore();

        return to_route('admin.coupons.trashed', $this->getQueryStringParams($request))->with('success', ':label has been successfully restored.');
    }

    public function restoreSelected(Request $request): RedirectResponse
    {
        if (!empty($request->selectedItems)) {
            Coupon::onlyTrashed()->whereIn('id', $request->selectedItems)->restore();
        }

        return to_route('admin.coupons.trashed', $this->getQueryStringParams($request))->with('success', 'Selected :label have been successfully restored.');
    }

    public function forceDelete(Request $request, int $trashCouponId): RedirectResponse
    {
        $trashCoupon = Coupon::onlyTrashed()->findOrFail($trashCouponId);

        $trashCoupon->forceDelete();

        return to_route('admin.coupons.trashed', $this->getQueryStringParams($request))->with('success', 'The :label has been permanently deleted.');
    }

    public function forceDeleteSelected(Request $request): RedirectResponse
    {
        if (!empty($request->selectedItems)) {
            Coupon::onlyTrashed()->whereIn('id', $request->selectedItems)->forceDelete();
        }

        return to_route('admin.coupons.trashed', $this->getQueryStringParams($request))->with('success', 'Selected :label have been permanently deleted.');
    }

    public function forceDeleteAll(Request $request): RedirectResponse
    {
        $trashCoupon = Coupon::onlyTrashed()->get();

        (new PermanentlyDeleteAllTrashCouponAction())->handle($trashCoupon);

        return to_route('admin.coupons.trashed', $this->getQueryStringParams($request))->with('success', 'All :label have been permanently deleted.');
    }
}
