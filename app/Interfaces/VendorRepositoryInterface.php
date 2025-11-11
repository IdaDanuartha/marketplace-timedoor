<?php

namespace App\Interfaces;

use App\Models\Vendor;

interface VendorRepositoryInterface
{
    public function all();
    public function paginateWithFilters(array $filters, int $perPage = 10);
    public function find($id): ?Vendor;
    public function create(array $data): Vendor;
    public function update(Vendor $vendor, array $data): Vendor;
    public function delete(Vendor $vendor): bool;
}