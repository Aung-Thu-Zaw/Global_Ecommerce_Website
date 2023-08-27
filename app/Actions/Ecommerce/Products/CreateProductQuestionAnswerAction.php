<?php

namespace App\Actions\Ecommerce\Products;

use App\Models\ProductAnswer;

class CreateProductQuestionAnswerAction
{
    /**
     * @param array<mixed> $data
     */
    public function handle(array $data): ProductAnswer
    {
        $productQuestionAnswer = ProductAnswer::create([
            "product_question_id" => $data["product_question_id"],
            "seller_id" => $data["seller_id"],
            "answer_text" => $data["answer_text"],
        ]);

        return $productQuestionAnswer;
    }
}
