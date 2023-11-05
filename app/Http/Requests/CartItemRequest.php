<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CartItemRequest extends FormRequest
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
            'cart_id' => ['nullable', 'numeric', Rule::exists('carts', 'id')],
            'product_id' => ['required', 'numeric', Rule::exists('products', 'id')],
            'shop_id' => ['required', 'numeric', Rule::exists('users', 'id')],
            'size' => ['nullable', 'string'],
            'color' => ['nullable', 'string'],
            'qty' => ['required', 'numeric'],
            'total_price' => ['required', 'numeric'],
        ];
    }

    /**
     *     @return array<string>
     */
    public function messages(): array
    {
        return [
            'cart_id.numeric' => 'The cart id must be a number.',
            'cart_id.exists' => 'The selected cart id is invalid.',
            'product_id.required' => 'The product id is required.',
            'product_id.numeric' => 'The product id must be a number.',
            'product_id.exists' => 'The selected product id is invalid.',
            'shop_id.required' => 'The shop id is required.',
            'shop_id.numeric' => 'The shop id must be a number.',
            'shop_id.exists' => 'The selected shop id is invalid.',
            'size.string' => 'The size must be a string.',
            'color.string' => 'The color must be a string.',
            'qty.required' => 'The qty is required.',
            'qty.numeric' => 'The qty must be a number.',
            'total_price.required' => 'The total price is required.',
            'total_price.numeric' => 'The total price must be a number.',
        ];
    }
}
