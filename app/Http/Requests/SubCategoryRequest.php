<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SubCategoryRequest extends FormRequest
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
            "category_id"=>["required",Rule::exists("categories", "id")],
            "name"=>["required","string","max:255",Rule::unique("sub_categories", "name")],
            "status"=>["required","string",Rule::in(["show","hide"])]
        ];

        if (in_array($this->method(), ['POST','PUT', 'PATCH'])) {
            $category = $this->route()->parameter('sub_category');
            $rules["name"]=["required","string","max:255",Rule::unique("sub_categories", "name")->ignore($category)];
        }

        return $rules;
    }
}
