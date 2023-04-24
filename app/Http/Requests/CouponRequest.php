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
            "min_spend"=>["nullable","numeric"],
            "start_date"=>["required","date"],
            "end_date"=>["required","date"],
            "max_uses"=>["nullable","numeric"],
        ];

        if (in_array($this->method(), ['POST','PUT', 'PATCH'])) {
            $coupon = $this->route()->parameter('coupon');
            $rules["code"]=["required","string",Rule::unique("coupons", "code")->ignore($coupon)];
        }

        return $rules;
    }
}
