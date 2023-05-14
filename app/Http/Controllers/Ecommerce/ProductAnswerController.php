<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductAnswerRequest;
use App\Models\ProductAnswer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ProductAnswerController extends Controller
{
    public function createAnswer(ProductAnswerRequest $request): RedirectResponse
    {
        ProductAnswer::create($request->validated());

        return back();
    }

    public function updateAnswer(ProductAnswerRequest $request): RedirectResponse
    {
        $productAnswer=ProductAnswer::where("product_question_id", $request->product_question_id)->where("user_id", auth()->user()->id)->first();

        $productAnswer->update(["answer_text"=>$request->answer_text]);

        return back();
    }

    public function destroyAnswer(Request $request): RedirectResponse
    {
        $productAnswer=ProductAnswer::where("product_question_id", $request->product_question_id)->where("user_id", auth()->user()->id)->first();

        $productAnswer->delete();

        return back();
    }


}
