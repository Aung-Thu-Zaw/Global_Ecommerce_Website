<?php

namespace App\Console\Commands;

use App\Actions\Admin\AdminWebControlArea\FaqCategories\SubCategories\PermanentlyDeleteAllTrashFaqSubCategoryAction;
use App\Models\FaqSubCategory;
use Carbon\Carbon;
use Illuminate\Console\Command;

class PermanentlyAutoDeleteFaqSubCategoryCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'faq_sub_category:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Faq SubCategories in the trash will be automatically deleted after 60 days';


    public function handle(): void
    {
        $cutoffDate = Carbon::now()->subDays(60);

        $faqSubCategories=FaqSubCategory::onlyTrashed()->where('deleted_at', '<=', $cutoffDate)->get();

        (new PermanentlyDeleteAllTrashFaqSubCategoryAction())->handle($faqSubCategories);
    }
}
