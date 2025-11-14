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
        try {
            $query = Product::with(['vendor', 'category']);

            // Search
            if (!empty($filters['search'])) {
                $search = trim($filters['search']);
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhereHas('vendor', fn($v) => $v->where('name', 'like', "%{$search}%"))
                    ->orWhereHas('category', fn($c) => $c->where('name', 'like', "%{$search}%"));
                });
            }

            // Category
            if (!empty($filters['category'])) {
                $query->where('category_id', $filters['category']);
            }

            // Vendor
            if (!empty($filters['vendor'])) {
                $query->where('vendor_id', $filters['vendor']);
            }

            // Price (SHOP ONLY)
            if (!empty($filters['price'])) {
                [$min, $max] = explode('-', $filters['price']);
                if ($max == 1000000) {
                    $query->where('price', '>=', $min);
                } else {
                    $query->whereBetween('price', [$min, $max]);
                }
            }

            // Status (ADMIN ONLY)
            if (!empty($filters['status'])) {
                $query->where('status', $filters['status']);
            }

            // Shop sorting
            if (!empty($filters['sort'])) {
                match ($filters['sort']) {
                    'price_low'  => $query->orderBy('price', 'asc'),
                    'price_high' => $query->orderBy('price', 'desc'),
                    default      => $query->latest(),
                };
            }

            // Admin sorting
            if (!empty($filters['sort_by'])) {
                $dir = $filters['sort_dir'] ?? 'desc';
                $query->orderBy($filters['sort_by'], $dir);
            }

            return $query->paginate($perPage)->appends($filters);

        } catch (Throwable $e) {
            report($e);
            return collect();
        }
    }

    public function findBySlug(string $slug)
    {
        try {
            return Product::with(['category', 'vendor'])
                ->where('slug', $slug)
                ->firstOrFail();
        } catch (Throwable $e) {
            report($e);
            return null;
        }
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