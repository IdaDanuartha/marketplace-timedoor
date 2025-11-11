<?php

namespace Database\Factories;

use App\Enum\ProductStatus;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Product;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $name = fake()->sentence(3);
        
        return [
            'name' => rtrim($name, '.'),
            'slug' => Str::slug($name) . '-' . Str::random(5),
            'price' => fake()->numberBetween(10000, 5000000),
            'stock' => fake()->numberBetween(0, 500),
            'image_path' => 'https://picsum.photos/seed/' . Str::random(10) . '/400/400',
            'description' => fake()->paragraph(3),
            'status' => fake()->randomElement([
                ProductStatus::ACTIVE,
                ProductStatus::ACTIVE,
                ProductStatus::ACTIVE,
                ProductStatus::DRAFT,
                ProductStatus::OUT_OF_STOCK,
            ]), // Mostly active
        ];
    }
}