<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WebsiteFeedbackRequest extends FormRequest
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
            "email"=>["required","email","string"],
            "feedback_text"=>["required","string"],
            "rating"=>["required","numeric"],
        ];
    }

    /**
    *     @return array<string>
    */
    public function messages(): array
    {
        return [
            "email.required" => "The email address field is required.",
            "email.string" => "The email address must be a string.",
            "email.email" =>  "The email address must be a valid email address.",
            "feedback_text.required" =>  "The feedback text is required.",
            "feedback_text.string" =>  "The feedback text must be a string.",
            "rating.required" =>  "The rating is required.",
            "rating.numeric" =>  "The rating must be a number.",
        ];
    }
}
