<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Interfaces\AuthRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Socialite;
use Throwable;

class SocialiteController extends Controller
{
    public function __construct(private readonly AuthRepositoryInterface $authRepo) {}

    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        try {
            $result = $this->authRepo->handleGoogleCallback();

            if ($result === false) {
                return redirect()->route('login')
                    ->withErrors(['login' => 'Failed to authenticate with Google.']);
            }

            // jika sudah ada user
            if ($result instanceof \App\Models\User) {
                Auth::login($result, true);

                if (! $result->hasVerifiedEmail()) {
                    $result->markEmailAsVerified();
                }

                return redirect()->intended(route('dashboard.index'))
                    ->with('status', 'Welcome back, '.$result->username.'!');
            }

            // jika belum ada user → simpan ke session dan arahkan ke choose role
            $this->authRepo->prepareGoogleSession($result);
            return redirect()->route('google.chooseRole');

        } catch (Throwable $e) {
            Log::error('Google OAuth error: '.$e->getMessage());
            return redirect()->route('login')
                ->withErrors(['login' => 'Google authentication failed.']);
        }
    }

    public function chooseRole()
    {
        $googleUser = session('google_user');
        if (! $googleUser) {
            return redirect()->route('login')
                ->withErrors(['login' => 'Session expired, please sign in again.']);
        }

        return view('auth.choose-role', compact('googleUser'));
    }

    public function completeRegister()
    {
        $googleUser = session('google_user');
        if (! $googleUser) {
            return redirect()->route('login')
                ->withErrors(['login' => 'Session expired, please sign in again.']);
        }

        request()->validate([
            'role' => 'required|in:vendor,customer',
        ]);

        try {
            $user = $this->authRepo->registerGoogleUser($googleUser, request('role'));

            Auth::login($user, true);
            session()->forget('google_user');

            return redirect()->route('dashboard.index')
                ->with('status', 'Account created successfully!');

        } catch (Throwable $e) {
            Log::error('Google register error: '.$e->getMessage());
            return redirect()->route('login')
                ->withErrors(['register' => 'Failed to complete registration.']);
        }
    }
}