<?php

namespace App\Http\Controllers;

use App\Http\Requests\Customer\StoreCustomerRequest;
use App\Http\Requests\Customer\UpdateCustomerRequest;
use App\Interfaces\CustomerRepositoryInterface;
use App\Models\{Customer, User};
use Illuminate\Support\Facades\Log;
use Throwable;

class CustomerController extends Controller
{
    public function __construct(
        protected readonly CustomerRepositoryInterface $customers
    ) {
        $this->authorizeResource(Customer::class, 'customer');
    }

    public function index()
    {
        try {
            $filters = request()->only(['search', 'sort_by', 'sort_dir']);
            $customers = $this->customers->paginateWithFilters($filters, 10);
            return view('admin.customers.index', compact('customers', 'filters'));
        } catch (Throwable $e) {
            Log::error('Failed to load customers: ' . $e->getMessage());
            return back()->withErrors('Failed to load customers.');
        }
    }

    public function create()
    {
        $addresses = [[
            'full_address' => '',
            'additional_information' => '',
            'postal_code' => '',
            'latitude' => '',
            'longitude' => '',
            'label' => 'Home',
            'is_default' => true,
        ]];

        return view('admin.customers.create', compact('addresses'));
    }

    public function store(StoreCustomerRequest $request)
    {
        try {
            $this->customers->create($request->validated(), $request);
            return redirect()->route('customers.index')->with('success', 'Customer created successfully.');
        } catch (Throwable $e) {
            Log::error('Failed to create customer: ' . $e->getMessage());
            return back()->withInput()->withErrors('Failed to create customer.');
        }
    }

    public function edit(Customer $customer)
    {
        return view('admin.customers.edit', compact('customer'));
    }

    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        try {
            $this->customers->update($customer, $request->validated(), $request);
            return redirect()->route('customers.index')->with('success', 'Customer updated successfully.');
        } catch (Throwable $e) {
            Log::error('Failed to update customer: ' . $e->getMessage());
            return back()->withInput()->withErrors('Failed to update customer.');
        }
    }

    public function destroy(Customer $customer)
    {
        try {
            $this->customers->delete($customer);
            return redirect()->route('customers.index')->with('success', 'Customer deleted successfully.');
        } catch (Throwable $e) {
            Log::error('Failed to delete customer: ' . $e->getMessage());
            return back()->withErrors('Failed to delete customer.');
        }
    }

    public function show(Customer $customer)
    {
        $customer->load('user', 'addresses');
        return view('admin.customers.show', compact('customer'));
    }
}