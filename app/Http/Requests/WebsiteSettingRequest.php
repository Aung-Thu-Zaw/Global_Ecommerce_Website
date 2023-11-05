<?php

namespace App\Http\Requests;

use App\Rules\RecaptchaRule;
use Illuminate\Foundation\Http\FormRequest;

class WebsiteSettingRequest extends FormRequest
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
        $rules = [
            'phone' => ['nullable', 'string'],
            'support_phone' => ['nullable', 'string'],
            'email' => ['nullable', 'email'],
            'company_address' => ['nullable', 'string'],
            'copyright' => ['nullable', 'string'],
            'facebook' => ['nullable', 'url'],
            'twitter' => ['nullable', 'url'],
            'instagram' => ['nullable', 'url'],
            'youtube' => ['nullable', 'url'],
            'reddit' => ['nullable', 'url'],
            'linked_in' => ['nullable', 'url'],
            'captcha_token' => ['required', new RecaptchaRule()],
        ];

        if ($this->hasFile('logo')) {
            $rules['logo'] = ['required', 'image', 'mimes:png,jpg,jpeg,svg,webp,gif', 'max:5120'];
        }

        if ($this->hasFile('favicon')) {
            $rules['favicon'] = ['required', 'image', 'mimes:png,jpg,jpeg,svg,webp,gif', 'max:5120'];
        }

        return $rules;
    }

    /**
     *     @return array<string>
     */
    public function messages(): array
    {
        return [
            'phone.string' => 'The phone must be a string.',
            'support_phone.string' => 'The support phone must be a string.',
            'email.email' => 'The email address must be a valid email address.',
            'company_address.string' => 'The company address must be a string.',
            'copyright.string' => 'The copyright must be a string.',
            'facebook.url' => 'The facebook must be a valid URL.',
            'twitter.url' => 'The twitter must be a valid URL.',
            'instagram.url' => 'The instagram must be a valid URL.',
            'youtube.url' => 'The youtube must be a valid URL.',
            'reddit.url' => 'The reddit must be a valid URL.',
            'linked_in.url' => 'The linked in must be a valid URL.',  'image.required' => 'The image field is required.',
            'logo.required' => 'The image field is required.',
            'logo.image' => 'The image must be an image.',
            'logo.mimes' => 'The image must be a file of type: png,jpg,jpeg,svg,webp or gif.',
            'logo.max' => 'The image must not be greater than 5120 kilobytes.',
            'favicon.required' => 'The image field is required.',
            'favicon.image' => 'The image must be an image.',
            'favicon.mimes' => 'The image must be a file of type: png,jpg,jpeg,svg,webp or gif.',
            'favicon.max' => 'The image must not be greater than 5120 kilobytes.',
            'captcha_token.required' => 'The captcha token is required',
        ];
    }
}
