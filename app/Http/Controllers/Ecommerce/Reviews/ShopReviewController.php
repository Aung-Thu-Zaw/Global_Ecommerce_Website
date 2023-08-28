<?php

namespace App\Http\Controllers\Ecommerce\Reviews;

use App\Actions\Ecommerce\Reviews\CreateShopReviewAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\ShopReviewRequest;
use App\Services\BroadcastNotifications\NewShopReviewNotificationSendToAdminDashboardService;
use App\Services\BroadcastNotifications\NewShopReviewNotificationSendToSellerDashboardService;
use Illuminate\Http\RedirectResponse;

class ShopReviewController extends Controller
{
    public function store(ShopReviewRequest $request): RedirectResponse
    {
        $shopReview = (new CreateShopReviewAction())->handle($request->validated());

        (new NewShopReviewNotificationSendToAdminDashboardService())->send($shopReview);

        (new NewShopReviewNotificationSendToSellerDashboardService())->send($shopReview);

        return back();
    }
}
