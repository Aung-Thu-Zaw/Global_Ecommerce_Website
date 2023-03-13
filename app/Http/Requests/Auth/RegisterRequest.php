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
            'phone'=>['nullable','numeric'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'gender'=>["nullable",Rule::in(['male','female','other'])],
            'birthday'=>["nullable","date"],
            'role'=>["nullable",Rule::in(["admin","vendor","user"])],
            'status'=>["nullable",Rule::in(["active","inactive"])],
            'captcha_token'  => ['required',new RecaptchaRule()],
        ];
    }
}
