<?php

namespace App\Policies;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CustomerPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function viewAny(User $user): Response
    {
        return $user->admin()->exists()
            ? Response::allow()
            : Response::denyAsNotFound();
    }

    public function view(User $user, Customer $customer): Response
    {
        return $user->admin()->exists()
            ? Response::allow()
            : Response::denyAsNotFound();
    }

    public function create(User $user): Response
    {
        return $user->admin()->exists()
            ? Response::allow()
            : Response::denyAsNotFound();
    }

    public function update(User $user, Customer $customer): Response
    {
        return $user->admin()->exists()
            ? Response::allow()
            : Response::denyAsNotFound();
    }

    public function delete(User $user, Customer $customer): Response
    {
        return $user->admin()->exists()
            ? Response::allow()
            : Response::denyAsNotFound();
    }
}
