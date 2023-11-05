<?php

namespace App\Http\Requests;

use App\Rules\RecaptchaRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SuggestionRequest extends FormRequest
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
            'email' => ['required', 'email', 'string'],
            'description' => ['required', 'string'],
            'type' => ['required', Rule::in(['request_feature', 'report_bug'])],
            'captcha_token' => ['required', new RecaptchaRule()],
        ];
    }

    /**
     *     @return array<string>
     */
    public function messages(): array
    {
        return [
            'email.required' => 'The email address field is required.',
            'email.string' => 'The email address must be a string.',
            'email.email' => 'The email address must be a valid email address.',
            'description.required' => 'The description field is required.',
            'description.string' => 'The description must be a string.',
            'type.required' => 'The type field is required.',
            'type.in' => 'The selected type is invalid.',
            'captcha_token.required' => 'The captcha token is required',
        ];
    }
}
