<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Address;

class AddressFactory extends Factory
{
    protected $model = Address::class;

    public function definition(): array
    {
        return [
            'country' => 'Indonesia',
            'province' => fake()->state(),
            'city' => fake()->city(),
            'district' => fake()->citySuffix(),
            'street_address' => fake()->streetAddress(),
            'postal_code' => fake()->postcode(),
            'is_default' => false,
        ];
    }
}