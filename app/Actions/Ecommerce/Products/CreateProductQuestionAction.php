<?php

namespace App\Actions\Ecommerce\Products;

use App\Models\ProductQuestion;

class CreateProductQuestionAction
{
    /**
     * @param array<mixed> $data
     */
    public function handle(array $data): ProductQuestion
    {
        $productQuestion = ProductQuestion::create([
            "user_id" => $data["user_id"],
            "product_id" => $data["product_id"],
            "seller_id" => $data["seller_id"],
            "question_text" => $data["question_text"],
        ]);

        return $productQuestion;
    }
}
