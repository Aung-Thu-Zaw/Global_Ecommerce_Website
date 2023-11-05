<?php

namespace App\Console\Commands;

use App\Actions\Admin\AdminWebControlArea\FaqCategories\Categories\PermanentlyDeleteAllTrashFaqCategoryAction;
use App\Models\FaqCategory;
use Carbon\Carbon;
use Illuminate\Console\Command;

class PermanentlyAutoDeleteFaqCategoryCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'faq_category:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Faq Categories in the trash will be automatically deleted after 60 days';

    public function handle(): void
    {
        $cutoffDate = Carbon::now()->subDays(60);

        $faqCategories = FaqCategory::onlyTrashed()->where('deleted_at', '<=', $cutoffDate)->get();

        (new PermanentlyDeleteAllTrashFaqCategoryAction())->handle($faqCategories);
    }
}
