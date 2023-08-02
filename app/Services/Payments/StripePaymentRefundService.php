<?php

namespace App\Services\Payments;

use App\Models\Order;
use Exception;
use Stripe\PaymentIntent;
use Stripe\Refund;
use Stripe\Stripe;

class StripePaymentRefundService
{
    public function refundPayment(Order $order): string
    {
        try {

            Stripe::setApiKey(env('STRIPE_SECRET'));

            $payment =PaymentIntent::retrieve((string)$order->payment_id);


            Refund::create([
                 'payment_intent' => $payment->id,
             ]);

            $order->update([
            "return_status"=>"refunded",
            "return_refunded_date"=>now()->format("Y-m-d")
        ]);

            $order->orderItems()->each(function ($orderItem) {
                $orderItem->update([
                    "return_status"=>"refunded",
                    "return_refunded_date"=>now()->format("Y-m-d")
                    ]);
            });

            // Refunded Mail

            return "Order return is refunded.";

        } catch (Exception $e) {
            return back()->with("error", $e->getMessage());
        }
    }
}
