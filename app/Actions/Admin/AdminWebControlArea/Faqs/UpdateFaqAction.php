<?php

namespace App\Actions\Admin\AdminWebControlArea\Faqs;

use App\Models\Faq;

class UpdateFaqAction
{
    /**
     * @param array<mixed> $data
     */
    public function handle(array $data, Faq $faq): void
    {
        $faq->update([
            "faq_sub_category_id"=>$data["faq_sub_category_id"],
            "question"=>$data["question"],
            "answer"=>$data["answer"],
        ]);
    }
}
