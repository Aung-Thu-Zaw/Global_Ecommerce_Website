<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MyAccountUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string,mixed>
     */
    public function rules(): array
    {
        $userId = $this->user() ? $this->user()->id : null;

        $rules = [
            'name' => ['string', 'max:255'],
            'email' => ['email', 'max:255', Rule::unique(User::class)->ignore($userId)],
            'phone' => ['nullable', 'min:0', 'max:25', Rule::unique(User::class)->ignore($userId)],
            'address' => ['nullable', 'min:0', 'max:150'],
            'gender' => ['required', Rule::in(['male', 'female', 'other'])],
            'birthday' => ['nullable'],
        ];

        if ($this->hasFile('avatar')) {
            $rules['avatar'] = ['required', 'image', 'mimes:png,jpg,gif,jpeg,webp'];
        }

        return $rules;
    }
}
