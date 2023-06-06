<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PermissionRequest extends FormRequest
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
            "name"=>["required","string"],
            "group"=>["required","string"],
        ];
    }

    /**
    *     @return array<string>
    */
    public function messages(): array
    {
        return [
            "name.required" => "Role name is required.",
            "group.required" => "Role group is required.",
        ];
    }
}
