<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class WebSettingPolicy
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

    public function update(User $user): Response
    {
        return $user->admin()->exists()
            ? Response::allow()
            : Response::denyAsNotFound();
    }
}
