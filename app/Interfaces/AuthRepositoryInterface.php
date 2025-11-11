<?php

namespace App\Interfaces;

use App\Models\User;

interface AuthRepositoryInterface
{
    public function register(array $data): User;
    public function attemptLogin(array $credentials, bool $remember = false): bool;
    public function registerGoogleUser(array $googleUser, string $role): User;
    public function logout(): void;
}