<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductQuestionRequest extends FormRequest
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
            "user_id"=>["required","numeric",Rule::exists("users", "id")],
            "product_id"=>["required","numeric",Rule::exists("products", "id")],
            "shop_id"=>["required","numeric",Rule::exists("users", "id")],
            "question_text"=>["required","string"],
        ];
    }

    /**
    *     @return array<string>
    */
    public function messages(): array
    {
        return [
            "product_id.required" =>  "The product id is required.",
            "product_id.numeric" =>  "The product id must be a number.",
            "product_id.exists" =>  "The selected product id is invalid.",
            "user_id.required" =>  "The user id is required.",
            "user_id.numeric" =>  "The user id must be a number.",
            "user_id.exists" =>  "The selected user id is invalid.",
            "shop_id.required" =>  "The user id is required.",
            "shop_id.numeric" =>  "The user id must be a number.",
            "shop_id.exists" =>  "The selected user id is invalid.",
            "question_text.required" =>  "The question text is required.",
            "question_text.string" =>  "The question text must be a string.",
        ];
    }
}
