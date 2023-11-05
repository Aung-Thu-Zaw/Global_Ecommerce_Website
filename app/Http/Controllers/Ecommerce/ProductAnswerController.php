<?php

namespace App\Http\Controllers\Ecommerce;

use App\Actions\Ecommerce\Products\CreateProductQuestionAnswerAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductAnswerRequest;
use App\Models\ProductAnswer;
use App\Services\BroadcastNotifications\ProductQuestionAnswerFromSellerNotificationSendToUserService;
use Illuminate\Http\RedirectResponse;

class ProductAnswerController extends Controller
{
    public function store(ProductAnswerRequest $request): RedirectResponse
    {
        $productQuestionAnswer = (new CreateProductQuestionAnswerAction())->handle($request->validated());

        (new ProductQuestionAnswerFromSellerNotificationSendToUserService())->send($productQuestionAnswer);

        return back();
    }

    public function update(ProductAnswerRequest $request, ProductAnswer $productAnswer): RedirectResponse
    {
        $productAnswer->update(['answer_text' => $request->answer_text]);

        return back();
    }

    public function destroy(ProductAnswer $productAnswer): RedirectResponse
    {
        $productAnswer->delete();

        return back();
    }
}
