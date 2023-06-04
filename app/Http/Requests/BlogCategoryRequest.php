<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BlogCategoryRequest extends FormRequest
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
            "parent_id"=>["nullable",Rule::exists("blog_categories", "id")],
            "name"=>["required","string","max:255",Rule::unique("blog_categories", "name")],
            "status"=>["required","string",Rule::in(["show","hide"])]
        ];

        if (in_array($this->method(), ['POST','PUT', 'PATCH'])) {
            $blog_category = $this->route()->parameter('blog_category');
            $rules["name"]=["required","string","max:255",Rule::unique("blog_categories", "name")->ignore($blog_category)];
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
            "status.required" => "Category status is required.",
        ];
    }
}
