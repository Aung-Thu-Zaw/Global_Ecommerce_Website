<?php

namespace App\Http\Requests;

use App\Rules\RecaptchaRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
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
            "brand_id"=>["nullable","numeric",Rule::exists("brands", "id")],
            "category_id"=>["required","numeric",Rule::exists("categories", "id")],
            "user_id"=>["required","numeric",Rule::exists("users", "id")],
            "collection_id"=>["nullable","numeric",Rule::exists("collections", "id")],
            "name"=>["required","string"],
            "code"=>["required","string"],
            "qty"=>["required","numeric"],
            "price"=>["required","numeric"],
            "discount"=>["nullable","numeric"],
            "description"=>["required","string"],
            "hot_deal"=>["nullable","boolean"],
            "featured"=>["nullable","boolean"],
            "special_offer"=>["nullable","boolean"],
            "sizes"=>["nullable","array"],
            "colors"=>["nullable","array"],
            "types"=>["nullable","array"],
            "status"=>["required","string",Rule::in(["pending","approved","disapproved"])],
            "captcha_token"=> ["required",new RecaptchaRule()],
        ];

        if ($this->hasFile("image")) {
            $rules["image"]=["required","image","mimes:png,jpg,jpeg,svg,webp,gif","max:5120"];
        }

        if ($this->hasFile("multi_image")) {
            $rules["multi_image.*"]=["required","image","mimes:png,jpg,jpeg,svg,webp,gif","max:5120"];
        }

        return $rules;
    }

    /**
    *     @return array<string>
    */
    public function messages(): array
    {
        return [
            "brand_id.exists" => "Brand does not exist",
            "category_id.required" => "Category is required.",
            "category_id.exists" => "Category does not exist.",
            "user_id.required" => "User is required.",
            "user_id.exists" => "User does not exist.",
            "collection_id.exists" => "Collection does not exist.",
            "name.required" => "Product name is required.",
            "code.required" => "Product code is required.",
            "qty.required" => "Product quantity is required.",
            "qty.numeric" => "Product quantity must be numeric.",
            "price.required" => "Product price is required.",
            "price.numeric" => "Product price must be numeric.",
            "discount.numeric" => "Product discount must be numeric.",
            "description.required" => "Product description is required.",
            "status.required" => "Product status is required.",
            "status.string" => "The status must be a string.",
            "status.in"=>"The selected status is invalid.",
            "image.required"=>"The image field is required.",
            "image.image"=>"The image must be an image.",
            "image.mimes"=>"The image must be a file of type: png,jpg,jpeg,svg,webp or gif.",
            "image.max"=>"The image must not be greater than 5120 kilobytes.'",
            "multi_image.required"=>"The multi_image field is required.",
            "multi_image.multi_image"=>"The multi image must be an multi_image.",
            "multi_image.mimes"=>"The multi image must be a file of type: png,jpg,jpeg,svg,webp or gif.",
            "multi_image.max"=>"The multi image must not be greater than 5120 kilobytes.'",
            "captcha_token.required"=>"The captcha token is required",
        ];
    }
}
