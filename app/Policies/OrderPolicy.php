<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class OrderPolicy
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
        return ($user->admin || $user->vendor)
            ? Response::allow()
            : Response::denyAsNotFound();
    }

    public function view(User $user, Order $order): Response
    {
        if ($user->admin) return Response::allow();

        if ($user->vendor && $order->items()->whereHas('product', fn($q) => 
            $q->where('vendor_id', $user->vendor->id)
        )->exists()) {
            return Response::allow();
        }

        return Response::denyAsNotFound();
    }

    public function create(User $user): Response
    {
        return $user->admin()->exists()
            ? Response::allow()
            : Response::denyAsNotFound();
    }

    public function update(User $user, Order $order): Response
    {
        if ($user->admin) return Response::allow();

        if ($user->vendor && $order->items()->whereHas('product', fn($q) => 
            $q->where('vendor_id', $user->vendor->id)
        )->exists()) {
            return Response::allow();
        }

        return Response::denyAsNotFound();
    }

    public function delete(User $user, Order $order): Response
    {
        return $user->admin()->exists()
            ? Response::allow()
            : Response::denyAsNotFound();
    }
}
