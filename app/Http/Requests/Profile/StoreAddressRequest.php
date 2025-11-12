<?php

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;

class StoreAddressRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'label' => 'required|string|max:100',
            'full_address' => 'required|string|max:255',
            'additional_information' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ];
    }

    public function messages(): array
    {
        return [
            'label.required' => 'Address label is required.',
            'full_address.required' => 'Full address is required.',
        ];
    }
}