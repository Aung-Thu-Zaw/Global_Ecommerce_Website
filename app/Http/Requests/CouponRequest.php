<?php

namespace App\Http\Requests;

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
        ];

        if (in_array($this->method(), ['POST','PUT', 'PATCH'])) {
            $coupon = $this->route()->parameter('coupon');
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
            "code.required" => "Coupon code is required.",
            "code.unique" => "Coupon code is already exist.",
            "discount_type.required" => "Coupon discount type is required.",
            "discount_amount.required" => "Coupon discount amount is required.",
            "discount_amount.numeric" => "Coupon discount amount must be number.",
            "min_spend.required" => "Coupon minimun spend is required.",
            "min_spend.numeric" => "Coupon minimun spend must be numeric.",
            "start_date.required" => "Coupon start date is required.",
            "start_date.date" => "Coupon start date must be date format.",
            "end_date.required" => "Coupon end date is required.",
            "end_date.date" => "Coupon end date is must be date format.",
            "max_uses.required" => "Coupon max usage is required.",
            "max_uses.numeric" => "Coupon max usage must be numeric.",
        ];
    }
}
