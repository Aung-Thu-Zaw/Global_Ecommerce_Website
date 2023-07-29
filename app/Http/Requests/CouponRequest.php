<?php

namespace App\Http\Requests;

use App\Rules\RecaptchaRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CouponRequest extends FormRequest
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
            "code"=>["required","string",Rule::unique("coupons", "code")],
            "discount_type"=>["required",Rule::in(["percentage", "fixed_amount"])],
            "discount_amount"=>["required","numeric"],
            "min_spend"=>["required","numeric"],
            "start_date"=>["required","date"],
            "end_date"=>["required","date"],
            "max_uses"=>["required","numeric"],
            'captcha_token'  => ['required',new RecaptchaRule()],
        ];

        $route = $this->route();
        if ($route&&in_array($this->method(), ['POST','PUT', 'PATCH'])) {
            $coupon = $route->parameter('coupon');
            $rules["code"]=["required","string",Rule::unique("coupons", "code")->ignore($coupon)];
        }

        return $rules;
    }

    /**
    *     @return array<string>
    */
    public function messages(): array
    {
        return [
            "code.required" => "The code field is required.",
            "code.string" => "The code must be a string.",
            "code.unique" =>'The code has already been taken.',
            "discount_type.required" => "The discount type field is required.",
            "discount_type.in"=>"The selected discount type is invalid.",
            "discount_amount.required" => "The discount amount field is required.",
            "discount_amount.numeric" => "The discount amount must be a number.",
            "min_spend.required" => "The min spend field is required.",
            "min_spend.numeric" => "The min spend must be a number.",
            "start_date.required" => "The start date field is required.",
            "start_date.date" => "The start date is not a valid date.",
            "end_date.required" => "The end date field is required.",
            "end_date.date" => "The end date is not a valid date.",
            "max_uses.required" => "The max uses field is required.",
            "max_uses.numeric" => "The max uses must be a number.",
            "captcha_token.required"=>"The captcha token is required",
        ];
    }
}
