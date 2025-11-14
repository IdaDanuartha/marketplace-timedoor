<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Interfaces\ReviewRepositoryInterface;
use App\Models\{Product, Review};
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Throwable;

class ReviewController extends Controller
{
    public function __construct(private readonly ReviewRepositoryInterface $reviewRepo) {}

    public function index()
    {
        try {
            $customer = Auth::user()->customer;
            $reviews = $this->reviewRepo->getCustomerReviews($customer->id);

            return view('shop.reviews.index', compact('reviews'));

        } catch (Throwable $e) {
            report($e);
            return back()->withErrors('Failed to load your reviews.');
        }
    }

    public function store(Request $request, Product $product)
    {
        try {
            $request->validate([
                'rating' => 'required|integer|min:1|max:5',
                'comment' => 'nullable|string|max:1000',
            ]);

            $customer = Auth::user()->customer;

            $allowed = $this->reviewRepo->canReviewProduct($customer->id, $product->id);

            if (!$allowed) {
                return back()->withErrors('You can only review products you’ve purchased and received.');
            }

            $result = $this->reviewRepo->saveReview($customer->id, $product, $request->only('rating', 'comment'));

            if ($result !== true) {
                return back()->withErrors($result);
            }

            return back()->with('success', 'Your review has been submitted!');

        } catch (Throwable $e) {
            report($e);
            return back()->withErrors('Failed to submit review.');
        }
    }

    public function destroy(Review $review)
    {
        try {
            $customer = Auth::user()->customer;

            $result = $this->reviewRepo->deleteReview($review, $customer->id);

            if ($result !== true) {
                return back()->withErrors($result);
            }

            return back()->with('success', 'Your review has been deleted.');

        } catch (Throwable $e) {
            report($e);
            return back()->withErrors('Failed to delete review.');
        }
    }
}