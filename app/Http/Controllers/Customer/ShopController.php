<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Interfaces\ProductRepositoryInterface;
use Illuminate\Http\Request;
use Throwable;

class ShopController extends Controller
{
    public function __construct(private readonly ProductRepositoryInterface $productRepo) {}

    public function index(Request $request)
    {
        try {
            $filters = $request->only(['search', 'category', 'vendor', 'price', 'sort']);

            $products = $this->productRepo->paginateWithFilters($filters, 12);

            return view('shop.products.index', [
                'products'   => $products,
                'categories' => \App\Models\Category::all(),
                'vendors'    => \App\Models\Vendor::all(),
            ]);

        } catch (Throwable $e) {
            report($e);
            return back()->withErrors('Failed to load products.');
        }
    }

    public function show($productSlug)
    {
        try {
            $product = $this->productRepo->findBySlug($productSlug);

            if (!$product) {
                return back()->withErrors('Product not found.');
            }

            return view('shop.products.show', compact('product'));

        } catch (Throwable $e) {
            report($e);
            return back()->withErrors('Failed to load product details.');
        }
    }
}