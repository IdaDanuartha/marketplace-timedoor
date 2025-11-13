<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Interfaces\ProductRepositoryInterface;
use App\Models\Product;
use App\Models\Category;
use App\Models\Vendor;
use Illuminate\Support\Facades\Auth;
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
            $filters = request()->only([
                'search',
                'sort_by',
                'sort_dir',
                'category',
                'status',
                'price'
            ]);
            
            $user = Auth::user();
            if ($user->vendor) {
                // Vendor only see their own products
                $filters['vendor'] = $user->vendor->id;
            }

            if($user->admin) {
                // Admin can filter by vendor
                $filters['vendor'] = request()->get('vendor');
            }

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
            $user = Auth::user();

            // Vendor only create products for themselves
            $vendors = $user->admin ? Vendor::latest()->get() : collect([$user->vendor]);
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
            $data = $request->validated();
            $user = Auth::user();

            if ($user->vendor) {
                $data['vendor_id'] = $user->vendor->id;
            }

            $this->products->create($data);
            return redirect()->route('products.index')
                ->with('success', 'Product created successfully.');
        } catch (Throwable $e) {
            Log::error('Failed to create product: ' . $e->getMessage());
            return back()->withInput()->withErrors('Failed to create product.');
        }
    }

    public function show(Product $product)
    {
        try {
            $user = Auth::user();

            // Vendor only edit their own products
            if ($user->vendor && $product->vendor_id !== $user->vendor->id) {
                abort(404);
            }
            
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
            $user = Auth::user();

            // Vendor only edit their own products
            if ($user->vendor && $product->vendor_id !== $user->vendor->id) {
                abort(404);
            }

            $vendors = $user->admin ? Vendor::latest()->get() : collect([$user->vendor]);
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
            $user = Auth::user();
            $data = $request->validated();

            if ($user->vendor) {
                $data['vendor_id'] = $user->vendor->id;
            }

            $this->products->update($product, $data);
            return redirect()->route('products.index')
                ->with('success', 'Product updated successfully.');
        } catch (Throwable $e) {
            Log::error('Failed to update product: ' . $e->getMessage());
            return back()->withInput()->withErrors('Failed to update product.');
        }
    }

    public function destroy(Product $product)
    {
        try {
            $user = Auth::user();

            if ($user->vendor && $product->vendor_id !== $user->vendor->id) {
                abort(404);
            }

            $this->products->delete($product);
            return redirect()->route('products.index')
                ->with('success', 'Product deleted successfully.');
        } catch (Throwable $e) {
            Log::error('Failed to delete product: ' . $e->getMessage());
            return back()->withErrors('Failed to delete product.');
        }
    }
}