<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PrivacyPolicyRequest extends FormRequest
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
            "title"=>["required","string"],
            "description"=>["required","string"]
        ];
    }

    /**
    *     @return array<string>
    */
    public function messages(): array
    {
        return [
            "title.required" =>  "The title field is required.",
            "title.string" =>  "The title must be a string.",
            "description.required" =>  "The description field is required.",
            "description.string" =>  "The description must be a string.",
        ];
    }
}
