<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubscriberRequest;
use App\Mail\SubscriberMail;
use App\Models\Subscriber;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SubscriberController extends Controller
{
    public function store(SubscriberRequest $request): RedirectResponse
    {
        $subscriber=Subscriber::create($request->validated());

        Mail::to($subscriber->email)->send(new SubscriberMail());

        return back()->with("success", "Thank you for subscribing to our newsletter.");
    }
}
