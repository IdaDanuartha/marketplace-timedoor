<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->command->info('Starting database seeding...');

        $this->call([
            AdminSeeder::class,
            VendorSeeder::class,
            CustomerSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
            OrderSeeder::class,
            ReviewSeeder::class,
            WebSettingSeeder::class,
        ]);

        $this->command->info('✓ Database seeding completed successfully!');
        $this->command->info('  Summary:');
        $this->command->info('   - 1 Admin');
        $this->command->info('   - 10 Vendors');
        $this->command->info('   - 100 Customers (with 100-200 addresses)');
        $this->command->info('   - 10 Categories (nested)');
        $this->command->info('   - 500 Products');
        $this->command->info('   - 500 Orders (with items)');
        $this->command->info('   - 1000 Reviews');
        $this->command->info('   - 1 Web Setting');
    }
}
