<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DeliveryInformationRequest extends FormRequest
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
            "user_id"=>["required","numeric",Rule::exists("users", "id")],
            "name"=>["required","string"],
            "email"=>["required","email"],
            "phone"=>["required","numeric"],
            "address"=>["required","string"],
            "country"=>["required","string",Rule::exists("countries", "name")],
            "region"=>["required","string",Rule::exists("regions", "name")],
            "city"=>["required","string",Rule::exists("cities", "name")],
            "township"=>["required","string",Rule::exists("townships", "name")],
            "postal_code"=>["nullable","numeric"],
            "additional_information"=>["nullable","string"],
        ];
    }
}
