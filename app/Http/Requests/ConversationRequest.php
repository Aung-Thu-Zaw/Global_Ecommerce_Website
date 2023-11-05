<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ConversationRequest extends FormRequest
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
            'customer_id' => ['required', 'numeric', Rule::exists('users', 'id')],
            'vendor_id' => ['required', 'numeric', Rule::exists('users', 'id')],
        ];
    }

    /**
     *     @return array<string>
     */
    public function messages(): array
    {
        return [
            'customer_id.required' => 'The customer id is required.',
            'customer_id.numeric' => 'The customer id must be a number.',
            'customer_id.exists' => 'The selected customer id is invalid.',
            'vendor_id.required' => 'The vendor id is required.',
            'vendor_id.numeric' => 'The vendor id must be a number.',
            'vendor_id.exists' => 'The selected vendor id is invalid.',
        ];
    }
}
