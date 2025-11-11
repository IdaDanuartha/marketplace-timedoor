<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Vendor;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Creating 500 products...');

        $vendors = Vendor::pluck('id')->toArray();
        $categories = Category::pluck('id')->toArray();

        if (empty($vendors) || empty($categories)) {
            $this->command->warn('⚠️ Skipping ProductSeeder: No vendors or categories found.');
            return;
        }

        // We'll create products in 5 chunks (100 per batch)
        $totalProducts = 500;
        $chunkSize = 100;
        $chunks = ceil($totalProducts / $chunkSize);
        $createdCount = 0;

        collect(range(1, $chunks))->chunk(1)->each(function ($_, $index) use (&$createdCount, $chunkSize, $vendors, $categories) {
            $productsData = [];

            for ($i = 0; $i < $chunkSize; $i++) {
                $productsData[] = Product::factory()->make([
                    'vendor_id' => $vendors[array_rand($vendors)],
                    'category_id' => $categories[array_rand($categories)],
                ])->toArray();
            }

            Product::insert($productsData);
            $createdCount += $chunkSize;

            $this->command->info("✓ {$createdCount} products created...");
        });

        $this->command->info("✓ {$createdCount} Products created successfully");
    }
}