<?php

namespace App\Interfaces;

use App\Models\Product;
use App\Models\Review;

interface ReviewRepositoryInterface
{
    public function getCustomerReviews(int $customerId);
    public function canReviewProduct(int $customerId, int $productId): bool;
    public function saveReview(int $customerId, Product $product, array $data): bool|string;
    public function deleteReview(Review $review, int $customerId): bool|string;
}