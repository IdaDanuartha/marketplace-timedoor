<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Vendor;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'vendor'])->active();

        // search
        if ($s = $request->search) {
            $query->where('name', 'like', "%$s%");
        }

        // single category
        if ($cat = $request->category) {
            $query->where('category_id', $cat);
        }

        // single vendor
        if ($vendor = $request->vendor) {
            $query->where('vendor_id', $vendor);
        }

        // price
        if ($price = $request->price) {
            [$min, $max] = explode('-', $price);
            if ($max == 1000000) {
                $query->where('price', '>=', $min);
            } else {
                $query->whereBetween('price', [$min, $max]);
            }
        }

        // sorting
        match ($request->sort) {
            'price_low' => $query->orderBy('price', 'asc'),
            'price_high' => $query->orderBy('price', 'desc'),
            default => $query->latest(),
        };

        $products = $query->paginate(12)->appends($request->query());

        return view('shop.products.index', [
            'products' => $products,
            'categories' => \App\Models\Category::all(),
            'vendors' => \App\Models\Vendor::all(),
        ]);
    }

    public function show(Product $product)
    {
        $product->load('category', 'vendor');
        return view('shop.products.show', compact('product'));
    }
}