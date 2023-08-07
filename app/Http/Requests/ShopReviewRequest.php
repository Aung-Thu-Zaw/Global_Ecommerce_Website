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
            "status"=>["required","string",Rule::in(["pending","published","unpublished"])],
            "rating"=>["required","numeric"],
        ];
    }

    /**
    *     @return array<string>
    */
    public function messages(): array
    {
        return [
            "user_id.required" =>  "The user id is required.",
            "user_id.numeric" =>  "The user id must be a number.",
            "user_id.exists" =>  "The selected user id is invalid.",
            "vendor_id.required" =>  "The vendor id is required.",
            "vendor_id.numeric" =>  "The vendor id must be a number.",
            "vendor_id.exists" =>  "The selected vendor id is invalid.",
            "review_text.required" =>  "The review text is required.",
            "review_text.string" =>  "The review text must be a string.",
            "rating.required" =>  "The rating is required.",
            "rating.numeric" =>  "The rating must be a number.",
        ];
    }


}
