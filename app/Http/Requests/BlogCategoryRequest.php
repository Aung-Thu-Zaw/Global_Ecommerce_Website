<?php

namespace App\Http\Requests;

use App\Rules\RecaptchaRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BlogCategoryRequest extends FormRequest
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
            "name"=>["required","string","max:255",Rule::unique("blog_categories", "name")],
            "status"=>["required","string",Rule::in(["show","hide"])],
            "captcha_token"  => ["required",new RecaptchaRule()],
        ];

        if ($this->hasFile("image")) {
            $rules["image"]=["required","image","mimes:png,jpg,jpeg,svg,webp,gif","max:5120"];
        }

        $route = $this->route();
        if ($route&&in_array($this->method(), ["POST","PUT", "PATCH"])) {
            $blog_category = $route->parameter("blog_category");
            $rules["name"]=["required","string","max:255",Rule::unique("blog_categories", "name")->ignore($blog_category)];
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
            "name.max" => "The name must not be greater than 255 characters.",
            "name.unique" =>"The name has already been taken.",
            "status.required" =>  "The status field is required.",
            "status.string" =>  "The status must be a string.",
            "status.in"=>"The selected status is invalid.",
            "image.required"=>"The image field is required.",
            "image.image"=>"The image must be an image.",
            "image.mimes"=>"The image must be a file of type: png,jpg,jpeg,svg,webp or gif.",
            "image.max"=>"The image must not be greater than 5120 kilobytes.'",
            "captcha_token.required"=>"The captcha token is required",
        ];
    }
}
