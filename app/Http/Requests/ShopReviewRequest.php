<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ShopReviewRequest extends FormRequest
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
            "vendor_id"=>["required","numeric",Rule::exists("users", "id")],
            "user_id"=>["required","numeric",Rule::exists("users", "id")],
            "review_text"=>["required","string"],
            "rating"=>["required","numeric"],
        ];
    }
}