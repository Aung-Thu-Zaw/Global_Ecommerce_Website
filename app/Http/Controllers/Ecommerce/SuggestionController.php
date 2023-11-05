<?php

namespace App\Http\Controllers\Ecommerce;

use App\Actions\Ecommerce\CreateSuggestionAction;
use App\Events\SuggestionForWebsite;
use App\Http\Controllers\Controller;
use App\Http\Requests\SuggestionRequest;
use Illuminate\Http\RedirectResponse;

class SuggestionController extends Controller
{
    public function store(SuggestionRequest $request): RedirectResponse
    {
        $suggestion = (new CreateSuggestionAction())->handle($request->validated());

        event(new SuggestionForWebsite($suggestion));

        return back()->with('success', 'THANKS_FOR_YOUR_SUGGESTION');
    }
}
