<?php

namespace App\Http\Requests;

use App\Rules\RecaptchaRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DeliveryInformationRequest extends FormRequest
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
            'user_id' => ['required', 'numeric', Rule::exists('users', 'id')],
            'name' => ['required', 'string'],
            'email' => ['required', 'string', 'email'],
            'phone' => ['required', 'string'],
            'address' => ['required', 'string'],
            'country' => ['required', 'string', Rule::exists('countries', 'name')],
            'region' => ['required', 'string', Rule::exists('regions', 'name')],
            'city' => ['required', 'string', Rule::exists('cities', 'name')],
            'township' => ['nullabel', 'string', Rule::exists('townships', 'name')],
            'postal_code' => ['nullable', 'numeric'],
            'additional_information' => ['nullable', 'string'],
            'captcha_token' => ['required', new RecaptchaRule()],
        ];
    }

    /**
     *     @return array<string>
     */
    public function messages(): array
    {
        return [
            'user_id.required' => 'The user id is required.',
            'user_id.numeric' => 'The user id must be a number.',
            'user_id.exists' => 'The selected user id is invalid.',
            'name.required' => 'The name field is required.',
            'name.string' => 'The name must be a string.',
            'email.required' => 'The email address field is required.',
            'email.string' => 'The email address must be a string.',
            'email.email' => 'The email address must be a valid email address.',
            'phone.required' => 'The phone field is required.',
            'phone.string' => 'The phone must be a string.',
            'address.required' => 'The address field is required.',
            'address.string' => 'The address must be a string.',
            'country.required' => 'The country field is required.',
            'country.string' => 'The country must be a string.',
            'country.exists' => 'The selected country field is invalid.',
            'region.required' => 'The region field is required.',
            'region.string' => 'The region must be a string.',
            'region.exists' => 'The selected region field is invalid.',
            'city.required' => 'The city field is required.',
            'city.string' => 'The city must be a string.',
            'city.exists' => 'The selected city field is invalid.',
            'township.string' => 'The township must be a string.',
            'township.exists' => 'The selected township field is invalid.',
            'postal_code.numeric' => 'The postal code must be a number.',
            'additional_information.string' => 'The additional information must be a string.',
            'captcha_token.required' => 'The captcha token is required',
        ];
    }
}
