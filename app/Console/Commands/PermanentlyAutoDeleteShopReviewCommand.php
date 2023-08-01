<?php

namespace App\Console\Commands;

use App\Actions\Admin\ReviewManagements\ShopReviews\PermanentlyDeleteAllTrashShopReviewAction;
use App\Models\ShopReview;
use Carbon\Carbon;
use Illuminate\Console\Command;

class PermanentlyAutoDeleteShopReviewCommand extends Command
{
    /**
    * The name and signature of the console command.
    *
    * @var string
    */
    protected $signature = 'shop_review:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Shop reviews in the trash will be automatically deleted after 60 days';


    public function handle(): void
    {
        $cutoffDate = Carbon::now()->subDays(60);

        $shopReviews=ShopReview::onlyTrashed()
                               ->where('deleted_at', '<=', $cutoffDate)
                               ->get();

        (new PermanentlyDeleteAllTrashShopReviewAction())->handle($shopReviews);
    }
}
