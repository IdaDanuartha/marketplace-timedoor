<?php

namespace App\Interfaces;

use App\Models\Order;

interface OrderRepositoryInterface
{
    public function all();
    public function paginateWithFilters(array $filters, int $perPage = 10);
    public function find($id): ?Order;
    public function create(array $data): Order|null;
    public function update(Order $order, array $data): Order|null;
    public function delete(Order $order): bool;
    public function export(array $filters);
    public function processCheckout(array $data);
    public function finalizeSuccess(Order $order): bool;
    public function getCustomerOrders(int $customerId, int $perPage = 10);
    public function findByCodeForCustomer(string $code, int $customerId);
    public function generatePayment(Order $order);
    public function cancelOrder(Order $order): bool;
}