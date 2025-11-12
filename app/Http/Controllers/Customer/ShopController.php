<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query()->with('category');
        
        if ($search = $request->get('search')) {
            $query->where('name', 'like', "%{$search}%");
        }

        $products = $query->latest()->paginate(12);

        return view('shop.products.index', compact('products'));
    }

    public function show(Product $product)
    {
        $product->load('category', 'vendor');
        return view('shop.products.show', compact('product'));
    }
}
