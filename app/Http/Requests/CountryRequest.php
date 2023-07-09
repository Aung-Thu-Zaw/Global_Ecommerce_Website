<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CountryRequest extends FormRequest
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
            "name"=>["required","string","max:255",Rule::unique("countries", "name")],
        ];

        $route = $this->route();
        if ($route&&in_array($this->method(), ['POST','PUT', 'PATCH'])) {
            $country = $route->parameter('country');
            $rules["name"]=["required","string","max:255",Rule::unique("countries", "name")->ignore($country)];
        }

        return $rules;
    }
}
