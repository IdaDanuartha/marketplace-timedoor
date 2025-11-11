<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Interfaces\AuthRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;
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
            $googleUser = Socialite::driver('google')->user();

            // cari apakah user sudah pernah terdaftar
            $user = User::where('email', $googleUser->getEmail())->first();

            if ($user) {
                Auth::login($user, true);
                if (! $user->hasVerifiedEmail()) {
                    $user->markEmailAsVerified();
                }
                return redirect()->intended(route('dashboard.index'))
                    ->with('status', 'Welcome back, '.$user->username.'!');
            }

            // simpan data sementara di session
            session([
                'google_user' => [
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'avatar' => $googleUser->getAvatar(),
                    'google_id' => $googleUser->getId(),
                ],
            ]);

            // arahkan ke halaman pilih role
            return redirect()->route('google.chooseRole');

        } catch (Throwable $e) {
            Log::error('Google OAuth error: '.$e->getMessage());
            return redirect()->route('login')
                ->withErrors(['login' => 'Failed to authenticate with Google. Please try again.']);
        }
    }

    public function chooseRole()
    {
        $googleUser = session('google_user');
        if (! $googleUser) {
            return redirect()->route('login')->withErrors(['login' => 'Session expired, please sign in again.']);
        }

        return view('auth.choose-role', compact('googleUser'));
    }

    public function completeRegister()
    {
        $googleUser = session('google_user');
        if (! $googleUser) {
            return redirect()->route('login')->withErrors(['login' => 'Session expired, please sign in again.']);
        }

        request()->validate([
            'role' => 'required|in:vendor,customer',
        ]);

        try {
            $user = $this->authRepo->registerGoogleUser($googleUser, request('role'));
            Auth::login($user, true);
            session()->forget('google_user');

            return redirect()->route('dashboard.index')->with('status', 'Account created successfully!');
        } catch (Throwable $e) {
            Log::error('Google register error: '.$e->getMessage());
            return redirect()->route('login')->withErrors(['register' => 'Failed to complete registration.']);
        }
    }
}