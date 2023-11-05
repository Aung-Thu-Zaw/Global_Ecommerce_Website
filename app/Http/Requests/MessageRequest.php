<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MessageRequest extends FormRequest
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
            'conversation_id' => ['required', 'numeric', Rule::exists('conversations', 'id')],
            'user_id' => ['required', 'numeric', Rule::exists('users', 'id')],
            'message' => ['nullable', 'string'],
        ];
    }

    /**
     *     @return array<string>
     */
    public function messages(): array
    {
        return [
            'user_id.required' => 'The user id is required.',
            'user_id.numeric' => 'The user id must be a number.',
            'user_id.exists' => 'The selected user id is invalid.',
            'conversation_id.required' => 'The conversation id is required.',
            'conversation_id.numeric' => 'The conversation id must be a number.',
            'conversation_id.exists' => 'The selected conversation id is invalid.',
            'message.string' => 'The shop id must be a string.',
        ];
    }
}
