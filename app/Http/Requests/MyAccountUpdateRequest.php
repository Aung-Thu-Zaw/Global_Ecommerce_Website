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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */

    public function rules(): array
    {
        $rules= [
            'name' => ['string', 'max:255'],
            'email' => ['email', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
            'phone'=>["nullable","min:0","max:25", Rule::unique(User::class)->ignore($this->user()->id)],
            'address'=>["nullable","min:0","max:150"],
            'gender'=>["required",Rule::in(['male','female','other'])],
            'birthday'=>["nullable"],
        ];


        if ($this->hasFile("avatar")) {
            $rules["avatar"]=["required","image","mimes:png,jpg,gif,jpeg,webp"];
        }



        return $rules;
    }
}
