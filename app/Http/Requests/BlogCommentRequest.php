<?php

namespace App\Http\Requests;

use App\Rules\RecaptchaRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BlogCommentRequest extends FormRequest
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
            "blog_post_id" => ["required","numeric",Rule::exists("blog_posts", "id")],
            "user_id" => ["required","numeric",Rule::exists("users", "id")],
            "comment" => ["required","string"],
            "captcha_token"  => ["required",new RecaptchaRule()],
        ];
    }

    /**
    *     @return array<string>
    */
    public function messages(): array
    {
        return [
            "blog_post_id.required" =>  "The blog id is required.",
            "blog_post_id.numeric" =>  "The blog id must be a number.",
            "blog_post_id.exists" =>  "The selected blog id is invalid.",
            "user_id.required" =>  "The user id is required.",
            "user_id.numeric" =>  "The user id must be a number.",
            "user_id.exists" =>  "The selected user id is invalid.",
            "comment.required" =>  "The comment is required.",
            "comment.string" =>  "The comment must be a string.",
            "captcha_token.required" => "The captcha token is required",
        ];
    }
}
