<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryRequest extends FormRequest
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
            "parent_id"=>["nullable",Rule::exists("categories", "id")],
            "name"=>["required","string","max:255",Rule::unique("categories", "name")],
            "status"=>["required","string",Rule::in(["show","hide"])]
        ];

        if (in_array($this->method(), ['POST','PUT', 'PATCH'])) {
            $category = $this->route()->parameter('category');
            $rules["name"]=["required","string","max:255",Rule::unique("categories", "name")->ignore($category)];
        }

        return $rules;
    }


    /**
    *     @return array<string>
    */
    public function messages(): array
    {
        return [
            "parent_id.exists" => "Parent category does not exist.",
            "name.required" => "Category name is required.",
            "name.unique" => "Category is already exists.",
            "description.required" => "Category status is required.",
            "status.required" => "Category status is required.",
        ];
    }
}
