<?php

namespace App\Console\Commands;

use App\Models\WebsiteFeedback;
use Carbon\Carbon;
use Illuminate\Console\Command;

class PermanentlyAutoDeleteFeedbackCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'website_feedback:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Website Feedbacks in the trash will be automatically deleted after 60 days';


    public function handle(): void
    {
        $cutoffDate = Carbon::now()->subDays(60);

        $websiteFeedbacks=WebsiteFeedback::onlyTrashed()
                                         ->where('deleted_at', '<=', $cutoffDate)
                                         ->get();

        $websiteFeedbacks->each(function ($websiteFeedback) {

            $websiteFeedback->forceDelete();

        });
    }
}