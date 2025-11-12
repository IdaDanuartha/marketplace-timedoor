<?php

namespace App\Repositories;

use App\Interfaces\AddressRepositoryInterface;
use App\Models\Address;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Exception;

class AddressRepository implements AddressRepositoryInterface
{
    public function allForUser(int $userId)
    {
        try {
            $customer = Customer::where('user_id', $userId)->firstOrFail();
            return $customer->addresses()->latest()->get();
        } catch (Exception $e) {
            Log::error('Failed to retrieve address list: ' . $e->getMessage());
            throw $e;
        }
    }

    public function findOrFail(int $id): Address
    {
        try {
            $address = Address::findOrFail($id);
            $customer = Auth::user()?->customer;

            if (!$customer || !$address->customers->contains($customer->id)) {
                abort(403, 'You do not have access to this address.');
            }

            return $address;
        } catch (Exception $e) {
            Log::error('Failed to find address: ' . $e->getMessage());
            throw $e;
        }
    }

    public function create(array $data, int $userId)
    {
        try {
            $customer = Customer::where('user_id', $userId)->firstOrFail();
            $address = Address::create($data);
            $customer->addresses()->attach($address->id);

            // Set as default if this is the customer's first address
            if ($customer->addresses()->count() === 1) {
                $address->update(['is_default' => true]);
            }

            return $address;
        } catch (Exception $e) {
            Log::error('Failed to create address: ' . $e->getMessage());
            throw $e;
        }
    }

    public function update(Address $address, array $data)
    {
        try {
            $customer = Auth::user()?->customer;

            if (!$customer || !$address->customers->contains($customer->id)) {
                abort(403, 'You are not authorized to update this address.');
            }

            return $address->update($data);
        } catch (Exception $e) {
            Log::error('Failed to update address (ID: ' . $address->id . '): ' . $e->getMessage());
            throw $e;
        }
    }

    public function delete(Address $address)
    {
        try {
            $customer = Auth::user()?->customer;

            if (!$customer || !$address->customers->contains($customer->id)) {
                abort(403, 'You are not authorized to delete this address.');
            }

            $customer->addresses()->detach($address->id);
            return $address->delete();
        } catch (Exception $e) {
            Log::error('Failed to delete address (ID: ' . $address->id . '): ' . $e->getMessage());
            throw $e;
        }
    }

    public function setDefault(Address $address, int $userId)
    {
        try {
            $customer = Customer::where('user_id', $userId)->firstOrFail();

            if (!$address->customers->contains($customer->id)) {
                abort(403, 'You are not authorized to change the default address.');
            }

            $customer->addresses()->update(['is_default' => false]);
            $address->update(['is_default' => true]);

            return $address;
        } catch (Exception $e) {
            Log::error('Failed to set default address (ID: ' . $address->id . '): ' . $e->getMessage());
            throw $e;
        }
    }
}