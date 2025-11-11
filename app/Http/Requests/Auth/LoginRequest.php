<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize(): bool { 
        return true; 
    }

    public function rules(): array
    {
        return [
            'login'    => ['required','string','max:100'],
            'password' => ['required','string','max:255'],
            'remember' => ['nullable'],
        ];
    }

    public function credentials(): array
    {
        $login = $this->input('login');
        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        return [
            $field    => $login,
            'password'=> $this->input('password'),
        ];
    }
}
