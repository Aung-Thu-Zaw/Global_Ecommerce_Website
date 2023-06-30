<?php

namespace App\Console\Commands;

use App\Models\Suggestion;
use App\Models\WebsiteFeedback;
use Carbon\Carbon;
use Illuminate\Console\Command;

class PermanentlyAutoDeleteSuggestionCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'suggestion:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Suggestions in the Trash will be automatically deleted after 60 days';


    public function handle(): void
    {
        $cutoffDate = Carbon::now()->subDays(60);

        $suggestions=Suggestion::onlyTrashed()
        ->where('deleted_at', '<=', $cutoffDate)->get();

        $suggestions->each(function ($suggestion) {
            $suggestion->forceDelete();
        });
    }
}
