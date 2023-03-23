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
            "sub_category_id"=>["required","numeric",Rule::exists("sub_categories", "id")],
            "user_id"=>["required","numeric",Rule::exists("users", "id")],
            "name"=>["required","string"],
            "slug"=>["required","string"],
            "image"=>["required","string"],
            "code"=>["required","string"],
            "qty"=>["required","string"],
            "tag"=>["nullable","string"],
            "size"=>["nullable","string"],
            "color"=>["nullable","string"],
            "price"=>["required","string"],
            "discount"=>["nullable","string"],
            "description"=>["required","string"],
            "hot_deal"=>["nullable","boolean"],
            "featured"=>["nullable","boolean"],
            "special_offer"=>["nullable","boolean"],
            "status"=>["required","boolean"],
        ];
    }
}
