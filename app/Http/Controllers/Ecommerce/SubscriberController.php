<?php

namespace App\Http\Controllers\Ecommerce;

use App\Events\SubscribedNewsletter;
use App\Http\Controllers\Controller;
use App\Http\Requests\SubscriberRequest;
use App\Models\Subscriber;
use Illuminate\Http\RedirectResponse;

class SubscriberController extends Controller
{
    public function store(SubscriberRequest $request): RedirectResponse
    {
        $subscriber = Subscriber::create([
            'email' => $request->email,
        ]);

        event(new SubscribedNewsletter($subscriber));

        return back()->with('success', 'THANK_YOU_FOR_SUBSCRIBING_TO_OUR_NEWSLETTER');
    }
}
