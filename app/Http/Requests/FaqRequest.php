<?php

namespace App\Http\Requests;

use App\Rules\RecaptchaRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FaqRequest extends FormRequest
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
            'faq_sub_category_id' => ['required', Rule::exists('faq_sub_categories', 'id')],
            'question' => ['required', 'string', 'max:255', Rule::unique('faqs', 'id')],
            'answer' => ['required', 'string'],
            'captcha_token' => ['required', new RecaptchaRule()],
        ];
    }

    /**
     *     @return array<string>
     */
    public function messages(): array
    {
        return [
            'faq_sub_category_id.required' => 'The faq subcategory id is required.',
            'faq_sub_category_id.exists' => 'The selected faq subcategory id is invalid.',
            'question.required' => 'The question field is required.',
            'question.string' => 'The question must be a string.',
            'question.max' => 'The question must not be greater than 255 characters.',
            'question.unique' => 'The question has already been taken.',
            'answer.required' => 'The answer field is required.',
            'answer.string' => 'The answer must be a string.',
            'captcha_token.required' => 'The captcha token is required',
        ];
    }
}
