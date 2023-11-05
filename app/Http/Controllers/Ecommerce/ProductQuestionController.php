<?php

namespace App\Http\Controllers\Ecommerce;

use App\Actions\Ecommerce\Products\CreateProductQuestionAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductQuestionRequest;
use App\Models\ProductQuestion;
use App\Services\BroadcastNotifications\NewProductQuestionNotificationSendToSellerDashboardService;
use Illuminate\Http\RedirectResponse;

class ProductQuestionController extends Controller
{
    public function store(ProductQuestionRequest $request): RedirectResponse
    {
        $productQuestion = (new CreateProductQuestionAction())->handle($request->validated());

        (new NewProductQuestionNotificationSendToSellerDashboardService())->send($productQuestion);

        return back();
    }

    public function update(ProductQuestionRequest $request, ProductQuestion $productQuestion): RedirectResponse
    {
        $productQuestion->update(['question_text' => $request->question_text]);

        return back();
    }

    public function destroy(ProductQuestion $productQuestion): RedirectResponse
    {
        $productQuestion->delete();

        return back();
    }
}
