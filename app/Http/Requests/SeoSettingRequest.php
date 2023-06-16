<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SeoSettingRequest extends FormRequest
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
            "meta_title"=>["nullable","string"],
            "meta_author"=>["nullable","string"],
            "meta_keyword"=>["nullable","string"],
            "meta_description"=>["nullable","string"],
        ];
    }

        /**
    *     @return array<string>
    */
    public function messages(): array
    {
        return [
            "meta_title.string" => "The meta title must be a string.",
            "meta_author.string" => "The meta author must be a string.",
            "meta_keyword.string" => "The meta keyword must be a string.",
            "meta_description.string" => "The meta description must be a string.",

        ];
    }
}
