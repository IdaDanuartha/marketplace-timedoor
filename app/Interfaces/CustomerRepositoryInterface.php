<?php

namespace App\Interfaces;

use App\Models\Customer;
use Illuminate\Http\Request;

interface CustomerRepositoryInterface
{
    public function all();
    public function paginateWithFilters(array $filters, int $perPage = 10);
    public function find($id): ?Customer;
    public function create(array $data, Request $request);
    public function update(Customer $customer, array $data, Request $request);
    public function delete(Customer $customer): bool;
}