<?php

namespace App\Policies;

use App\Models\Cart;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CartPolicy
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
        return $user->customer()->exists()
            ? Response::allow()
            : Response::denyAsNotFound();
    }

    public function view(User $user, Cart $cart): Response
    {
        return $user->customer()->exists() && $cart->customer_id === $user->customer->id
            ? Response::allow()
            : Response::denyAsNotFound();
    }

    public function create(User $user): Response
    {
        return $user->customer()->exists()
            ? Response::allow()
            : Response::denyAsNotFound();
    }

    public function update(User $user, Cart $cart): Response
    {
        return $user->customer()->exists() && $cart->customer_id === $user->customer->id
            ? Response::allow()
            : Response::denyAsNotFound();
    }

    public function delete(User $user, Cart $cart): Response
    {
        return $user->customer()->exists() && $cart->customer_id === $user->customer->id
            ? Response::allow()
            : Response::denyAsNotFound();
    }
}
