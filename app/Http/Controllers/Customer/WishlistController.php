<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlist = Auth::user()->customer?->wishlistProducts()->with('category')->get() ?? collect();
        return view('shop.wishlist.index', compact('wishlist'));
    }

    public function store(Product $product)
    {
        $customer = Auth::user()->customer;
        $customer->wishlistProducts()->syncWithoutDetaching([$product->id]);
        return back()->with('success', 'Product added to wishlist.');
    }

    public function destroy(Product $product)
    {
        $customer = Auth::user()->customer;
        $customer->wishlistProducts()->detach($product->id);
        return back()->with('success', 'Product removed from wishlist.');
    }
}
