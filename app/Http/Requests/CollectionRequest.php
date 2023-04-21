<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CollectionRequest extends FormRequest
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
            "title"=>["required","string",Rule::unique("collections", "title")],
            "description"=>["required","string"],
        ];

        if (in_array($this->method(), ['POST','PUT', 'PATCH'])) {
            $collection = $this->route()->parameter('collection');
            $rules["title"]=["required","string",Rule::unique("collections", "title")->ignore($collection)];
        }

        return $rules;
    }
}