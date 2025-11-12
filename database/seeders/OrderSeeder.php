<?php

namespace Database\Seeders;

use App\Enum\ProductStatus;
use Illuminate\Database\Seeder;
use App\Models\{Order, OrderItem, Customer, Product, Address};

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Seeding 500 Orders with Items and Payment Info...');

        $products = Product::where('status', ProductStatus::ACTIVE)
            ->pluck('price', 'id')
            ->toArray();

        if (empty($products)) {
            $this->command->warn('⚠️ Skipping OrderSeeder: No active products found.');
            return;
        }

        $productIds = array_keys($products);
        $addresses = Address::pluck('id')->toArray();
        $orderCount = 0;
        $progressStep = 100;

        Customer::chunk(100, function ($customers) use (&$orderCount, $progressStep, $products, $productIds, $addresses) {
            foreach ($customers as $customer) {
                $ordersForCustomer = rand(3, 7);

                for ($o = 0; $o < $ordersForCustomer; $o++) {
                    if ($orderCount >= 500) return false;

                    $addressId = !empty($addresses)
                        ? fake()->randomElement($addresses)
                        : null;

                    $order = Order::factory()->create([
                        'customer_id' => $customer->id,
                        'address_id' => $addressId,
                        'payment_status' => fake()->randomElement(['unpaid', 'paid']),
                        'payment_method' => fake()->randomElement(['gopay', 'bank_transfer', 'qris', 'shopeepay']),
                        'grand_total' => 0, // Will update later
                    ]);

                    $itemCount = rand(1, 5);
                    $orderItemsData = [];
                    $totalPrice = 0;

                    for ($i = 0; $i < $itemCount; $i++) {
                        $productId = $productIds[array_rand($productIds)];
                        $price = $products[$productId];
                        $qty = rand(1, 3);

                        $orderItemsData[] = [
                            'order_id' => $order->id,
                            'product_id' => $productId,
                            'qty' => $qty,
                            'price' => $price,
                            'created_at' => $order->created_at,
                            'updated_at' => now(),
                        ];

                        $totalPrice += $price * $qty;
                    }

                    OrderItem::insert($orderItemsData);

                    $grandTotal = $totalPrice + $order->shipping_cost;

                    $order->update([
                        'total_price' => $totalPrice,
                        'grand_total' => $grandTotal,
                    ]);

                    $orderCount++;

                    if ($orderCount % $progressStep === 0) {
                        $this->command->info("✓ {$orderCount} orders created...");
                    }
                }
            }
        });
    }
}