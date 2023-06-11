<?php

namespace App\Http\Requests;

use Faker\Core\Number;
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
        return [
            "brand_id"=>["required","numeric",Rule::exists("brands", "id")],
            "category_id"=>["required","numeric",Rule::exists("categories", "id")],
            "user_id"=>["required","numeric",Rule::exists("users", "id")],
            "collection_id"=>["required","numeric",Rule::exists("collections", "id")],
            "name"=>["required","string"],
            "code"=>["required","string"],
            "qty"=>["required","numeric"],
            "price"=>["required","numeric"],
            "discount"=>["nullable","numeric"],
            "description"=>["required","string"],
            "hot_deal"=>["nullable","boolean"],
            "featured"=>["nullable","boolean"],
            "special_offer"=>["nullable","boolean"],
            "status"=>["required",Rule::in(["active","inactive"])],
        ];
    }

      /**
    *     @return array<string>
    */
    public function messages(): array
    {
        return [
            "brand_id.required" => "Brand is required.",
            "brand_id.exists" => "Brand does not exist",
            "category_id.required" => "Category is required.",
            "category_id.exists" => "Category does not exist.",
            "user_id.required" => "User is required.",
            "user_id.exists" => "User does not exist.",
            "collection_id.required" => "Collection is required.",
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
        ];
    }
}
