<?php

namespace App\Repositories;

use App\Interfaces\ProductRepositoryInterface;
use App\Models\Product;
use App\Services\HandleFileService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Throwable;

class ProductRepository implements ProductRepositoryInterface
{
    public function __construct(
        protected HandleFileService $fileService
    ) {}

    public function all()
    {
        return Product::with(['vendor', 'category'])->latest()->get();
    }

    public function paginateWithFilters(array $filters, int $perPage = 10)
    {
        $query = Product::with(['vendor', 'category']);

        // Filter by search
        if (!empty($filters['search'])) {
            $search = trim($filters['search']);
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhereHas('vendor', function ($vendorQuery) use ($search) {
                        $vendorQuery->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('category', function ($categoryQuery) use ($search) {
                        $categoryQuery->where('name', 'like', "%{$search}%");
                    });
            });
        }

        // Filter by status
        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        // Category filter
        if (!empty($filters['category'])) {
            $query->where('category_id', $filters['category']);
        }

        // Vendor filter
        if (!empty($filters['vendor'])) {
            $query->where('vendor_id', $filters['vendor']);
        }

        // Price filter
        if (!empty($filters['price'])) {
            [$min, $max] = explode('-', $filters['price']);
            $query->whereBetween('price', [$min, $max]);
        }


        // Sorting
        $sortBy = $filters['sort_by'] ?? 'created_at';
        $sortDir = $filters['sort_dir'] ?? 'desc';

        return $query->orderBy($sortBy, $sortDir)
                    ->paginate($perPage)
                    ->appends($filters);
    }

    public function find($id): ?Product
    {
        return Product::with(['vendor', 'category'])->find($id);
    }

    public function create(array $data): Product
    {
        return DB::transaction(function () use ($data) {
            if (isset($data['image_path']) && $data['image_path'] instanceof \Illuminate\Http\UploadedFile) {
                $data['image_path'] = $this->fileService->uploadImage($data['image_path'], 'products');
            }

            $data['slug'] = Str::slug($data['name']);
            return Product::create($data);
        });
    }

    public function update(Product $product, array $data): Product
    {
        return DB::transaction(function () use ($product, $data) {
            if (isset($data['image_path']) && $data['image_path'] instanceof \Illuminate\Http\UploadedFile) {
                $this->fileService->deleteFile($product->image_path);
                $data['image_path'] = $this->fileService->uploadImage($data['image_path'], 'products');
            }

            $data['slug'] = Str::slug($data['name']);
            $product->update($data);
            return $product;
        });
    }

    public function delete(Product $product): bool
    {
        try {
            return DB::transaction(function () use ($product) {
                return $product->delete();
            });
        } catch (Throwable $e) {
            Log::error('Error deleting product: ' . $e->getMessage());
            throw $e;
        }
    }
}