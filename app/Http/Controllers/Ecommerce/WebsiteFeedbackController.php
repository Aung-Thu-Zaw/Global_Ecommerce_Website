<?php

namespace App\Http\Controllers\Ecommerce;

use App\Actions\Ecommerce\CreateWebsiteFeedbackAction;
use App\Events\FeedbackForWebsite;
use App\Http\Controllers\Controller;
use App\Http\Requests\WebsiteFeedbackRequest;
use Illuminate\Http\RedirectResponse;

class WebsiteFeedbackController extends Controller
{
    public function store(WebsiteFeedbackRequest $request): RedirectResponse
    {
        $websiteFeedback = (new CreateWebsiteFeedbackAction())->handle($request->validated());

        event(new FeedbackForWebsite($websiteFeedback));

        return back()->with('success', 'THANK_FOR_YOUR_FEEDBACK');
    }
}
