<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Creating 10 nested categories...');

        // Create 3 root categories
        $rootCategories = Category::factory()
            ->count(3)
            ->create(['parent_id' => null]);

        // Create 7 child categories (nested under root categories)
        Category::factory()
            ->count(7)
            ->create([
                'parent_id' => fn() => $rootCategories->random()->id
            ]);

        $this->command->info('✓ 10 Categories (3 root, 7 nested) created successfully');
    }
}