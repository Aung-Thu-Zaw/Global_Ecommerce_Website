<?php

namespace App\Console\Commands;

use App\Actions\Admin\ReviewManagements\ProductReviews\PermanentlyDeleteAllTrashProductReviewAction;
use App\Models\ProductReview;
use Carbon\Carbon;
use Illuminate\Console\Command;

class PermanentlyAutoDeleteProductReviewCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'product_review:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Product reviews in the trash will be automatically deleted after 60 days';

    public function handle(): void
    {
        $cutoffDate = Carbon::now()->subDays(60);

        $productReviews = ProductReview::onlyTrashed()
                                     ->where('deleted_at', '<=', $cutoffDate)
                                     ->get();

        (new PermanentlyDeleteAllTrashProductReviewAction())->handle($productReviews);
    }
}
