<?php

namespace App\Interfaces;

use App\Models\Product;
use App\Models\Favorite;

interface WishlistRepositoryInterface
{
    public function getCustomerWishlist(int $customerId);
    public function toggle(int $customerId, Product $product): bool|string;
}