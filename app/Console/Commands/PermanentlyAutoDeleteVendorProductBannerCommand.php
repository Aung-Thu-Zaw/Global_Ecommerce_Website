<?php

namespace App\Console\Commands;

use App\Models\VendorProductBanner;
use Carbon\Carbon;
use Illuminate\Console\Command;

class PermanentlyAutoDeleteVendorProductBannerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vendor_product_banner:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Product Banners in the Trash will be automatically deleted after 60 days';


    public function handle(): void
    {
        $cutoffDate = Carbon::now()->subDays(60);

        $vendorProductBanners=VendorProductBanner::onlyTrashed()
        ->where('deleted_at', '<=', $cutoffDate)->get();

        $vendorProductBanners->each(function ($vendorProductBanner) {
            VendorProductBanner::deleteImage($vendorProductBanner);
            $vendorProductBanner->forceDelete();
        });
    }
}
