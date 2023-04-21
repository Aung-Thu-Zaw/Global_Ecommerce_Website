<?php

namespace App\Console\Commands;

use App\Models\Collection;
use Carbon\Carbon;
use Illuminate\Console\Command;

class PermanentlyAutoDeleteCollectionCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'collection:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Collections in the Trash will be automatically deleted after 60 days';


    public function handle(): void
    {
        $cutoffDate = Carbon::now()->subDays(60);

        $collections=Collection::onlyTrashed()
        ->where('deleted_at', '<=', $cutoffDate)->get();

        $collections->each(function ($collection) {
            Collection::deleteImage($collection);
            $collection->forceDelete();
        });
    }
}