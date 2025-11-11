<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Vendor;

class VendorSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Creating 10 vendors...');

        User::factory()
            ->count(10)
            ->hasVendor()
            ->create();

        $this->command->info('✓ 10 Vendors created successfully');
    }
}