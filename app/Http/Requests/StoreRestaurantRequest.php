<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRestaurantRequest extends FormRequest
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
            'rest_name' => ['required', 'string', 'max:50'],
            'rest_phone' => ['required', 'string', 'max:15'],
            'rest_desc' => ['nullable', 'string', 'max:255'],
            'rest_logo' => ['nullable', 'image'],
            'location' => ['required', 'string', 'max:255'],
            'open_at' => ['required', 'string', 'max:5'],
            'close_at' => ['required', 'string', 'max:5'],
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'city_id' => ['required', 'integer', 'exists:cities,id']
        ];
    }
}
