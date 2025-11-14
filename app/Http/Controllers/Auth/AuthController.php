<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Interfaces\AuthRepositoryInterface;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Throwable;

class AuthController extends Controller
{
    public function __construct(private readonly AuthRepositoryInterface $authRepo) {}

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        try {
            $ok = $this->authRepo->attemptLogin(
                $request->credentials(),
                (bool) $request->boolean('remember')
            );

            if (! $ok) {
                throw ValidationException::withMessages([
                    'login' => 'Invalid credentials.',
                ]);
            }

            $request->session()->regenerate();

            $user = User::find(Auth::id());
            if (!$user->hasVerifiedEmail()) {
                return redirect()->route('verification.notice');
            }

            return redirect()->intended(route('admin.dashboard'));
        } catch (ValidationException $ve) {
            throw $ve;
        } catch (Throwable $e) {
            Log::error('Login error: '.$e->getMessage());
            return back()->withErrors(['login' => 'Login failed.'])->onlyInput('login');
        }
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(RegisterRequest $request)
    {
        try {
            $user = $this->authRepo->register($request->validated());
            event(new Registered($user));

            return redirect()->route('login')->with('status', 'Please verify your email before logging in.');
        } catch (Throwable $e) {
            Log::error('Register error: '.$e->getMessage());
            return back()->withErrors(['register' => 'Registration failed.'])->withInput();
        }
    }

    public function verifyEmail(Request $request)
    {
        try {
            if ($request->user()->hasVerifiedEmail()) {
                return redirect()->route('dashboard.index');
            }

            if ($request->user()->markEmailAsVerified()) {
                event(new Verified($request->user()));
            }

            return redirect()->route('dashboard.index')->with('status', 'Email verified successfully!');
        } catch (Throwable $e) {
            Log::error('Email verification error: '.$e->getMessage());
            return back()->withErrors(['verification' => 'Email verification failed.'])->withInput();
        }
    }

    public function logout(Request $request)
    {
        $this->authRepo->logout();
        return redirect()->route('login');
    }
}