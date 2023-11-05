<?php

namespace App\Console\Commands;

use App\Actions\Admin\AdminWebControlArea\Faqs\PermanentlyDeleteAllTrashFaqAction;
use App\Models\Faq;
use Carbon\Carbon;
use Illuminate\Console\Command;

class PermanentlyAutoDeleteFaqCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'faq:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Faqs in the trash will be automatically deleted after 60 days';

    public function handle(): void
    {
        $cutoffDate = Carbon::now()->subDays(60);

        $faqs = Faq::onlyTrashed()->where('deleted_at', '<=', $cutoffDate)->get();

        (new PermanentlyDeleteAllTrashFaqAction())->handle($faqs);
    }
}
