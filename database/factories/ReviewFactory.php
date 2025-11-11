<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Review;

class ReviewFactory extends Factory
{
    protected $model = Review::class;

    public function definition(): array
    {
        return [
            'rating' => fake()->numberBetween(1, 5),
            'comment' => fake()->boolean(70) ? fake()->paragraph(2) : null, // 70% have comments
            // 'created_at' => fake()->dateTimeBetween('-1 year', 'now'),
            // 'updated_at' => now(),
        ];
    }
}