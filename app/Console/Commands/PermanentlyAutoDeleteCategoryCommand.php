<?php

namespace App\Console\Commands;

use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Console\Command;

class PermanentlyAutoDeleteCategoryCommand extends Command
{
    /**
    * The name and signature of the console command.
    *
    * @var string
    */
    protected $signature = 'category:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Categories in the Trash will be automatically deleted after 60 days';


    public function handle(): void
    {
        $cutoffDate = Carbon::now()->subDays(60);

        $categories=Category::onlyTrashed()
        ->where('deleted_at', '<=', $cutoffDate)->get();

        $categories->each(function ($category) {
            $category->forceDelete();
        });
    }
}
