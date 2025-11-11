<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Vendor;
use App\Models\Customer;
use App\Models\Address;

class UserFactory extends Factory
{
    protected static ?string $password;

    public function definition(): array
    {
        $username = fake()->unique()->userName();
        
        return [
            'username' => $username,
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'profile_image' => 'https://ui-avatars.com/api/?name=' . urlencode($username) . '&size=200',
            'remember_token' => Str::random(10),
        ];
    }

    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    public function hasVendor(): static
    {
        return $this->afterCreating(function ($user) {
            Vendor::factory()->create([
                'user_id' => $user->id,
            ]);
        });
    }

    public function hasCustomer(): static
    {
        return $this->afterCreating(function ($user) {
            Customer::factory()->create([
                'user_id' => $user->id,
                'name' => $user->username,
            ]);
        });
    }

    public function hasAddresses(int $count = 1): static
    {
        return $this->afterCreating(function ($user) use ($count) {
            for ($i = 0; $i < $count; $i++) {
                Address::factory()->create([
                    'is_default' => $i === 0,
                ]);
            }
        });
    }
}