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
            "phone"=>["required","string",Rule::unique("users", "phone")],
            "about"=>["nullable","string"],
            "address"=>["nullable","string"],
            "gender"=>["nullable",Rule::in(["male","female","other"])],
            "password" => ["required", Password::defaults()],
            "status"=>["nullable",Rule::in(["active","inactive"])],
            "birthday"=>["nullable","date"],
            "role"=>["nullable",Rule::in(["admin","vendor","user"])],
        ];

        $route = $this->route();
        if ($route&&in_array($this->method(), ['POST','PUT', 'PATCH'])) {
            $user = $route->parameter('user');
            $rules["email"]=["required","string","email","max:255",Rule::unique("users", "email")->ignore($user)];
            $rules["phone"]=["required",Rule::unique("users", "phone")->ignore($user)];
            $rules["password"]=["nullable"];
        }

        return $rules;
    }

    /**
    *     @return array<string>
    */
    public function messages(): array
    {
        return [
            "name.required" => "The name field is required.",
            "name.string" => "The name must be a string.",
            "name.max" => "The name must not be greater than 255 characters.",
            "email.required" => "The email address field is required.",
            "email.string" => "The email address must be a string.",
            "email.email" =>  "The email address must be a valid email address.",
            "email.max" => "The email address must not be greater than 255 characters.",
            "email.unique" =>'The email has already been taken.',
            "phone.required" => "The phone field is required.",
            "phone.string" => "The phone must be a string.",
            "phone.unique" =>'The phone has already been taken.',
            "about.string" => "The about must be a string.",
            "address.string" => "The address must be a string.",
            "gender.in"=>"The selected gender is invalid.",
            "password.required" =>"The password field is required.",
            "status.in"=>"The selected status is invalid.",
            "birthday.date" => "The birthday is not a valid date.",
            "role.in"=>"The selected role is invalid.",
        ];
    }
}
