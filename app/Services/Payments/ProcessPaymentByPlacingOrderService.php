<?php

namespace App\Services\Payments;

use App\Models\User;
use App\Services\Orders\OrderProcessingService;
use Illuminate\Support\Facades\Log;
use Stripe\Charge;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class ProcessPaymentByPlacingOrderService
{
    /**
     * @param  array<mixed>  $cartItems
     */
    public function processPayment(int $totalPrice, array $cartItems, ?string $paymentMethodId, string $paymentType): void
    {
        try {
            if ($paymentType === 'stripe') {
                $this->processStripePayment($totalPrice, $cartItems, $paymentMethodId);
            } elseif ($paymentType === 'cash') {
                $this->processCashPayment($totalPrice, $cartItems);
            } else {
                throw new \Exception('Invalid payment type.');
            }
        } catch (\Exception $e) {
            Log::error('Error processing payment: '.$e->getMessage());
        }
    }

    /**
     * @param  array<mixed>  $cartItems
     */
    private function processStripePayment(int $totalPrice, array $cartItems, ?string $paymentMethodId): void
    {
        $user = User::findOrFail(auth()->id());

        Stripe::setApiKey(env('STRIPE_SECRET'));

        $paymentIntent = PaymentIntent::create([
            'amount' => $totalPrice * 100,
            'currency' => 'usd',
            'description' => '',
            'payment_method' => $paymentMethodId,
            'confirm' => true,
            'metadata' => [
                'order_id' => '#'.uniqid(),
            ],
        ]);

        $transaction = null;
        if ($paymentIntent->latest_charge) {
            $charge = Charge::retrieve($paymentIntent->latest_charge);

            $transaction = $charge->balance_transaction;
        }

        $orderProcessingService = new OrderProcessingService();

        $order = $orderProcessingService->createOrder(
            $user,
            $totalPrice,
            $paymentIntent->id,
            $paymentIntent->payment_method_types[0],
            $paymentIntent->payment_method ?? 'card',
            $paymentIntent->currency,
            $transaction
        );

        $order->load(['deliveryInformation', 'orderItems.product.shop']);

        $orderProcessingService->createOrderItems($order->id, $cartItems);

        $orderProcessingService->sendOrderPlacedMail($order);

        $orderProcessingService->notifyOrderPlacedToAdmins($order);

        $orderProcessingService->removeCouponSession();

        $orderProcessingService->clearCartItems();
    }

    /**
     * @param  array<mixed>  $cartItems
     */
    private function processCashPayment(int $totalPrice, array $cartItems): void
    {
        $user = User::findOrFail(auth()->id());

        $orderProcessingService = new OrderProcessingService();

        $order = $orderProcessingService->createOrder(
            $user,
            $totalPrice,
            null,
            'cash on delivery',
            'cash on delivery',
            'usd',
            null
        );

        $order->load(['deliveryInformation', 'orderItems.product.shop']);

        $orderProcessingService->createOrderItems($order->id, $cartItems);

        $orderProcessingService->sendOrderPlacedMail($order);

        $orderProcessingService->notifyOrderPlacedToAdmins($order);

        $orderProcessingService->removeCouponSession();

        $orderProcessingService->clearCartItems();
    }
}
