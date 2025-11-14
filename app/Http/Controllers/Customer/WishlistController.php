<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Interfaces\WishlistRepositoryInterface;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Throwable;

class WishlistController extends Controller
{
    public function __construct(
        private readonly WishlistRepositoryInterface $wishlistRepo
    ) {}

    public function index()
    {
        try {
            $customer = Auth::user()->customer;
            $wishlist = $this->wishlistRepo->getCustomerWishlist($customer->id);

            return view('shop.wishlist.index', compact('wishlist'));

        } catch (Throwable $e) {
            report($e);
            return back()->withErrors('Failed to load wishlist.');
        }
    }

    public function toggle(Product $product)
    {
        try {
            $customer = Auth::user()->customer;

            $result = $this->wishlistRepo->toggle($customer->id, $product);

            return match ($result) {
                'added'   => back()->with('success', 'Added to wishlist.'),
                'removed' => back()->with('success', 'Removed from wishlist.'),
                default   => back()->withErrors($result),
            };

        } catch (Throwable $e) {
            report($e);
            return back()->withErrors('Failed to update wishlist.');
        }
    }
}