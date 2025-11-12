<?php

namespace App\Interfaces;

use App\Models\Address;

interface AddressRepositoryInterface
{
    public function allForUser(int $userId);
    public function findOrFail(int $id);
    public function create(array $data, int $userId);
    public function update(Address $address, array $data);
    public function delete(Address $address);
    public function setDefault(Address $address, int $userId);
}