<?php

namespace App\Http\Controllers\Ecommerce;

use App\Actions\Ecommerce\CreateWebsiteFeedbackAction;
use App\Events\FeedbackForWebsite;
use App\Http\Controllers\Controller;
use App\Http\Requests\WebsiteFeedbackRequest;
use App\Mail\ForTheSubmitters\ThankForWebsiteFeedbackMail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;

class WebsiteFeedbackController extends Controller
{
    public function store(WebsiteFeedbackRequest $request): RedirectResponse
    {
        $websiteFeedback = (new CreateWebsiteFeedbackAction())->handle($request->validated());

        event(new FeedbackForWebsite($websiteFeedback));

        return back()->with("success", "THANK_FOR_YOUR_FEEDBACK");
    }
}
