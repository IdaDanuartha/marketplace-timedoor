<?php

namespace App\Repositories;

use App\Interfaces\ReviewRepositoryInterface;
use App\Models\{Review, Product, OrderItem};
use App\Enum\OrderStatus;
use Illuminate\Support\Facades\DB;
use Throwable;

class ReviewRepository implements ReviewRepositoryInterface
{
    public function getCustomerReviews(int $customerId)
    {
        try {
            return Review::with('product.category')
                ->where('customer_id', $customerId)
                ->latest()
                ->get();

        } catch (Throwable $e) {
            report($e);
            return collect();
        }
    }

    public function canReviewProduct(int $customerId, int $productId): bool
    {
        try {
            return OrderItem::where('product_id', $productId)
                ->whereHas('order', function ($q) use ($customerId) {
                    $q->where('customer_id', $customerId)
                      ->where('status', OrderStatus::DELIVERED);
                })
                ->exists();

        } catch (Throwable $e) {
            report($e);
            return false;
        }
    }

    public function saveReview(int $customerId, Product $product, array $data): bool|string
    {
        try {
            return DB::transaction(function () use ($customerId, $product, $data) {
                Review::updateOrCreate(
                    ['customer_id' => $customerId, 'product_id' => $product->id],
                    ['rating' => $data['rating'], 'comment' => $data['comment']]
                );

                return true;
            });

        } catch (Throwable $e) {
            report($e);
            return 'Failed to submit review.';
        }
    }

    public function deleteReview(Review $review, int $customerId): bool|string
    {
        try {
            if ($review->customer_id !== $customerId) {
                return 'Unauthorized action.';
            }

            $review->delete();

            return true;

        } catch (Throwable $e) {
            report($e);
            return 'Failed to delete review.';
        }
    }
}