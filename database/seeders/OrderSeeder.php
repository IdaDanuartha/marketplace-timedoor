<?php

namespace Database\Seeders;

use App\Enum\ProductStatus;
use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Customer;
use App\Models\Product;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Creating 500 orders with items...');

        $products = Product::where('status', ProductStatus::ACTIVE)
            ->pluck('price', 'id')
            ->toArray();

        if (empty($products)) {
            $this->command->warn('⚠️ Skipping OrderSeeder: No active products found.');
            return;
        }

        $productIds = array_keys($products);
        $orderCount = 0;
        $progressStep = 100;

        // Chunk load customers to avoid memory overload
        Customer::chunk(100, function ($customers) use (&$orderCount, $progressStep, $products, $productIds) {
            foreach ($customers as $customer) {
                $ordersForCustomer = rand(3, 7);

                for ($o = 0; $o < $ordersForCustomer; $o++) {
                    if ($orderCount >= 500) return false; // stop seeding at 500 orders

                    $order = Order::factory()->create([
                        'customer_id' => $customer->id,
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

                    $order->update([
                        'total_price' => $totalPrice + $order->shipping_cost,
                    ]);

                    $orderCount++;

                    if ($orderCount % $progressStep === 0) {
                        $this->command->info("✓ {$orderCount} orders created...");
                    }
                }
            }
        });

        $this->command->info("✓ {$orderCount} Orders with items created successfully");
    }
}