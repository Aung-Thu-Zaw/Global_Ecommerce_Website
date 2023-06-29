<?php

namespace App\Http\Controllers\Ecommerce;

use App\Events\SubscribedNewsletter;
use App\Http\Controllers\Controller;
use App\Http\Requests\SubscriberRequest;
use App\Mail\ForTheSubmitters\ThankForSubscribeWebsiteMail;
use App\Models\Subscriber;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;

class SubscriberController extends Controller
{
    public function store(SubscriberRequest $request): RedirectResponse
    {
        $subscriber=Subscriber::create($request->validated());

        event(new SubscribedNewsletter($subscriber));

        return back()->with("success", "Thank you for subscribing to our newsletter.");
    }
}
