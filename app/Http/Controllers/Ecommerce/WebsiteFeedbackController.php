<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use App\Http\Requests\WebsiteFeedbackRequest;
use App\Mail\ForTheSubmitters\ThankForWebsiteFeedbackMail;
use App\Models\WebsiteFeedback;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class WebsiteFeedbackController extends Controller
{
    public function store(WebsiteFeedbackRequest $request): RedirectResponse
    {
        $websiteFeedback=WebsiteFeedback::create($request->validated());

        Mail::to($request->email)->queue(new ThankForWebsiteFeedbackMail($websiteFeedback));

        return back()->with("success", "Thank for your feedback.");
    }
}
