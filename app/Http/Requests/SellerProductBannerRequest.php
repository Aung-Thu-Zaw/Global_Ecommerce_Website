<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SellerProductBannerRequest extends FormRequest
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
            "seller_id"=>["required","numeric",Rule::exists("users", "id")],
            "url"=>["required","url"],
        ];
    }

    /**
    *     @return array<string>
    */
    public function messages(): array
    {
        return [
            "seller_id.required" =>  "The user id is required.",
            "seller_id.numeric" =>  "The user id must be a number.",
            "seller_id.exists" =>  "The selected user id is invalid.",
            "url.required" =>  "The url is required.",
            "url.url" => "The url must be a valid URL.",
        ];
    }
}
