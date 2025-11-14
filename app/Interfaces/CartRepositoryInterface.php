<?php

namespace App\Interfaces;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;

interface CartRepositoryInterface
{
    public function getCart(int $customerId): Cart;
    public function addToCart(int $customerId, Product $product): bool|string;
    public function updateItem(CartItem $item, int $qty): bool|string;
    public function removeItem(CartItem $item): bool;
    public function clearCart(int $customerId): bool;
    public function buyNow(int $customerId, Product $product): bool|string;
}