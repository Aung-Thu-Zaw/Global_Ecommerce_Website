<?php

namespace App\Http\Requests;

use App\Rules\RecaptchaRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class AdminManageRequest extends FormRequest
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
            "name" => ["required","string","max:255"],
            "email" => ["required","string","email","max:255",Rule::unique("users", "email")],
            "phone"=>["required",Rule::unique("users", "phone")],
            "about"=>["nullable","string"],
            "address"=>["nullable","string"],
            "gender"=>["nullable",Rule::in(["male","female","other"])],
            "password" => ["required", Password::defaults()],
            "status"=>["nullable",Rule::in(["active","inactive"])],
            "birthday"=>["nullable","date"],
            "role"=>["nullable",Rule::in(["admin","vendor","user"])],
        ];

        if (in_array($this->method(), ['POST','PUT', 'PATCH'])) {
            $user = $this->route()->parameter('user');
            $rules["email"]=["required","string","email","max:255",Rule::unique("users", "email")->ignore($user)];
            $rules["phone"]=["required",Rule::unique("users", "phone")->ignore($user)];
            $rules["password"]=["nullable"];
        }

        return $rules;
    }
}
