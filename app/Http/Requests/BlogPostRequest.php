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
            "blog_category_id"=>["required","numeric",Rule::exists("blog_categories", "id")],
            "author_id"=>["required","numeric",Rule::exists("users", "id")],
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
            "blog_category_id.required" =>  "The blog category id is required.",
            "blog_category_id.numeric" =>  "The blog category id must be a number.",
            "blog_category_id.exists" =>  "The selected blog category id is invalid.",
            "author_id.required" =>  "The author id is required.",
            "author_id.numeric" =>  "The author id must be a number.",
            "author_id.exists" =>  "The selected author id is invalid.",
            "title.required" =>  "The title field is required.",
            "title.string" =>  "The title must be a string.",
            "title.max" => "The title must not be greater than 255 characters.",
            "title.unique" =>'The title has already been taken.',
            "description.required" =>  "The description field is required.",
            "description.string" =>  "The description must be a string.",
        ];
    }
}
