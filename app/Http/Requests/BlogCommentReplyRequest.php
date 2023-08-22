<?php

namespace App\Http\Requests;

use App\Rules\RecaptchaRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BlogCommentReplyRequest extends FormRequest
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
            "blog_comment_id" => ["required","numeric",Rule::exists("blog_comments", "id")],
            "author_id" => ["required","numeric",Rule::exists("users", "id")],
            "reply_text" => ["required","string"],
            "captcha_token"  => ["required",new RecaptchaRule()],
        ];
    }

    /**
    *     @return array<string>
    */
    public function messages(): array
    {
        return [
            "blog_comment_id.required" =>  "The blog comment id is required.",
            "blog_comment_id.numeric" =>  "The blog comment id must be a number.",
            "blog_comment_id.exists" =>  "The selected blog comment id is invalid.",
            "author_id.required" =>  "The author id is required.",
            "author_id.numeric" =>  "The author id must be a number.",
            "author_id.exists" =>  "The selected author id is invalid.",
            "reply_text.required" =>  "The reply text is required.",
            "reply_text.string" =>  "The reply text must be a string.",
            "captcha_token.required" => "The captcha token is required",
        ];
    }
}
