<?php

namespace App\Jobs\Orders;

use App\Mail\OrderConfirmMail;
use App\Models\DeliveryInformation;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendConfirmedOrderEmailToCustomer implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(protected Order $order)
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $deliveryInformation=$this->order->deliveryInformation;

        $deliveryInformation=DeliveryInformation::findOrFail($this->order->delivery_information_id);

        Mail::to($deliveryInformation->email)->send(new OrderConfirmMail($this->order));
    }
}
