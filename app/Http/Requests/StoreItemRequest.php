<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'item_title' => ['required', 'string', 'min:2', 'max:50'],
            'item_desc' => ['nullable', 'string', 'max:255'],
            'item_price' => ['required', 'integer'],
            'item_image' => ['image', 'nullable'],
            'restaurant_id' => ['required', 'integer', 'exists:restaurants,id'],
            'category_id' => ['required', 'integer', 'exists:categories,id']
        ];
    }
}
