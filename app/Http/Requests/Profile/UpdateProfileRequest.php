<?php

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    public function rules(): array
    {
        $rules = [
            'username' => 'required|string|alpha_dash|max:50|unique:users,username,' . Auth::id(),
            'email' => 'required|email|max:100|unique:users,email,' . Auth::id(),
            'password' => 'nullable|string|min:6|confirmed',
            'profile_image' => 'nullable|image|max:3000|mimes:jpeg,png,jpg,webp,svg',
        ];

        $user = Auth::user();

        if ($user->admin) {
            $rules['name'] = 'required|string|max:100';
        } elseif ($user->vendor) {
            $rules['name'] = 'required|string|max:100';
            $rules['address'] = 'nullable|string|max:255';
        } elseif ($user->customer) {
            $rules['name'] = 'required|string|max:100';
            $rules['phone'] = 'nullable|string|max:20';
        }

        return $rules;
    }
}