<?php

namespace App\Http\Requests;

use App\Rules\RecaptchaRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegionRequest extends FormRequest
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
            "name" => ["required","string","max:255",Rule::unique("regions", "name")],
            "captcha_token"  => ["required",new RecaptchaRule()],

        ];

        $route = $this->route();
        if ($route && in_array($this->method(), ['POST','PUT', 'PATCH'])) {
            $region = $route->parameter('region');
            $rules["name"] = ["required","string","max:255",Rule::unique("regions", "name")->ignore($region)];
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
            "name.unique" => "The name has already been taken.",
            "name.max" => "The name must not be greater than 255 characters.",
            "captcha_token.required" => "The captcha token is required",
        ];
    }
}
