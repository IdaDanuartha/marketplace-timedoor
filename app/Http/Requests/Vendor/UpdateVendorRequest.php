<?php

namespace App\Http\Requests\Vendor;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UpdateVendorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:100',
            'username' => 'required|string|alpha_dash|max:50|unique:users,username,' . $this->vendor->user_id,
            'email' => 'required|email|max:50|unique:users,email,' . $this->vendor->user_id,
            'password' => ['nullable', Password::min(6)],
            'address' => 'nullable|string',
            'profile_image' => 'nullable|image|max:5000|mimes:jpeg,png,jpg,webp,svg,gif',
            'is_approved' => 'nullable',
        ];
    }
}
