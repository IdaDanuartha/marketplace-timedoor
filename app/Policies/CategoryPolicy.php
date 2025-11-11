<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CategoryPolicy
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

    public function view(User $user, Category $category): Response
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

    public function update(User $user, Category $category): Response
    {
        return $user->admin()->exists()
            ? Response::allow()
            : Response::denyAsNotFound();
    }

    public function delete(User $user, Category $category): Response
    {
        return $user->admin()->exists()
            ? Response::allow()
            : Response::denyAsNotFound();
    }
}
