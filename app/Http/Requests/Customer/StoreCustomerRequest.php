<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class StoreCustomerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'username' => 'required|string|alpha_dash|max:50|unique:users,username',
            'email' => 'required|email|max:100|unique:users,email',
            'password' => ['required', Password::min(6)],
            'name' => 'required|string|max:100',
            'phone' => 'nullable|string|max:20',
            'profile_image' => 'nullable|image|max:5000|mimes:jpeg,png,jpg,webp,svg,gif',

            // address array validation
            'addresses' => 'required|array|min:1',
            'addresses.*.full_address' => 'required|string|max:255',
            'addresses.*.additional_information' => 'nullable|string|max:255',
            'addresses.*.postal_code' => 'nullable|string|max:20',
            'addresses.*.label' => 'required|string|in:Home,Work,Office,Other',
            'addresses.*.latitude' => 'required|numeric|between:-90,90',
            'addresses.*.longitude' => 'required|numeric|between:-180,180',
            'addresses.*.is_default' => 'boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'addresses.required' => 'At least one address must be provided.',
            'addresses.*.full_address.required' => 'The full address field is required.',
            'addresses.*.latitude.required' => 'Please pick a location on the map.',
            'addresses.*.longitude.required' => 'Please pick a location on the map.',
            'addresses.*.label.in' => 'Invalid label selected.',
        ];
    }
}