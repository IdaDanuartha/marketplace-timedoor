<?php

namespace App\Repositories;

use App\Enum\OrderStatus;
use App\Enum\ProductStatus;
use App\Interfaces\OrderRepositoryInterface;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\OrdersExport;
use App\Models\Cart;
use App\Models\OrderItem;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Midtrans\Snap;
use Throwable;

class OrderRepository implements OrderRepositoryInterface
{
    public function all()
    {
        try {
            return Order::with(['customer', 'items.product'])->latest()->get();
        } catch (Throwable $e) {
            report($e);
            return collect(); // return empty collection
        }
    }

    public function paginateWithFilters(array $filters, int $perPage = 10)
    {
        try {
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
                    $filters['date_to']   . ' 23:59:59',
                ]);
            }

            if (!empty($filters['vendor_id'])) {
                $query->whereHas('items.product', fn($q) =>
                    $q->where('vendor_id', $filters['vendor_id'])
                );
            }

            return $query->paginate($perPage)->appends($filters);

        } catch (Throwable $e) {
            report($e);
            return collect(); // or return empty paginator
        }
    }

    public function find($id): ?Order
    {
        try {
            return Order::with(['customer', 'items.product'])->find($id);
        } catch (Throwable $e) {
            report($e);
            return null;
        }
    }

    public function create(array $data): Order|null
    {
        try {
            return DB::transaction(function () use ($data) {
                $data['payment_status'] = $data['payment_status'] ?? 'unpaid';
                $data['shipping_cost']  = $data['shipping_cost'] ?? 0;
                $data['grand_total']    = $data['total_price'] + $data['shipping_cost'];

                $order = Order::create(Arr::only($data, [
                    'customer_id', 'address_id',
                    'total_price', 'shipping_cost', 'grand_total',
                    'status', 'payment_method', 'payment_status', 'midtrans_transaction_id'
                ]));

                foreach ($data['items'] ?? [] as $item) {
                    $order->items()->create([
                        'product_id' => $item['product_id'],
                        'qty'        => $item['qty'],
                        'price'      => $item['price'],
                    ]);
                }

                return $order;
            });

        } catch (Throwable $e) {
            report($e);
            return null;
        }
    }

    public function update(Order $order, array $data): Order|null
    {
        try {
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
                            'qty'        => $item['qty'],
                            'price'      => $item['price'],
                        ]);
                    }
                }

                return $order;
            });

        } catch (Throwable $e) {
            report($e);
            return null;
        }
    }

    public function delete(Order $order): bool
    {
        try {
            return DB::transaction(fn() => $order->delete());
        } catch (Throwable $e) {
            report($e);
            return false;
        }
    }

    public function export(array $filters)
    {
        try {
            return Excel::download(new OrdersExport($filters), 'orders-' . now()->format('YmdHis') . '.xlsx');
        } catch (Throwable $e) {
            report($e);
            return null;
        }
    }

    public function processCheckout(array $data)
    {
        try {
            return DB::transaction(function () use ($data) {

                $customer = Auth::user()->customer;

                $cart = Cart::with('items.product')
                    ->where('customer_id', $customer->id)
                    ->first();

                if (!$cart || $cart->items->isEmpty()) {
                    return [
                        'error' => 'Your cart is empty.'
                    ];
                }

                $subtotal = $cart->items->sum('subtotal');

                // Parse shipping string
                [$courier, $service, $shippingCost] = explode('|', $data['shipping_service']);
                $shippingCost = (int) $shippingCost;

                $grandTotal = $subtotal + $shippingCost;

                // Create order
                $order = Order::create([
                    'code'              => 'ORD-' . strtoupper(Str::random(8)),
                    'customer_id'       => $customer->id,
                    'address_id'        => $data['address_id'],
                    'shipping_cost'     => $shippingCost,
                    'shipping_service'  => "{$courier} {$service}",
                    'total_price'       => $subtotal,
                    'grand_total'       => $grandTotal,
                    'status'            => OrderStatus::PENDING,
                    'payment_status'    => 'UNPAID',
                    'payment_method'    => 'MIDTRANS',
                ]);

                // Items + stock update
                foreach ($cart->items as $item) {

                    $product = $item->product;

                    OrderItem::create([
                        'order_id'   => $order->id,
                        'product_id' => $item->product_id,
                        'qty'        => $item->qty,
                        'price'      => $product->price,
                    ]);

                    $remaining = $product->stock - $item->qty;

                    $product->update([
                        'stock'  => $remaining,
                        'status' => $remaining === 0 ? ProductStatus::OUT_OF_STOCK : $product->status
                    ]);

                    $item->delete();
                }

                // Midtrans payload
                $payload = [
                    'transaction_details' => [
                        'order_id'      => $order->code,
                        'gross_amount'  => $grandTotal,
                    ],
                    'customer_details' => [
                        'first_name' => $customer->name,
                        'email'      => Auth::user()->email,
                        'phone'      => $customer->phone ?? '08123456789',
                    ],
                    'enabled_payments' => [
                        'gopay',
                        'bank_transfer',
                        'qris',
                        'shopeepay'
                    ],
                    'callbacks' => [
                        'finish' => route('shop.checkout.success', $order),
                    ],
                ];

                // Snap token
                $snapToken = Snap::getSnapToken($payload);

                // Update order with token
                $order->update([
                    'midtrans_transaction_id' => $snapToken
                ]);

                return [
                    'order'     => $order,
                    'snapToken' => $snapToken,
                ];
            });

        } catch (Throwable $e) {
            report($e);
            return [
                'error' => 'Failed to process checkout. Please try again.'
            ];
        }
    }

    public function finalizeSuccess(Order $order): bool
    {
        try {
            return DB::transaction(function () use ($order) {

                $order->update([
                    'status' => OrderStatus::PROCESSING,
                    'payment_status' => 'PAID',
                ]);

                $cart = Cart::where('customer_id', $order->customer_id)->first();

                if ($cart) {
                    $cart->items()->delete();
                    $cart->update(['total_price' => 0]);
                }

                return true;
            });

        } catch (Throwable $e) {
            report($e);
            return false;
        }
    }

    public function getCustomerOrders(int $customerId, int $perPage = 10)
    {
        try {
            return Order::with(['items.product'])
                ->where('customer_id', $customerId)
                ->latest()
                ->paginate($perPage);

        } catch (Throwable $e) {
            report($e);
            return collect();
        }
    }

    public function findByCodeForCustomer(string $code, int $customerId)
    {
        try {
            return Order::with(['items.product'])
                ->where('code', $code)
                ->where('customer_id', $customerId)
                ->firstOrFail();

        } catch (Throwable $e) {
            report($e);
            return null;
        }
    }

    public function generatePayment(Order $order)
    {
        try {
            $midtransOrderId = $order->generatePaymentId();

            $payload = [
                'transaction_details' => [
                    'order_id'      => $midtransOrderId,
                    'gross_amount'  => $order->grand_total,
                ],
                'customer_details' => [
                    'first_name' => $order->customer->name,
                    'email'      => $order->customer->user->email,
                    'phone'      => $order->customer->phone,
                ],
                'enabled_payments' => ['gopay', 'bank_transfer', 'qris', 'shopeepay'],
            ];

            $snapToken = Snap::getSnapToken($payload);

            $order->update([
                'midtrans_transaction_id' => $snapToken
            ]);

            return $snapToken;

        } catch (Throwable $e) {
            report($e);
            return false;
        }
    }

    public function cancelOrder(Order $order): bool
    {
        try {
            $order->update([
                'status'         => \App\Enum\OrderStatus::CANCELED,
                'payment_status' => 'CANCELED',
            ]);

            return true;

        } catch (Throwable $e) {
            report($e);
            return false;
        }
    }
}