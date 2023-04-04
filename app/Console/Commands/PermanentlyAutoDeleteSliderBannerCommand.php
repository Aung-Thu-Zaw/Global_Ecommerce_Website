<?php

namespace App\Console\Commands;

use App\Models\SliderBanner;
use Carbon\Carbon;
use Illuminate\Console\Command;

class PermanentlyAutoDeleteSliderBannerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'slider_banner:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Slider Banners in the Trash will be automatically deleted after 60 days';


    public function handle(): void
    {
        $cutoffDate = Carbon::now()->subDays(60);

        $sliderBanners=SliderBanner::onlyTrashed()
        ->where('deleted_at', '<=', $cutoffDate)->get();

        $sliderBanners->each(function ($sliderBanner) {
            SliderBanner::deleteImage($sliderBanner);
            $sliderBanner->forceDelete();
        });
    }
}
