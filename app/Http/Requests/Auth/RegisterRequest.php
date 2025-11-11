<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rule;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool { 
        return true; 
    }

    public function rules(): array
    {
        return [
            'username' => [
                'required','string','max:50',
                Rule::unique('users','username')->whereNull('deleted_at'),
            ],
            'email' => [
                'required','email:rfc,dns','max:100',
                Rule::unique('users','email')->whereNull('deleted_at'),
            ],
            'password' => [
                'required',
                Password::min(6)->letters()->numbers()->mixedCase()->uncompromised(),
                'confirmed',
            ],
            'role' => ['required','in:customer,vendor'], // admin cannot register
            'name' => ['required','string','max:100'],
            'phone' => ['nullable','string','max:30'], // just for customer
        ];
    }
}