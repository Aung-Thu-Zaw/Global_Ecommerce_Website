<?php

namespace App\Actions\Ecommerce;

use App\Models\WebsiteFeedback;

class CreateWebsiteFeedbackAction
{
    /**
     * @param array<mixed> $data
     */
    public function handle(array $data): WebsiteFeedback
    {
        $websiteFeedback = WebsiteFeedback::create([
            "email" => $data["email"],
            "feedback_text" => $data["feedback_text"],
            "rating" => $data["rating"],
        ]);

        return $websiteFeedback;
    }
}
