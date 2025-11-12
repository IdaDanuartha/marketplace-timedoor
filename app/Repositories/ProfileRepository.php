<?php

namespace App\Repositories;

use App\Interfaces\ProfileRepositoryInterface;
use App\Models\User;
use App\Services\HandleFileService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Throwable;

class ProfileRepository implements ProfileRepositoryInterface
{
    public function __construct(protected HandleFileService $fileService) {}

    public function update(array $data): bool
    {
        $user = User::findOrFail(Auth::id());

        return DB::transaction(function () use ($user, $data) {
            try {
                $user->username = $data['username'];
                $user->email = $data['email'];

                if (!empty($data['password'])) {
                    $user->password = Hash::make($data['password']);
                }

                // Upload profile image
                if (request()->hasFile('profile_image')) {
                    $this->fileService->deleteFile($user->profile_image);
                    $user->profile_image = $this->fileService->uploadImage(
                        request()->file('profile_image'),
                        'profiles'
                    );
                }

                $user->save();

                // Update related role model
                if ($user->admin) {
                    $user->admin->update(['name' => $data['name']]);
                } elseif ($user->vendor) {
                    $user->vendor->update([
                        'name' => $data['name'],
                        'address' => $data['address'] ?? null,
                    ]);
                } elseif ($user->customer) {
                    $user->customer->update([
                        'name' => $data['name'],
                        'phone' => $data['phone'] ?? null,
                    ]);
                }

                return true;
            } catch (Throwable $e) {
                Log::error('Profile update failed: ' . $e->getMessage());
                throw $e;
            }
        });
    }
}