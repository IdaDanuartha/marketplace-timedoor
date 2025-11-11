<?php

namespace Database\Factories;

use App\Enum\OrderStatus;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Order;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        return [
            'code' => 'ORD-' . strtoupper(Str::random(8)),
            'total_price' => 0, // Will be calculated after order items
            'shipping_cost' => fake()->randomElement([10000, 15000, 20000, 25000, 30000]),
            'status' => fake()->randomElement([
                OrderStatus::PENDING,
                OrderStatus::PROCESSING,
                OrderStatus::PROCESSING,
                OrderStatus::SHIPPED,
                OrderStatus::SHIPPED,
                OrderStatus::DELIVERED,
                OrderStatus::CANCELED,
            ]), // Mostly processing/shipped
            'created_at' => fake()->dateTimeBetween('-6 months', 'now'),
            'updated_at' => now(),
        ];
    }
}