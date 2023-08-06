<?php

namespace App\Jobs\Products;

use App\Models\Product;
use App\Models\User;
use App\Notifications\Products\AdminApprovedCreatedNewProductNotification;
use App\Notifications\Products\AdminDisapprovedCreatedNewProductNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

class SendAdminApprovedOrDisapprovedCreatedNewProductNotificationToVendorDashboard implements ShouldQueue
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
    public function __construct(protected Product $product)
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
        $admins=User::where("role", "admin")->get();

        $this->product->status==="approved" ?
        Notification::send($admins, new AdminApprovedCreatedNewProductNotification($this->product)) :
        Notification::send($admins, new AdminDisapprovedCreatedNewProductNotification($this->product));
    }
}
