<?php

namespace App\Console\Commands;

use App\Models\ProductBanner;
use Carbon\Carbon;
use Illuminate\Console\Command;

class PermanentlyAutoDeleteProductBannerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'product_banner:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Product Banners in the trash will be automatically deleted after 60 days';


    public function handle(): void
    {
        $cutoffDate = Carbon::now()->subDays(60);

        $productBanners=ProductBanner::onlyTrashed()
                                     ->where('deleted_at', '<=', $cutoffDate)
                                     ->get();

        $productBanners->each(function ($productBanner) {

            ProductBanner::deleteImage($productBanner);

            $productBanner->forceDelete();

        });
    }
}
