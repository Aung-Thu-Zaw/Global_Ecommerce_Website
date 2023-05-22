<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ShopReviewReplyRequest extends FormRequest
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
            "shop_review_id"=>["required","numeric",Rule::exists("shop_reviews", "id")],
            "user_id"=>["required","numeric",Rule::exists("users", "id")],
            "reply_text"=>["required","string"],
        ];
    }
}
