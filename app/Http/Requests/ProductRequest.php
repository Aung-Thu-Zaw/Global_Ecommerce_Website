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
            "sub_category_id"=>["required","numeric",Rule::exists("sub_categories", "id")],
            "user_id"=>["required","numeric",Rule::exists("users", "id")],
            "name"=>["required","string"],
            "code"=>["required","string"],
            "qty"=>["required","numeric"],
            "price"=>["required","numeric"],
            "discount"=>["nullable","numeric"],
            "description"=>["required","string"],
            "hot_deal"=>["required","boolean"],
            "featured"=>["required","boolean"],
            "special_offer"=>["required","boolean"],
            "status"=>["required",Rule::in(["active","inactive"])],
        ];
    }
}
