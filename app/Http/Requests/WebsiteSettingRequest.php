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
            "reddit"=>["nullable","url"],
            "linked_in"=>["nullable","url"],
            "blog"=>["nullable","url"],
        ];
    }

    /**
    *     @return array<string>
    */
    public function messages(): array
    {
        return [
            "phone.numeric" => "Phone must be number.",
            "support_phone.numeric" => "Support Phone must be number.",
            "facebook.url" => "Facebook url wrong format.",
            "twitter.url" => "Twitter url wrong format.",
            "instagram.url" => "Instagram url wrong format.",
            "youtube.url" => "Youtube url wrong format.",
            "reddit.url" => "Reddit url wrong format.",
            "linked_in.url" => "Linked In url wrong format.",
            "blog.url" => "Blog url wrong format.",
        ];
    }
}
