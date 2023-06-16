<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\RecaptchaRule;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;

class RegisterRequest extends FormRequest
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
            'name' => ["required","string","max:255"],
            'company_name'=>['nullable',"string","max:255"],
            'shop_name'=>['nullable',"string","max:255"],
            'email' => ["required","string","email","max:255",Rule::unique("users", "email")],
            'phone'=>['nullable','string'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'gender'=>["nullable",Rule::in(['male','female','other'])],
            'birthday'=>["nullable","date"],
            'role'=>["nullable",Rule::in(["admin","vendor","user"])],
            'status'=>["nullable",Rule::in(["active","inactive"])],
            'captcha_token'  => ['required',new RecaptchaRule()],
        ];
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
            "company_name.string" => "The company name must be a string.",
            "company_name.max" =>"The company name must not be greater than 255 characters.",
            "shop_name.string" => "The shop name must be a string.",
            "shop_name.max" =>"The shop name must not be greater than 255 characters.",
            "email.required" => "The email address field is required.",
            "email.string" => "The email address must be a string.",
            "email.email" =>  "The email address must be a valid email address.",
            "email.max" => "The email address must not be greater than 255 characters.",
            "email.unique" =>'The email has already been taken.',
            "phone.string" => "The phone must be a string.",
            "password.required" =>"The password field is required.",
            "password.confirmed" => "The password confirmation does not match.",
            "gender.in"=>"The selected gender is invalid.",
            "birthday.date" => "The birthday is not a valid date.",
            "role.in"=>"The selected role is invalid.",
            "status.in"=>"The selected status is invalid.",
            "captcha_token.required"=>"The captcha token is required",

        ];
    }

}
