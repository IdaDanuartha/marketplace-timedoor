<?php

namespace App\Repositories;

use App\Interfaces\CustomerRepositoryInterface;
use App\Models\{Address, Customer, CustomerAddress, User};
use App\Services\HandleFileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Throwable;

class CustomerRepository implements CustomerRepositoryInterface
{
    public function __construct(
        protected HandleFileService $fileService
    ) {}

    public function all()
    {
        return Customer::with(['user', 'addresses'])->latest()->get();
    }

    public function paginateWithFilters(array $filters, int $perPage = 10)
    {
        $query = Customer::with(['user', 'addresses']);

        if (!empty($filters['search'])) {
            $search = trim($filters['search']);
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('phone', 'like', "%{$search}%")
                ->orWhereHas('user', fn($q) =>
                    $q->where('username', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%"));
        }

        $sortBy = $filters['sort_by'] ?? 'created_at';
        $sortDir = $filters['sort_dir'] ?? 'desc';

        return $query->orderBy($sortBy, $sortDir)
            ->paginate($perPage)
            ->appends($filters);
    }

    public function find($id): ?Customer
    {
        return Customer::with(['user', 'addresses'])->find($id);
    }

    public function create(array $data, Request $request)
    {
        return DB::transaction(function () use ($data, $request) {
            // Create new user
            $user = new User();
            $user->username = $data['username'];
            $user->email = $data['email'];
            $user->password = Hash::make($data['password']);

            // Upload profile image
            if ($request->hasFile('profile_image')) {
                $user->profile_image = $this->fileService->uploadImage(
                    $request->file('profile_image'),
                    'profiles'
                );
            }
            $user->save();

            // Create customer
            $customer = Customer::create([
                'user_id' => $user->id,
                'name' => $data['name'],
                'phone' => $data['phone'] ?? null,
            ]);

            // Save addresses
            $this->syncAddresses($customer, $data['addresses'] ?? []);

            return $customer;
        });
    }

    public function update(Customer $customer, array $data, Request $request): Customer
    {
        return DB::transaction(function () use ($customer, $data, $request) {
            $user = $customer->user;
            $user->username = $data['username'];
            $user->email = $data['email'];

            if (!empty($data['password'])) {
                $user->password = Hash::make($data['password']);
            }

            // Update profile image
            if ($request->hasFile('profile_image')) {
                $this->fileService->deleteFile($user->profile_image);
                $user->profile_image = $this->fileService->uploadImage(
                    $request->file('profile_image'),
                    'profiles'
                );
            }
            $user->save();

            // Update customer info
            $customer->update([
                'name' => $data['name'],
                'phone' => $data['phone'] ?? null,
            ]);

            // Sync addresses
            $this->syncAddresses($customer, $data['addresses'] ?? []);

            return $customer;
        });
    }

    public function delete(Customer $customer): bool
    {
        try {
            return DB::transaction(function () use ($customer) {
                $customer->addresses()->detach();
                $customer->delete();
                return true;
            });
        } catch (Throwable $e) {
            Log::error('Error deleting customer: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Sync customer addresses with new structure.
     */
    private function syncAddresses(Customer $customer, array $addresses): void
    {
        // Remove old links
        $customer->addresses()->detach();

        foreach ($addresses as $addr) {
            $address = Address::create([
                'full_address' => $addr['full_address'] ?? '',
                'additional_information' => $addr['additional_information'] ?? null,
                'postal_code' => $addr['postal_code'] ?? '',
                'latitude' => $addr['latitude'] ?? null,
                'longitude' => $addr['longitude'] ?? null,
                'label' => $addr['label'] ?? 'Home',
                'is_default' => (bool) ($addr['is_default'] ?? false),
            ]);

            CustomerAddress::create([
                'customer_id' => $customer->id,
                'address_id' => $address->id,
            ]);
        }

        // Ensure only one default address
        $defaultIds = $customer->addresses()->where('is_default', true)->pluck('id');

        if ($defaultIds->count() > 1) {
            $customer->addresses()
                ->whereNotIn('id', [$defaultIds->first()])
                ->update(['is_default' => false]);
        }

        if ($defaultIds->isEmpty() && $customer->addresses()->exists()) {
            $customer->addresses()->first()->update(['is_default' => true]);
        }
    }
}