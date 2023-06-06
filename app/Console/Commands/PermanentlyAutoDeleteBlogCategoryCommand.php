<?php

namespace App\Console\Commands;

use App\Models\BlogCategory;
use Carbon\Carbon;
use Illuminate\Console\Command;

class PermanentlyAutoDeleteBlogCategoryCommand extends Command
{
    /**
    * The name and signature of the console command.
    *
    * @var string
    */
    protected $signature = 'blog_category:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Blog categories in the Trash will be automatically deleted after 60 days';


    public function handle(): void
    {
        $cutoffDate = Carbon::now()->subDays(60);

        $blogCategories=BlogCategory::onlyTrashed()
        ->where('deleted_at', '<=', $cutoffDate)->get();

        $blogCategories->each(function ($blogCategory) {
            BlogCategory::deleteImage($blogCategory);
            $blogCategory->forceDelete();
        });
    }
}