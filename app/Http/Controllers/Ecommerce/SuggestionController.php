<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use App\Http\Requests\SuggestionRequest;
use App\Mail\SubscriberMail;
use App\Mail\ForTheSubmitters\ThankForSuggestionMail;
use App\Models\Suggestion;
use App\Services\SuggestionMultiImageUploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SuggestionController extends Controller
{
    public function store(SuggestionRequest $request, SuggestionMultiImageUploadService $suggestionMultiImageUploadService): RedirectResponse
    {
        $suggestion=Suggestion::create($request->validated());

        $suggestionMultiImageUploadService->createMultiImage($request, $suggestion);

        Mail::to($request->email)->queue(new ThankForSuggestionMail($suggestion));

        return back()->with("success", "Thank for your suggestion.");
    }
}
