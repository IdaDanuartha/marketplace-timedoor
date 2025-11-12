<?php

namespace App\Interfaces;

interface ProfileRepositoryInterface
{
    /**
     * Update the authenticated user's profile.
     *
     * @param array $data
     * @return bool
     */
    public function update(array $data): bool;
}