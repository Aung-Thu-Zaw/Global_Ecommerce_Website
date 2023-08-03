<?php

namespace App\Http\Requests;

use App\Rules\RecaptchaRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FaqSubCategoryRequest extends FormRequest
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
            "icon"=>["nullable","string"],
            "faq_category_id"=>["required",Rule::exists("faq_categories", "id")],
            "name"=>["required","string","max:255",Rule::unique("faq_categories", "name")],
            'captcha_token'  => ['required',new RecaptchaRule()],
        ];
    }

    /**
    *     @return array<string>
    */
    public function messages(): array
    {
        return [
            "icon.string" => "The icon must be a string.",
            "faq_category_id.required" =>  "The faq category id is required.",
            "faq_category_id.exists" =>  "The selected faq category id is invalid.",
            "name.required" => "The name field is required.",
            "name.string" => "The name must be a string.",
            "name.max" => "The name must not be greater than 255 characters.",
            "name.unique" =>'The name has already been taken.',
            "captcha_token.required"=>"The captcha token is required",
        ];
    }
}
