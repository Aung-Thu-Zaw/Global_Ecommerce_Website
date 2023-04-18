<?php

namespace App\Console\Commands;

use App\Models\Coupon;
use Carbon\Carbon;
use Illuminate\Console\Command;

class PermanentlyAutoDeleteCouponCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'coupon:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Coupons in the Trash will be automatically deleted after 60 days';


    public function handle(): void
    {
        $cutoffDate = Carbon::now()->subDays(60);

        $coupons=Coupon::onlyTrashed()
        ->where('deleted_at', '<=', $cutoffDate)->get();

        $coupons->each(function ($coupon) {
            $coupon->forceDelete();
        });
    }
}
