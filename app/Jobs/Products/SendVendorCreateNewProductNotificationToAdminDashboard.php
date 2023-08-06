<?php

namespace App\Jobs\Products;

use App\Models\Product;
use App\Models\User;
use App\Notifications\Products\VendorCreateNewProductNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

class SendVendorCreateNewProductNotificationToAdminDashboard implements ShouldQueue
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

        $vendor=User::findOrFail($this->product->user_id);

        Notification::send($admins, new VendorCreateNewProductNotification($vendor, $this->product));
    }
}
