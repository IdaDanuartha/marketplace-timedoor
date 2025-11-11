<?php

namespace App\Repositories;

use App\Enum\OrderStatus;
use App\Interfaces\OrderRepositoryInterface;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class OrderRepository implements OrderRepositoryInterface
{
    public function all()
    {
        return Order::with(['customer', 'items.product'])->latest()->get();
    }

    public function paginateWithFilters(array $filters, int $perPage = 10)
    {
        $query = Order::with(['customer'])->latest();

        if (!empty($filters['search'])) {
            $search = trim($filters['search']);
            $query->where(function ($q) use ($search) {
                $q->where('code', 'like', "%{$search}%")
                  ->orWhereHas('customer', fn($c) => $c->where('name', 'like', "%{$search}%"));
            });
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        return $query->paginate($perPage)->appends($filters);
    }

    public function find($id): ?Order
    {
        return Order::with(['customer', 'items.product'])->find($id);
    }

    public function create(array $data): Order
    {
        return DB::transaction(function () use ($data) {
            $data['status'] = OrderStatus::from($data['status']);

            $order = Order::create([
                'code' => $data['code'] ?? 'ORD-' . strtoupper(uniqid()),
                'customer_id' => $data['customer_id'],
                'total_price' => $data['total_price'],
                'shipping_cost' => $data['shipping_cost'],
                'status' => $data['status'],
            ]);

            foreach ($data['items'] ?? [] as $item) {
                $order->items()->create([
                    'product_id' => $item['product_id'],
                    'qty' => $item['qty'],
                    'price' => $item['price'],
                ]);
            }

            return $order;
        });
    }

    public function update(Order $order, array $data): Order
    {
        return DB::transaction(function () use ($order, $data) {
            $data['status'] = OrderStatus::from($data['status']);
            $order->update(Arr::except($data, ['items']));

            if (isset($data['items'])) {
                $order->items()->delete();
                foreach ($data['items'] as $item) {
                    $order->items()->create([
                        'product_id' => $item['product_id'],
                        'qty' => $item['qty'],
                        'price' => $item['price'],
                    ]);
                }
            }

            return $order;
        });
    }

    public function delete(Order $order): bool
    {
        return DB::transaction(fn() => $order->delete());
    }
}