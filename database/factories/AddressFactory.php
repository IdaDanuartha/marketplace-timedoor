<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Address;

class AddressFactory extends Factory
{
    protected $model = Address::class;

    public function definition(): array
    {
        // generate random lat long dalam area Indonesia (approx range)
        $latitude = $this->faker->latitude(-11.0, 6.0);  // Indonesia latitude range
        $longitude = $this->faker->longitude(95.0, 141.0); // Indonesia longitude range

        // generate address teks lengkap
        $street = $this->faker->streetAddress();
        $city = $this->faker->city();
        $province = $this->faker->state();
        $postal = $this->faker->postcode();

        return [
            'full_address' => "{$street}, {$city}, {$province}, Indonesia {$postal}",
            'additional_information' => $this->faker->optional()->sentence(),
            'postal_code' => $postal,
            'latitude' => $latitude,
            'longitude' => $longitude,
            'label' => $this->faker->randomElement(['Home', 'Work', 'Office', 'Apartment']),
            'is_default' => false,
        ];
    }
}