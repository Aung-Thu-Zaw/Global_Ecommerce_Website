<?php

namespace App\Http\Controllers\Ecommerce;

use App\Events\SuggestionForWebsite;
use App\Http\Controllers\Controller;
use App\Http\Requests\SuggestionRequest;
use App\Models\Suggestion;
use App\Services\SuggestionMultiImageUploadService;
use Illuminate\Http\RedirectResponse;

class SuggestionController extends Controller
{
    public function store(SuggestionRequest $request, SuggestionMultiImageUploadService $suggestionMultiImageUploadService): RedirectResponse
    {
        $suggestion=Suggestion::create($request->validated());

        $suggestionMultiImageUploadService->createMultiImage($request, $suggestion);

        event(new SuggestionForWebsite($suggestion));

        return back()->with("success", "Thank for your suggestion.");
    }
}
