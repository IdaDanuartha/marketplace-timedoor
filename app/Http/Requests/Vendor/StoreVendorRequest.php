<?php

namespace App\Http\Requests\Vendor;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class StoreVendorRequest extends FormRequest
{
   public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:100',
            'username' => 'required|string|alpha_dash|max:50|unique:users,username',
            'email' => 'required|email|max:50|unique:users,email',
            'password' => ['required', Password::min(6)],
            'profile_image' => 'nullable|image|max:5000|mimes:jpeg,png,jpg,webp,svg,gif',
            'address' => 'nullable|string',
            'is_approved' => 'nullable',
        ];
    }
}
