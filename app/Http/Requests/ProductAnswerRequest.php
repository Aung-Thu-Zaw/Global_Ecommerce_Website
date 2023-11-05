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
            'product_question_id' => ['required', 'numeric', Rule::exists('product_questions', 'id')],
            'seller_id' => ['required', 'numeric', Rule::exists('users', 'id')],
            'answer_text' => ['required', 'string'],
            'captcha_token' => ['required', new RecaptchaRule()],
        ];
    }

    /**
     *     @return array<string>
     */
    public function messages(): array
    {
        return [
            'product_question_id.required' => 'The product question id is required.',
            'product_question_id.numeric' => 'The product question id must be a number.',
            'product_question_id.exists' => 'The selected product question id is invalid.',
            'seller_id.required' => 'The seller id is required.',
            'seller_id.numeric' => 'The seller id must be a number.',
            'seller_id.exists' => 'The selected seller id is invalid.',
            'answer_text.required' => 'The answer text is required.',
            'answer_text.string' => 'The answer text must be a string.',
            'captcha_token.required' => 'The captcha token is required',
        ];
    }
}
