<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BlogPostRequest extends FormRequest
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
            "blog_category_id"=>["required",Rule::exists("blog_categories", "id")],
            "author_id"=>["required",Rule::exists("users", "id")],
            "title"=>["required","string","max:255",Rule::unique("blog_posts", "title")],
            "description"=>["required","string"]
        ];

        if (in_array($this->method(), ['POST','PUT', 'PATCH'])) {
            $blog_post = $this->route()->parameter('blog_post');
            $rules["title"]=["required","string","max:255",Rule::unique("blog_posts", "title")->ignore($blog_post)];
        }

        return $rules;
    }

    /**
    *     @return array<string>
    */
    public function messages(): array
    {
        return [
            "blog_category_id.required" => "Blog category is required.",
            "blog_category_id.exists" => "Blog category does not exist.",
            "title.required" => "Blog title is required.",
            "title.unique" => "Blog title is already exists.",
            "description.required" => "Blog description is required.",
        ];
    }
}
