<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SubscriberRequest extends FormRequest
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
            "email"=>["required","email","string",Rule::unique("subscribers", "email")]
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
            "email.unique"=>"The email has already been subscribed."
        ];
    }

}
