<?php

namespace App\Console\Commands;

use App\Models\CampaignBanner;
use Carbon\Carbon;
use Illuminate\Console\Command;

class PermanentlyAutoDeleteCampaignBannerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'campaign_banner:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Campaign Banners in the Trash will be automatically deleted after 60 days';


    public function handle(): void
    {
        $cutoffDate = Carbon::now()->subDays(60);

        $campaignBanners=CampaignBanner::onlyTrashed()
        ->where('deleted_at', '<=', $cutoffDate)->get();

        $campaignBanners->each(function ($campaignBanner) {
            CampaignBanner::deleteImage($campaignBanner);
            $campaignBanner->forceDelete();
        });
    }
}
