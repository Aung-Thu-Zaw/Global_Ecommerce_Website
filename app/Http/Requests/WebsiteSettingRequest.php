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
            "phone"=>["nullable","string"],
            "support_phone"=>["nullable","string"],
            "email"=>["nullable","email"],
            "company_address"=>["nullable","string"],
            "copyright"=>["nullable","string"],
            "facebook"=>["nullable","url"],
            "twitter"=>["nullable","url"],
            "instagram"=>["nullable","url"],
            "youtube"=>["nullable","url"],
            "reddit"=>["nullable","url"],
            "linked_in"=>["nullable","url"],
        ];
    }

    /**
    *     @return array<string>
    */
    public function messages(): array
    {
        return [
            "phone.string" => "The phone must be a string.",
            "support_phone.string" => "The support phone must be a string.",
            "email.email" =>  "The email address must be a valid email address.",
            "company_address.string" => "The company address must be a string.",
            "copyright.string" => "The copyright must be a string.",
            "facebook.url" => "The facebook must be a valid URL.",
            "twitter.url" => "The twitter must be a valid URL.",
            "instagram.url" => "The instagram must be a valid URL.",
            "youtube.url" => "The youtube must be a valid URL.",
            "reddit.url" => "The reddit must be a valid URL.",
            "linked_in.url" => "The linked in must be a valid URL.",
        ];
    }
}
