<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Interfaces\CategoryRepositoryInterface;
use App\Models\Category;
use Illuminate\Support\Facades\Log;
use Throwable;

class CategoryController extends Controller
{
    public function __construct(
        protected readonly CategoryRepositoryInterface $categories
    )
    {
        $this->authorizeResource(Category::class, 'category');
    }

    public function index()
    {
        try {
            $filters = request()->only(['search', 'sort_by', 'sort_dir']);
            $categories = $this->categories->paginateWithFilters($filters, 5);
            return view('admin.categories.index', compact('categories', 'filters'));
        } catch (Throwable $e) {
            Log::error('Failed to load categories: ' . $e->getMessage());
            return back()->withErrors('Failed to load categories.');
        }
    }


    public function create()
    {
        try {
            $categories = $this->categories->all();
            return view('admin.categories.create', compact('categories'));
        } catch (Throwable $e) {
            Log::error('Failed to open create form: ' . $e->getMessage());
            return back()->withErrors('Unable to open create form.');
        }
    }

    public function store(StoreCategoryRequest $request)
    {
        try {
            $this->categories->create($request->validated());
            return redirect()
                ->route('categories.index')
                ->with('success', 'Category created successfully.');
        } catch (Throwable $e) {
            Log::error('Failed to create category: ' . $e->getMessage());
            return back()
                ->withInput()
                ->withErrors('Failed to create category. Please try again.');
        }
    }

    public function show(Category $category)
    {
        try {
            $category->load('parent');

            $products = $category->products()
                ->with('vendor')
                ->orderBy('created_at', 'desc')
                ->paginate(10);

            return view('admin.categories.show', compact('category', 'products'));
        } catch (Throwable $e) {
            Log::error('Failed to load category details: ' . $e->getMessage());
            return back()->withErrors('Unable to load category details.');
        }
    }

    public function edit(Category $category)
    {
        try {
            $categories = $this->categories->all();
            return view('admin.categories.edit', compact('category', 'categories'));
        } catch (Throwable $e) {
            Log::error('Failed to open edit form: ' . $e->getMessage());
            return back()->withErrors('Unable to open edit form.');
        }
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        try {
            $this->categories->update($category, $request->validated());
            return redirect()
                ->route('categories.index')
                ->with('success', 'Category updated successfully.');
        } catch (Throwable $e) {
            Log::error('Failed to update category: ' . $e->getMessage());
            return back()
                ->withInput()
                ->withErrors('Failed to update category. Please try again.');
        }
    }

    public function destroy(Category $category)
    {
        try {
            $this->categories->delete($category);
            return redirect()
                ->route('categories.index')
                ->with('success', 'Category deleted successfully.');
        } catch (Throwable $e) {
            Log::error('Failed to delete category: ' . $e->getMessage());
            return back()->withErrors('Failed to delete category.');
        }
    }
}