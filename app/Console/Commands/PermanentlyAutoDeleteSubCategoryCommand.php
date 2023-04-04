<?php

namespace App\Console\Commands;

use App\Models\SubCategory;
use Carbon\Carbon;
use Illuminate\Console\Command;

class PermanentlyAutoDeleteSubCategoryCommand extends Command
{
    /**
    * The name and signature of the console command.
    *
    * @var string
    */
    protected $signature = 'sub_category:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'SubCategories in the Trash will be automatically deleted after 60 days';


    public function handle(): void
    {
        $cutoffDate = Carbon::now()->subDays(60);

        $subCategories=SubCategory::onlyTrashed()
        ->where('deleted_at', '<=', $cutoffDate)->get();

        $subCategories->each(function ($subCategory) {
            SubCategory::deleteImage($subCategory);
            $subCategory->forceDelete();
        });
    }
}
