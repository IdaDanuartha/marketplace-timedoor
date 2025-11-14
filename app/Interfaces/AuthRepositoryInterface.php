<?php

namespace App\Interfaces;

use App\Models\User;

interface AuthRepositoryInterface
{
    public function register(array $data): User;
    public function attemptLogin(array $credentials, bool $remember = false): bool;
    public function registerGoogleUser(array $googleUser, string $role): User;
    public function handleGoogleCallback(): mixed;
    public function prepareGoogleSession(array $googleUser): void;
    public function requestAccountDeletion(User $user, string $password): bool;
    public function confirmAccountDeletion(int $uid, string $token): bool;
    public function sendResetPasswordLink(string $email): bool|string;
    public function resetPassword(array $data): bool|string;
    public function logout(): void;
}