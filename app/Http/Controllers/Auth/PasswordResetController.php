<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Http\Requests\Auth\SendResetLinkRequest;
use App\Interfaces\AuthRepositoryInterface;
use Illuminate\Support\Facades\Password;

class PasswordResetController extends Controller
{
    public function __construct(private readonly AuthRepositoryInterface $authRepo) {}

    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    public function sendResetLinkEmail(SendResetLinkRequest $request)
    {
        $status = $this->authRepo->sendResetPasswordLink($request->email);

        return $status === Password::RESET_LINK_SENT
            ? back()->with('success', __($status))
            : back()->withErrors(['email' => __($status)]);
    }

    public function showResetForm(string $token)
    {
        return view('auth.passwords.reset', [
            'token' => $token,
            'email' => request('email')
        ]);
    }

    public function reset(ResetPasswordRequest $request)
    {
        $status = $this->authRepo->resetPassword($request->only(
            'email','password','password_confirmation','token'
        ));

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('success', __($status))
            : back()->withErrors(['email' => __($status)]);
    }
}