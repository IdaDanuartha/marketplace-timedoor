<?php

namespace App\Http\Controllers\Customer;

use App\Enum\OrderStatus;
use App\Http\Controllers\Controller;
use App\Models\{Product, Review, OrderItem};
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        $customer = Auth::user()->customer;
        $reviews = $customer->reviews()->with('product.category')->latest()->get();

        return view('shop.reviews.index', compact('reviews'));
    }


    public function store(Request $request, Product $product)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $customer = Auth::user()->customer;

        // Ensure customer bought this product
        $hasDelivered = OrderItem::whereHas('order', function ($q) use ($customer) {
            $q->where('customer_id', $customer->id)
              ->where('status', OrderStatus::DELIVERED);
        })->where('product_id', $product->id)->exists();

        if (! $hasDelivered) {
            return back()->withErrors('You can only review products you’ve purchased and received.');
        }

        Review::updateOrCreate(
            ['customer_id' => $customer->id, 'product_id' => $product->id],
            ['rating' => $request->rating, 'comment' => $request->comment]
        );

        return back()->with('success', 'Your review has been submitted!');
    }

    public function destroy(Review $review)
    {
        $customer = Auth::user()->customer;
        abort_unless($review->customer_id === $customer->id, 403);

        $review->delete();
        return back()->with('success', 'Your review has been deleted.');
    }
}