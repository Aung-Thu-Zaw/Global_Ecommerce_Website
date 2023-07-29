<?php

namespace App\Http\Requests;

use App\Rules\RecaptchaRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LanguageRequest extends FormRequest
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
            "name" => ["required", "string", Rule::unique("languages", "name")],
            "short_name" => ["required", "string", Rule::unique("languages", "short_name")],
            'captcha_token'  => ['required',new RecaptchaRule()],
        ];

        $route = $this->route();
        if ($route && in_array($this->method(), ["POST", 'PUT', 'PATCH'])) {
            $language = $route->parameter('language');
            $rules["name"] = ["required", "string", Rule::unique("languages", "name")->ignore($language)];
            $rules["short_name"] = ["required", "string", Rule::unique("languages", "short_name")->ignore($language)];
        }

        return $rules;
    }


    /**
    *     @return array<string>
    */
    public function messages(): array
    {
        return [
            "name.required" =>  "The name field is required.",
            "name.string" =>  "The name must be a string.",
            "name.unique" =>'The name has already been taken.',
            "short_name.required" =>  "The short name field is required.",
            "short_name.string" =>  "The short name must be a string.",
            "short_name.unique" =>'The short name has already been taken.',
            "captcha_token.required"=>"The captcha token is required",
        ];
    }
}
