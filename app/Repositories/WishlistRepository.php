<?php

namespace App\Repositories;

use App\Interfaces\WishlistRepositoryInterface;
use App\Models\{Favorite, Product};
use Illuminate\Support\Facades\DB;
use Throwable;

class WishlistRepository implements WishlistRepositoryInterface
{
    public function getCustomerWishlist(int $customerId)
    {
        try {
            return Favorite::with('product.category')
                ->where('customer_id', $customerId)
                ->latest()
                ->get();

        } catch (Throwable $e) {
            report($e);
            return collect();
        }
    }

    public function toggle(int $customerId, Product $product): bool|string
    {
        try {
            return DB::transaction(function () use ($customerId, $product) {

                $existing = Favorite::where('customer_id', $customerId)
                    ->where('product_id', $product->id)
                    ->first();

                if ($existing) {
                    $existing->delete();
                    return 'removed';
                }

                Favorite::create([
                    'customer_id' => $customerId,
                    'product_id'  => $product->id,
                ]);

                return 'added';
            });

        } catch (Throwable $e) {
            report($e);
            return 'Failed to update wishlist.';
        }
    }
}