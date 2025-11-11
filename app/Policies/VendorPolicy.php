<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Vendor;
use Illuminate\Auth\Access\Response;

class VendorPolicy
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

    public function view(User $user, Vendor $vendor): Response
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

    public function update(User $user, Vendor $vendor): Response
    {
        return $user->admin()->exists()
            ? Response::allow()
            : Response::denyAsNotFound();
    }

    public function delete(User $user, Vendor $vendor): Response
    {
        return $user->admin()->exists()
            ? Response::allow()
            : Response::denyAsNotFound();
    }
}
