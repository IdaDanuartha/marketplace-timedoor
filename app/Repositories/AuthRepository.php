<?php

namespace App\Repositories;

use App\Interfaces\AuthRepositoryInterface;
use App\Models\User;
use App\Models\Admin;
use App\Models\Vendor;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Throwable;

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

                // role creation
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

    public function registerGoogleUser(array $googleUser, string $role): User
    {
        $user = User::create([
            'username' => explode('@', $googleUser['email'])[0],
            'email' => $googleUser['email'],
            'password' => bcrypt(str()->random(12)),
            'profile_image' => $googleUser['avatar'],
            'google_id' => $googleUser['google_id'],
            'email_verified_at' => now(),
        ]);

        if ($role === 'vendor') {
            $user->vendor()->create(['name' => $googleUser['name']]);
        } else {
            $user->customer()->create(['name' => $googleUser['name']]);
        }

        return $user;
    }


    public function logout(): void
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
    }
}