<?php

namespace App\Console\Commands;

use App\Actions\Seller\ProductBanners\PermanentlyDeleteAllTrashSellerProductBannerAction;
use App\Models\SellerProductBanner;
use Carbon\Carbon;
use Illuminate\Console\Command;

class PermanentlyAutoDeleteSellerProductBannerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seller_product_banner:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Product Banners in the trash will be automatically deleted after 60 days';


    public function handle(): void
    {
        $cutoffDate = Carbon::now()->subDays(60);

        $sellerProductBanners=SellerProductBanner::onlyTrashed()->where('deleted_at', '<=', $cutoffDate)->get();

        (new PermanentlyDeleteAllTrashSellerProductBannerAction())->handle($sellerProductBanners);
    }
}
