<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Vendor\StoreVendorRequest;
use App\Http\Requests\Vendor\UpdateVendorRequest;
use App\Http\Requests\VendorRequest;
use App\Interfaces\VendorRepositoryInterface;
use App\Models\Vendor;
use Illuminate\Support\Facades\Log;
use Throwable;

class VendorController extends Controller
{
    public function __construct(
        protected readonly VendorRepositoryInterface $vendors
    ) {
        $this->authorizeResource(Vendor::class, 'vendor');
    }

    public function index()
    {
        try {
            $filters = request()->only(['search', 'sort_by', 'sort_dir', 'status']);
            $vendors = $this->vendors->paginateWithFilters($filters, 10);

            return view('admin.vendors.index', compact('vendors', 'filters'));
        } catch (Throwable $e) {
            Log::error('Failed to load vendors: ' . $e->getMessage());
            return back()->withErrors('Failed to load vendors.');
        }
    }

    public function create()
    {
        try {
            return view('admin.vendors.create');
        } catch (Throwable $e) {
            Log::error('Failed to open create form: ' . $e->getMessage());
            return back()->withErrors('Unable to open create form.');
        }
    }

    public function store(StoreVendorRequest $request)
    {
        try {
            $this->vendors->create($request->validated());
            return redirect()
                ->route('vendors.index')
                ->with('success', 'Vendor created successfully.');
        } catch (Throwable $e) {
            Log::error('Failed to create vendor: ' . $e->getMessage());
            return back()->withInput()->withErrors('Failed to create vendor.');
        }
    }

    public function show(Vendor $vendor)
    {
        try {
            return view('admin.vendors.show', compact('vendor'));
        } catch (Throwable $e) {
            Log::error('Failed to open show form: ' . $e->getMessage());
            return back()->withErrors('Unable to open show form.');
        }
    }

    public function edit(Vendor $vendor)
    {
        try {
            return view('admin.vendors.edit', compact('vendor'));
        } catch (Throwable $e) {
            Log::error('Failed to open edit form: ' . $e->getMessage());
            return back()->withErrors('Unable to open edit form.');
        }
    }

    public function update(UpdateVendorRequest $request, Vendor $vendor)
    {
        try {
            $this->vendors->update($vendor, $request->validated());
            return redirect()
                ->route('vendors.index')
                ->with('success', 'Vendor updated successfully.');
        } catch (Throwable $e) {
            Log::error('Failed to update vendor: ' . $e->getMessage());
            return back()->withInput()->withErrors('Failed to update vendor.');
        }
    }

    public function destroy(Vendor $vendor)
    {
        try {
            $this->vendors->delete($vendor);
            return redirect()
                ->route('vendors.index')
                ->with('success', 'Vendor deleted successfully.');
        } catch (Throwable $e) {
            Log::error('Failed to delete vendor: ' . $e->getMessage());
            return back()->withErrors('Failed to delete vendor.');
        }
    }
}