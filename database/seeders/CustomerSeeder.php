<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Creating 100 customers with addresses...');

        User::factory()
            ->count(100)
            ->hasCustomer()
            ->hasAddresses(fake()->numberBetween(1, 2))
            ->create();

        $this->command->info('✓ 100 Customers with addresses created successfully');
    }
}