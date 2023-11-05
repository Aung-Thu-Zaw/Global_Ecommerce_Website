<?php

namespace App\Http\Requests;

use App\Rules\RecaptchaRule;
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
            'shop_review_id' => ['required', 'numeric', Rule::exists('shop_reviews', 'id')],
            'seller_id' => ['required', 'numeric', Rule::exists('users', 'id')],
            'reply_text' => ['required', 'string'],
            'captcha_token' => ['required', new RecaptchaRule()],
        ];
    }

    /**
     *     @return array<string>
     */
    public function messages(): array
    {
        return [
            'shop_review_id.required' => 'The shop review id is required.',
            'shop_review_id.numeric' => 'The shop review id must be a number.',
            'shop_review_id.exists' => 'The selected shop review id is invalid.',
            'seller_id.required' => 'The seller id is required.',
            'seller_id.numeric' => 'The seller id must be a number.',
            'seller_id.exists' => 'The selected seller id is invalid.',
            'reply_text.required' => 'The reply text is required.',
            'reply_text.string' => 'The reply text must be a string.',
            'captcha_token.required' => 'The captcha token is required',
        ];
    }
}
