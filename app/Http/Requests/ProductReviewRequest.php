<?php

namespace App\Http\Requests;

use App\Rules\RecaptchaRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductReviewRequest extends FormRequest
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
            "product_id" => ["required","numeric",Rule::exists("products", "id")],
            "shop_id" => ["required","numeric",Rule::exists("users", "id")],
            "user_id" => ["required","numeric",Rule::exists("users", "id")],
            "review_text" => ["required","string"],
            "status" => ["required","string",Rule::in(["pending","published","unpublished"])],
            "rating" => ["required","numeric"],
            "captcha_token"  => ["required",new RecaptchaRule()],
        ];

        if ($this->hasFile("multi_image")) {
            $rules["multi_image.*"] = ["required","image","mimes:png,jpg,jpeg,svg,webp,gif","max:5120"];
        }

        return $rules;
    }

    /**
     *     @return array<string>
     */
    public function messages(): array
    {
        return [
            "user_id.required" =>  "The user id is required.",
            "user_id.numeric" =>  "The user id must be a number.",
            "user_id.exists" =>  "The selected user id is invalid.",
            "product_id.required" =>  "The product id is required.",
            "product_id.numeric" =>  "The product id must be a number.",
            "product_id.exists" =>  "The selected product id is invalid.",
            "shop_id.required" =>  "The shop id is required.",
            "shop_id.numeric" =>  "The shop id must be a number.",
            "shop_id.exists" =>  "The selected shop id is invalid.",
            "review_text.required" =>  "The review text is required.",
            "review_text.string" =>  "The review text must be a string.",
            "status.required" => "Product status is required.",
            "status.string" => "The status must be a string.",
            "status.in" => "The selected status is invalid.",
            "rating.required" =>  "The rating is required.",
            "rating.numeric" =>  "The rating must be a number.",
            "multi_image.required" => "The multi_image field is required.",
            "multi_image.multi_image" => "The multi image must be an multi_image.",
            "multi_image.mimes" => "The multi image must be a file of type: png,jpg,jpeg,svg,webp or gif.",
            "multi_image.max" => "The multi image must not be greater than 5120 kilobytes.'",
            "captcha_token.required" => "The captcha token is required",
        ];
    }
}
