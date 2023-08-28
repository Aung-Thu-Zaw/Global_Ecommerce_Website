<?php

namespace App\Http\Controllers\Ecommerce\Reviews;

use App\Actions\Ecommerce\Reviews\CreateProductReviewAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductReviewRequest;
use App\Services\BroadcastNotifications\NewProductReviewNotificationSendToAdminDashboardService;
use App\Services\BroadcastNotifications\NewProductReviewNotificationSendToSellerDashboardService;
use Illuminate\Http\RedirectResponse;

class ProductReviewController extends Controller
{
    public function store(ProductReviewRequest $request): RedirectResponse
    {
        $productReview = (new CreateProductReviewAction())->handle($request->validated());

        (new NewProductReviewNotificationSendToAdminDashboardService())->send($productReview);

        (new NewProductReviewNotificationSendToSellerDashboardService())->send($productReview);

        return back();
    }
}
