<?php

namespace App\Http\Requests;

use App\Rules\RecaptchaRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RoleInPermissionRequest extends FormRequest
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
            "role_id"=>["required","numeric",Rule::exists("roles", "id")],
            "permission_id"=>["required","array",Rule::exists("permissions", "id")],
            "captcha_token"  => ["required",new RecaptchaRule()],
        ];
    }

    /**
    *     @return array<string>
    */
    public function messages(): array
    {
        return [
            "role_id.required" =>  "The role id is required.",
            "role_id.numeric" =>  "The role id must be a number.",
            "role_id.exists" =>  "The selected role id is invalid.",
            "permission_id.required" =>  "The permission id is required.",
            "permission_id.array" =>  "The permission id must be an array.",
            "permission_id.exists" =>  "The selected permission id is invalid.",
            "captcha_token.required"=>"The captcha token is required",
        ];
    }
}
