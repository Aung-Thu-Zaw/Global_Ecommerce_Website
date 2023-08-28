<?php

namespace App\Http\Controllers\Ecommerce\Reviews;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShopReviewReplyRequest;
use App\Models\Reply;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ShopReviewReplyController extends Controller
{
    public function store(ShopReviewReplyRequest $request): RedirectResponse
    {
        Reply::create($request->validated());

        return back();
    }
}
