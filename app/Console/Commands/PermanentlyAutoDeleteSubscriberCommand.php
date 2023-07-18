<?php

namespace App\Console\Commands;

use App\Models\Subscriber;
use Carbon\Carbon;
use Illuminate\Console\Command;

class PermanentlyAutoDeleteSubscriberCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscriber:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Subscribers in the trash will be automatically deleted after 60 days';


    public function handle(): void
    {
        $cutoffDate = Carbon::now()->subDays(60);

        $subscribers=Subscriber::onlyTrashed()
                               ->where('deleted_at', '<=', $cutoffDate)
                               ->get();

        $subscribers->each(function ($subscriber) {

            $subscriber->forceDelete();

        });
    }
}
