<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\{Favorite, Product};
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index()
    {
        $customer = Auth::user()->customer;
        $wishlist = Favorite::with('product.category')
            ->where('customer_id', $customer->id)
            ->latest()
            ->get();

        return view('shop.wishlist.index', compact('wishlist'));
    }

    public function toggle(Product $product)
    {
        $customer = Auth::user()->customer;

        $existing = Favorite::where('customer_id', $customer->id)
            ->where('product_id', $product->id)
            ->first();

        if ($existing) {
            $existing->delete();
            return back()->with('success', 'Removed from wishlist.');
        }

        Favorite::create([
            'customer_id' => $customer->id,
            'product_id' => $product->id,
        ]);

        return back()->with('success', 'Added to wishlist.');
    }
}