<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductReviewReplyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "product_review_id"=>["required","numeric",Rule::exists("product_reviews", "id")],
            "user_id"=>["required","numeric",Rule::exists("users", "id")],
            "reply_text"=>["required","string"],
        ];
    }

    /**
    *     @return array<string>
    */
    public function messages(): array
    {
        return [
            "product_review_id.required" =>  "The product review id is required.",
            "product_review_id.numeric" =>  "The product review id must be a number.",
            "product_review_id.exists" =>  "The selected product review id is invalid.",
            "user_id.required" =>  "The user id is required.",
            "user_id.numeric" =>  "The user id must be a number.",
            "user_id.exists" =>  "The selected user id is invalid.",
            "reply_text.required" =>  "The reply text is required.",
            "reply_text.string" =>  "The reply text must be a string.",
        ];
    }
}
