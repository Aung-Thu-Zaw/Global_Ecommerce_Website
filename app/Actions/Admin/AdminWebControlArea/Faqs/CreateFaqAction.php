<?php

namespace App\Actions\Admin\AdminWebControlArea\Faqs;

use App\Models\Faq;

class CreateFaqAction
{
    /**
     * @param array<mixed> $data
     */
    public function handle(array $data): void
    {
        Faq::create([
            "faq_sub_category_id"=>$data["faq_sub_category_id"],
            "question"=>$data["question"],
            "answer"=>$data["answer"],
        ]);
    }
}
