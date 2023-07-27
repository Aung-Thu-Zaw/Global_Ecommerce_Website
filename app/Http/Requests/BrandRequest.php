<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\RecaptchaRule;
use Illuminate\Validation\Rule;

class BrandRequest extends FormRequest
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
        $rules= [
            "category_id"=>["nullable",Rule::exists("categories", "id")],
            "name"=>["required","string",Rule::unique("brands", "name")],
            "description"=>["required","string"],
            'captcha_token'  => ['required',new RecaptchaRule()],
        ];

        if ($this->hasFile("image")) {
            $rules["image"]=["required","image","mimes:png,jpg,jpeg,svg,webp,gif","max:5120"];
        }

        $route = $this->route();
        if ($route&&in_array($this->method(), ["POST",'PUT', 'PATCH'])) {
            $brand = $route->parameter('brand');
            $rules["name"]=["required","string",Rule::unique("brands", "name")->ignore($brand)];
        }

        return $rules;
    }

    /**
    *     @return array<string>
    */
    public function messages(): array
    {
        return [
            "category_id.exists" =>  "The selected category id is invalid.",
            "name.required" =>  "The name field is required.",
            "name.string" =>  "The name must be a string.",
            "name.unique" =>'The name has already been taken.',
            "description.required" =>  "The description field is required.",
            "description.string" =>  "The description must be a string.",
            "image.required"=>"The image field is required.",
            "image.image"=>"The image must be an image.",
            "image.mimes"=>"The image must be a file of type: png,jpg,jpeg,svg,webp or gif.",
            "image.max"=>"The image must not be greater than 5120 kilobytes.'",
            "captcha_token.required"=>"The captcha token is required",
        ];
    }
}
