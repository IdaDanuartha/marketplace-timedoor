<?php

namespace App\Repositories;

use App\Interfaces\AuthRepositoryInterface;
use App\Mail\AccountDeletionConfirmation;
use App\Models\AccountDeletionToken;
use App\Models\User;
use App\Models\Vendor;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\URL;
use Laravel\Socialite\Facades\Socialite;
use Throwable;
use Illuminate\Support\Str;

class AuthRepository implements AuthRepositoryInterface
{
    public function register(array $data): User
    {
        try {
            return DB::transaction(function () use ($data) {
                $user = User::create([
                    'username' => $data['username'],
                    'email'    => $data['email'],
                    'password' => Hash::make($data['password']),
                ]);

                if ($data['role'] === 'vendor') {
                    Vendor::create([
                        'user_id' => $user->id,
                        'name'    => $data['name'],
                    ]);
                } else {
                    Customer::create([
                        'user_id' => $user->id,
                        'name'    => $data['name'],
                        'phone'   => $data['phone'] ?? null,
                    ]);
                }

                $user->sendEmailVerificationNotification();
                return $user;
            });

        } catch (Throwable $e) {
            report($e);
            throw $e;
        }
    }

    public function attemptLogin(array $credentials, bool $remember = false): bool
    {
        try {
            return Auth::attempt($credentials, $remember);
        } catch (Throwable $e) {
            report($e);
            return false;
        }
    }

    public function handleGoogleCallback(): array|false
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            $user = User::where('email', $googleUser->getEmail())->first();
            if ($user) {
                return $user;
            }

            // kalau user belum pernah daftar, kembalikan data google mentahnya
            return [
                'name'      => $googleUser->getName(),
                'email'     => $googleUser->getEmail(),
                'avatar'    => $googleUser->getAvatar(),
                'google_id' => $googleUser->getId(),
            ];

        } catch (Throwable $e) {
            report($e);
            return false;
        }
    }

    public function prepareGoogleSession(array $googleUser): void
    {
        session([
            'google_user' => $googleUser
        ]);
    }

    public function requestAccountDeletion(User $user, string $password): bool
    {
        try {
            if (!Hash::check($password, $user->password)) {
                return false;
            }

            $rawToken = Str::random(40);

            AccountDeletionToken::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'token_hash' => hash('sha256', $rawToken),
                    'expires_at' => now()->addHour()
                ]
            );

            $url = URL::temporarySignedRoute(
                'account.deletion.confirm',
                now()->addMinutes(30),
                [
                    'uid' => $user->id,
                    'token' => $rawToken
                ]
            );

            Mail::to($user->email)->send(
                new AccountDeletionConfirmation($user->username, $url)
            );

            return true;

        } catch (Throwable $e) {
            report($e);
            return false;
        }
    }


    public function confirmAccountDeletion(int $uid, string $token): bool
    {
        try {
            $user = User::findOrFail($uid);

            $row = AccountDeletionToken::where('user_id', $uid)->first();
            if (!$row) return false;

            $valid = hash_equals($row->token_hash, hash('sha256', $token))
                && !$row->expires_at->isPast();

            if (!$valid) return false;

            DB::transaction(function () use ($user, $row) {
                if ($user->profile_image) {
                    app(\App\Services\HandleFileService::class)->deleteFile($user->profile_image);
                }

                $row->delete();
                $user->delete();
            });

            Auth::logout();
            return true;

        } catch (Throwable $e) {
            report($e);
            return false;
        }
    }


    public function sendResetPasswordLink(string $email): bool|string
    {
        try {
            return Password::sendResetLink(['email' => $email]);
        } catch (Throwable $e) {
            report($e);
            return false;
        }
    }


    public function resetPassword(array $data): bool|string
    {
        try {
            return Password::reset(
                $data,
                function ($user) use ($data) {
                    $user->forceFill([
                        'password'       => bcrypt($data['password']),
                        'remember_token' => Str::random(60),
                    ])->save();

                    event(new \Illuminate\Auth\Events\PasswordReset($user));
                }
            );
        } catch (Throwable $e) {
            report($e);
            return false;
        }
    }

    public function registerGoogleUser(array $googleUser, string $role): User
    {
        try {
            return DB::transaction(function () use ($googleUser, $role) {

                $user = User::create([
                    'username'         => explode('@', $googleUser['email'])[0],
                    'email'            => $googleUser['email'],
                    'password'         => bcrypt(str()->random(12)),
                    'profile_image'    => $googleUser['avatar'],
                    'google_id'        => $googleUser['google_id'],
                    'email_verified_at'=> now(),
                ]);

                if ($role === 'vendor') {
                    $user->vendor()->create(['name' => $googleUser['name']]);
                } else {
                    $user->customer()->create(['name' => $googleUser['name']]);
                }

                return $user;
            });

        } catch (Throwable $e) {
            report($e);
            throw $e;
        }
    }

    public function logout(): void
    {
        try {
            Auth::logout();
            request()->session()->invalidate();
            request()->session()->regenerateToken();
        } catch (Throwable $e) {
            report($e);
        }
    }
}