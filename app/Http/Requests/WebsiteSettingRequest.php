<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WebsiteSettingRequest extends FormRequest
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
            "phone"=>["nullable","numeric"],
            "support_phone"=>["nullable","numeric"],
            "email"=>["nullable","email"],
            "company_address"=>["nullable","string"],
            "copyright"=>["nullable","string"],
            "facebook"=>["nullable","url"],
            "twitter"=>["nullable","url"],
            "instagram"=>["nullable","url"],
            "youtube"=>["nullable","url"],
        ];
    }
}
