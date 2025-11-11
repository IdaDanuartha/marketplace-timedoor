<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Interfaces\ProductRepositoryInterface;
use App\Models\Product;
use App\Models\Category;
use App\Models\Vendor;
use Illuminate\Support\Facades\Log;
use Throwable;

class ProductController extends Controller
{
    public function __construct(
        protected readonly ProductRepositoryInterface $products
    )
    {
        $this->authorizeResource(Product::class, 'product');
    }

    public function index()
    {
        try {
            $filters = request()->only(['search', 'sort_by', 'sort_dir', 'status']);
            $products = $this->products->paginateWithFilters($filters, 10);
            return view('admin.products.index', compact('products', 'filters'));
        } catch (Throwable $e) {
            Log::error('Failed to load products: ' . $e->getMessage());
            return back()->withErrors('Failed to load products.');
        }
    }

    public function create()
    {
        try {
            $vendors = Vendor::latest()->get();
            $categories = Category::with('children')->whereNull('parent_id')->get();

            return view('admin.products.create', compact('vendors', 'categories'));
        } catch (Throwable $e) {
            Log::error('Failed to open create form: ' . $e->getMessage());
            return back()->withErrors('Unable to open create form.');
        }
    }

    public function store(StoreProductRequest $request)
    {
        try {
            $this->products->create($request->validated());
            return redirect()
                ->route('products.index')
                ->with('success', 'Product created successfully.');
        } catch (Throwable $e) {
            Log::error('Failed to create product: ' . $e->getMessage());
            return back()->withInput()->withErrors('Failed to create product.');
        }
    }

    public function show(Product $product)
    {
        try {
            $product->load(['category', 'vendor']);
            return view('admin.products.show', compact('product'));
        } catch (Throwable $e) {
            Log::error('Failed to load product details: ' . $e->getMessage());
            return back()->withErrors('Unable to load product details.');
        }
    }


    public function edit(Product $product)
    {
        try {
            $vendors = Vendor::latest()->get();
            $categories = Category::with('children')->whereNull('parent_id')->get();

            return view('admin.products.edit', compact('product', 'vendors', 'categories'));
        } catch (Throwable $e) {
            Log::error('Failed to open edit form: ' . $e->getMessage());
            return back()->withErrors('Unable to open edit form.');
        }
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        try {
            $this->products->update($product, $request->validated());
            return redirect()
                ->route('products.index')
                ->with('success', 'Product updated successfully.');
        } catch (Throwable $e) {
            Log::error('Failed to update product: ' . $e->getMessage());
            return back()->withInput()->withErrors('Failed to update product.');
        }
    }

    public function destroy(Product $product)
    {
        try {
            $this->products->delete($product);
            return redirect()
                ->route('products.index')
                ->with('success', 'Product deleted successfully.');
        } catch (Throwable $e) {
            Log::error('Failed to delete product: ' . $e->getMessage());
            return back()->withErrors('Failed to delete product.');
        }
    }
}