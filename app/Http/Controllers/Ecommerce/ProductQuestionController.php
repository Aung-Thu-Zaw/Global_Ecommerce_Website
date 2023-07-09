<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductQuestionRequest;
use App\Models\Product;
use App\Models\ProductQuestion;
use App\Models\User;
use App\Notifications\ProductQuestions\NewProductQuestionFromUserNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ProductQuestionController extends Controller
{
    public function storeQuestion(ProductQuestionRequest $request): RedirectResponse
    {
        $productQuestion=ProductQuestion::create($request->validated());

        $vendor=User::findOrFail($request->shop_id);

        $product=Product::findOrFail($request->product_id);

        $vendor->notify(new NewProductQuestionFromUserNotification($productQuestion, $product));

        return back();
    }


    public function updateQuestion(ProductQuestionRequest $request, int $questionId): RedirectResponse
    {
        $productQuestion=ProductQuestion::findOrFail($questionId);

        $productQuestion->update(["question_text"=>$request->question_text]);

        return back();
    }

    public function destroyQuestion(int $questionId): RedirectResponse
    {

        $productQuestion=ProductQuestion::findOrFail($questionId);

        $productQuestion->delete();

        return back();
    }
}
