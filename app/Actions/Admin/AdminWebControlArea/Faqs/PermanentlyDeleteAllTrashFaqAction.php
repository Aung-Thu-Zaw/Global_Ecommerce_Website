<?php

namespace App\Actions\Admin\AdminWebControlArea\Faqs;

use App\Models\Faq;
use Illuminate\Support\Collection;

class PermanentlyDeleteAllTrashFaqAction
{
    /**
    * @param Collection<int,Faq> $faqs
    */

    public function handle(Collection $faqs): void
    {
        $faqs->each(function ($faq) {

            $faq->forceDelete();

        });
    }
}
