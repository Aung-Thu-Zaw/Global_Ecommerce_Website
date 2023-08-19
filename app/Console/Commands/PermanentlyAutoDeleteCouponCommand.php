<?php

namespace App\Console\Commands;

use App\Actions\Admin\Coupons\PermanentlyDeleteAllTrashCouponAction;
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
    protected $description = 'Coupons in the trash will be automatically deleted after 60 days';


    public function handle(): void
    {
        $cutoffDate = Carbon::now()->subDays(60);

        $coupons = Coupon::onlyTrashed()->where('deleted_at', '<=', $cutoffDate)->get();

        (new PermanentlyDeleteAllTrashCouponAction())->handle($coupons);
    }
}
