<?php

namespace App\Repositories;

use App\Interfaces\VendorRepositoryInterface;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Throwable;

class VendorRepository implements VendorRepositoryInterface
{
    public function all()
    {
        return Vendor::with('user')->latest()->get();
    }

    public function paginateWithFilters(array $filters, int $perPage = 10)
    {
        $query = Vendor::with('user');

        if (!empty($filters['search'])) {
            $search = trim($filters['search']);
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                ->orWhereHas('user', fn($u) => $u->where('username', 'like', "%{$search}%")
                                                ->orWhere('email', 'like', "%{$search}%"));
            });
        }

        if (isset($filters['status']) && $filters['status'] !== '') {
            $query->where('is_approved', $filters['status']);
        }

        $sortBy = $filters['sort_by'] ?? 'created_at';
        $sortDir = $filters['sort_dir'] ?? 'desc';

        return $query->orderBy($sortBy, $sortDir)
                    ->paginate($perPage)
                    ->appends($filters);
    }

    public function find($id): ?Vendor
    {
        return Vendor::with('user')->find($id);
    }

    public function create(array $data): Vendor
    {
        try {
            return DB::transaction(function () use ($data) {
                $user = User::create([
                    'username' => $data['username'],
                    'email' => $data['email'],
                    'password' => Hash::make($data['password']),
                    'profile_image' => $data['profile_image'] ?? null,
                ]);

                return Vendor::create([
                    'user_id' => $user->id,
                    'name' => $data['name'],
                    'address' => $data['address'] ?? null,
                    'is_approved' => $data['is_approved'] ?? false,
                ]);
            });
        } catch (Throwable $e) {
            Log::error('Error creating vendor: ' . $e->getMessage());
            throw $e;
        }
    }

    public function update(Vendor $vendor, array $data): Vendor
    {
        try {
            return DB::transaction(function () use ($vendor, $data) {
                $user = $vendor->user;

                $user->update([
                    'username' => $data['username'],
                    'email' => $data['email'],
                    'profile_image' => $data['profile_image'] ?? $user->profile_image,
                ]);

                if (!empty($data['password'])) {
                    $user->password = Hash::make($data['password']);
                    $user->save();
                }

                $vendor->update([
                    'name' => $data['name'],
                    'address' => $data['address'] ?? null,
                    'is_approved' => $data['is_approved'] ?? false,
                ]);

                return $vendor;
            });
        } catch (Throwable $e) {
            Log::error('Error updating vendor: ' . $e->getMessage());
            throw $e;
        }
    }

    public function delete(Vendor $vendor): bool
    {
        try {
            return DB::transaction(function () use ($vendor) {
                $vendor->user()->delete();
                return $vendor->delete();
            });
        } catch (Throwable $e) {
            Log::error('Error deleting vendor: ' . $e->getMessage());
            throw $e;
        }
    }
}