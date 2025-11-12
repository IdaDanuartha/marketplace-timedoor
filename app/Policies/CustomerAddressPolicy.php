<?php

namespace App\Policies;

use App\Models\Address;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CustomerAddressPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function view(User $user, Address $address): Response
    {
        return $user->customer && $address->customers->contains('id', $user->customer->id)
            ? Response::allow()
            : Response::deny('You are not authorized to view this address.');
    }

    public function create(User $user): Response
    {
        return $user->customer
            ? Response::allow()
            : Response::deny('Only customers can create addresses.');
    }

    public function update(User $user, Address $address): Response
    {
        return $user->customer && $address->customers->contains('id', $user->customer->id)
            ? Response::allow()
            : Response::deny('You are not authorized to update this address.');
    }

    public function delete(User $user, Address $address): Response
    {
        return $user->customer && $address->customers->contains('id', $user->customer->id)
            ? Response::allow()
            : Response::deny('You are not authorized to delete this address.');
    }

    public function setDefault(User $user, Address $address): Response
    {
        return $user->customer && $address->customers->contains('id', $user->customer->id)
            ? Response::allow()
            : Response::deny('You are not authorized to set this address as default.');
    }
}
