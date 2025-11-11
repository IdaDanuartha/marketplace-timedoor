<?php

namespace App\Repositories;

use App\Interfaces\CategoryRepositoryInterface;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Throwable;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function all()
    {
        return Category::with('parent')->latest()->get();
    }

    public function find($id): ?Category
    {
        return Category::find($id);
    }

    public function create(array $data): Category
    {
        try {
            return DB::transaction(function () use ($data) {
                $data['slug'] = Str::slug($data['name']);
                return Category::create($data);
            });
        } catch (Throwable $e) {
            Log::error('Error creating category: ' . $e->getMessage());
            throw $e;
        }
    }

    public function update(Category $category, array $data): Category
    {
        try {
            return DB::transaction(function () use ($category, $data) {
                $data['slug'] = Str::slug($data['name']);
                $category->update($data);
                return $category;
            });
        } catch (Throwable $e) {
            Log::error('Error updating category: ' . $e->getMessage());
            throw $e;
        }
    }

    public function delete(Category $category): bool
    {
        try {
            return DB::transaction(function () use ($category) {
                return $category->delete();
            });
        } catch (Throwable $e) {
            Log::error('Error deleting category: ' . $e->getMessage());
            throw $e;
        }
    }
}