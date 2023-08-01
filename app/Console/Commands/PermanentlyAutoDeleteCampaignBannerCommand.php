<?php

namespace App\Console\Commands;

use App\Actions\Admin\Banners\CampaignBanners\PermanentlyDeleteAllTrashCampaignBannerAction;
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
    protected $description = 'Campaign Banners in the trash will be automatically deleted after 60 days';


    public function handle(): void
    {
        $cutoffDate = Carbon::now()->subDays(60);

        $campaignBanners=CampaignBanner::onlyTrashed()->where('deleted_at', '<=', $cutoffDate)->get();

        (new PermanentlyDeleteAllTrashCampaignBannerAction())->handle($campaignBanners);
    }
}
