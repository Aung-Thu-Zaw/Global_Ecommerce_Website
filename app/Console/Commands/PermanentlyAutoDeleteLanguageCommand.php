<?php

namespace App\Console\Commands;

use App\Models\Brand;
use App\Models\Language;
use Carbon\Carbon;
use Illuminate\Console\Command;

class PermanentlyAutoDeleteLanguageCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'language:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Languages in the Trash will be automatically deleted after 60 days';


    public function handle(): void
    {
        $cutoffDate = Carbon::now()->subDays(60);

        $languages=Language::onlyTrashed()
        ->where('deleted_at', '<=', $cutoffDate)->get();

        $languages->each(function ($language) {
            unlink(resource_path("lang/$language->short_name.json"));

            $language->forceDelete();
        });
    }
}
