<?php

namespace App\Interfaces;

use App\Models\Order;

interface OrderRepositoryInterface
{
    public function all();
    public function paginateWithFilters(array $filters, int $perPage = 10);
    public function find($id): ?Order;
    public function create(array $data): Order;
    public function update(Order $order, array $data): Order;
    public function delete(Order $order): bool;
    public function export(array $filters);
}