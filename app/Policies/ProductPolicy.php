<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProductPolicy
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
        // Admin dan vendor bisa lihat produk
        return ($user->admin || $user->vendor)
            ? Response::allow()
            : Response::denyAsNotFound();
    }

    public function view(User $user, Product $product): Response
    {
        if ($user->admin) return Response::allow();

        if ($user->vendor && $user->vendor->id === $product->vendor_id) {
            return Response::allow();
        }

        return Response::denyAsNotFound();
    }

    public function create(User $user): Response
    {
        return ($user->admin || $user->vendor)
            ? Response::allow()
            : Response::denyAsNotFound();
    }

    public function update(User $user, Product $product): Response
    {
        if ($user->admin) return Response::allow();

        if ($user->vendor && $user->vendor->id === $product->vendor_id) {
            return Response::allow();
        }

        return Response::denyAsNotFound();
    }

    public function delete(User $user, Product $product): Response
    {
        if ($user->admin) return Response::allow();

        if ($user->vendor && $user->vendor->id === $product->vendor_id) {
            return Response::allow();
        }

        return Response::denyAsNotFound();
    }
}