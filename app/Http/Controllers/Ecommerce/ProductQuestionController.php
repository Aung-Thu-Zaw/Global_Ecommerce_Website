<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductQuestionRequest;
use App\Models\ProductQuestion;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ProductQuestionController extends Controller
{
    public function storeQuestion(ProductQuestionRequest $request): RedirectResponse
    {
        ProductQuestion::create($request->validated());

        return back();
    }

    public function updateQuestion(ProductQuestionRequest $request, int $questionId): RedirectResponse
    {
        $productQuestion=ProductQuestion::where("id", $questionId)->first();

        $productQuestion->update(["question_text"=>$request->question_text]);

        return back();
    }

    public function destroyQuestion(int $questionId): RedirectResponse
    {

        $productQuestion=ProductQuestion::where("id", $questionId)->first();

        $productQuestion->delete();

        return back();
    }
}
