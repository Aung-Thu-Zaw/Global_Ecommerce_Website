<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
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
            "name"=>["required","string",Rule::unique("brands", "name")],
            "description"=>["required","string"]
        ];

        if (in_array($this->method(), ["POST",'PUT', 'PATCH'])) {
            $brand = $this->route()->parameter('brand');
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
            "name.required" => "Brand name is required.",
            "description.required" => "Brand description is required.",
        ];
    }
}
