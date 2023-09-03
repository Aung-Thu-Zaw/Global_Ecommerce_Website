<?php

namespace App\Http\Requests;

use App\Rules\RecaptchaRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LiveChatMessageRequest extends FormRequest
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
        $rules = [
            "live_chat_id" => ["required","numeric",Rule::exists("live_chats", "id")],
            "user_id" => ["nullable","numeric",Rule::exists("users", "id")],
            "agent_id" => ["nullable","numeric",Rule::exists("users", "id")],
            "message" => ["nullable","string"],
            "captcha_token" => ["required",new RecaptchaRule()],
        ];

        if ($this->hasFile("files")) {
            $rules['files.*'] = ['required','file','mimetypes:image/jpeg,image/png,image/gif,image/webp,image/jpg,image/svg,video/avi,video/mpeg,video/mp4,video/webm,application/pdf,
                                 application/msword,application/vnd.ms-excel,application/vnd.ms-powerpoint,text/plain,text/csv,audio/mpeg,audio/wav,audio/ogg,application/zip,application/x-rar-compressed,application/x-7z-compressed'];
        }

        return $rules;
    }

    /**
    *     @return array<string>
    */
    public function messages(): array
    {
        return [
            "agent_id.numeric" =>  "The agent id must be a number.",
            "agent_id.exists" =>  "The selected agent id is invalid.",
            "user_id.numeric" =>  "The user id must be a number.",
            "user_id.exists" =>  "The selected user id is invalid.",
            "live_chat_id.required" =>  "The live chat id is required.",
            "live_chat_id.numeric" =>  "The live chat id must be a number.",
            "live_chat_id.exists" =>  "The selected live chat id is invalid.",
            "message.string" =>  "The shop id must be a string.",
            "captcha_token.required" => "The captcha token is required",
        ];
    }
}
