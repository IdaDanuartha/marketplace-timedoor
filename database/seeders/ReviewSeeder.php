<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;
use App\Models\Review;
use App\Models\User;
use App\Models\Product;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Creating 1000 reviews...');

        $customerIds = Customer::pluck('id')->toArray();
        $productIds = Product::pluck('id')->toArray();
        
        // Create reviews in chunks for efficiency
        $chunks = 5; // 5 chunks of 200 reviews each
        $perChunk = 200;

        for ($i = 0; $i < $chunks; $i++) {
            $reviewsData = [];
            
            for ($j = 0; $j < $perChunk; $j++) {
                $reviewsData[] = Review::factory()->make([
                    'customer_id' => $customerIds[array_rand($customerIds)],
                    'product_id' => $productIds[array_rand($productIds)],
                ])->toArray();
            }

            Review::insert($reviewsData);
            
            $this->command->info("✓ " . (($i + 1) * $perChunk) . " reviews created...");
        }

        $this->command->info('✓ 1000 Reviews created successfully');
    }
}