<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductAnswerRequest;
use App\Models\ProductAnswer;
use Illuminate\Http\RedirectResponse;

class ProductAnswerController extends Controller
{
    public function storeAnswer(ProductAnswerRequest $request): RedirectResponse
    {
        ProductAnswer::create($request->validated());

        return back();
    }

    public function updateAnswer(ProductAnswerRequest $request, int $answerId): RedirectResponse
    {
        $productAnswer=ProductAnswer::findOrFail($answerId);

        $productAnswer->update(["answer_text"=>$request->answer_text]);

        return back();
    }

    public function destroyAnswer(int $answerId): RedirectResponse
    {
        $productAnswer=ProductAnswer::findOrFail($answerId);

        $productAnswer->delete();

        return back();
    }
}
