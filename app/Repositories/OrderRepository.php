<?php

namespace App\Repositories;

use App\Interfaces\OrderRepositoryInterface;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\OrdersExport;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class OrderRepository implements OrderRepositoryInterface
{
    public function all()
    {
        return Order::with(['customer', 'items.product'])->latest()->get();
    }

    public function paginateWithFilters(array $filters, int $perPage = 10)
    {
        $query = Order::with(['customer', 'items.product'])->latest();

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

        if (!empty($filters['payment_status'])) {
            $query->where('payment_status', $filters['payment_status']);
        }

        if (!empty($filters['payment_method'])) {
            $query->where('payment_method', $filters['payment_method']);
        }

        if (!empty($filters['date_from']) && !empty($filters['date_to'])) {
            $query->whereBetween('created_at', [
                $filters['date_from'] . ' 00:00:00',
                $filters['date_to'] . ' 23:59:59',
            ]);
        }

        if (!empty($filters['vendor_id'])) {
            $query->whereHas('items.product', fn($q) =>
                $q->where('vendor_id', $filters['vendor_id'])
            );
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
            $data['code'] = $data['code'] ?? 'ORD-' . strtoupper(Str::random(8));
            $data['payment_status'] = $data['payment_status'] ?? 'unpaid';
            $data['shipping_cost'] = $data['shipping_cost'] ?? 0;
            $data['grand_total'] = $data['total_price'] + $data['shipping_cost'];

            // Simpan order utama
            $order = Order::create(Arr::only($data, [
                'code', 'customer_id', 'address_id',
                'total_price', 'shipping_cost', 'grand_total',
                'status', 'payment_method', 'payment_status', 'midtrans_transaction_id'
            ]));

            // Simpan item detail
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
            $data['grand_total'] = ($data['total_price'] ?? $order->total_price)
                + ($data['shipping_cost'] ?? $order->shipping_cost);

            $order->update(Arr::only($data, [
                'status', 'payment_method', 'payment_status',
                'shipping_cost', 'grand_total'
            ]));

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

    public function export(array $filters)
    {
        return Excel::download(new OrdersExport($filters), 'orders-' . now()->format('YmdHis') . '.xlsx');
    }
}