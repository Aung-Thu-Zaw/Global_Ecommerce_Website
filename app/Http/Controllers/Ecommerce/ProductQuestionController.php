<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductQuestionRequest;
use App\Models\ProductQuestion;
use Illuminate\Http\RedirectResponse;

class ProductQuestionController extends Controller
{
    public function storeQuestion(ProductQuestionRequest $request): RedirectResponse
    {
        ProductQuestion::create($request->validated());

        return back();
    }
}
