<?php

namespace App\Http\Requests;

use App\Rules\RecaptchaRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductAnswerRequest extends FormRequest
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
            "product_question_id" => ["required","numeric",Rule::exists("product_questions", "id")],
            "user_id" => ["required","numeric",Rule::exists("users", "id")],
            "answer_text" => ["required","string"],
            "captcha_token"  => ["required",new RecaptchaRule()],
        ];
    }

    /**
    *     @return array<string>
    */
    public function messages(): array
    {
        return [
            "product_question_id.required" =>  "The product question id is required.",
            "product_question_id.numeric" =>  "The product question id must be a number.",
            "product_question_id.exists" =>  "The selected product question id is invalid.",
            "user_id.required" =>  "The user id is required.",
            "user_id.numeric" =>  "The user id must be a number.",
            "user_id.exists" =>  "The selected user id is invalid.",
            "answer_text.required" =>  "The answer text is required.",
            "answer_text.string" =>  "The answer text must be a string.",
            "captcha_token.required" => "The captcha token is required",
        ];
    }
}
