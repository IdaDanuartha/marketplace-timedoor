<?php

namespace App\Http\Controllers;

use App\Enum\OrderStatus;
use App\Http\Requests\Order\StoreOrderRequest;
use App\Http\Requests\Order\UpdateOrderRequest;
use App\Interfaces\OrderRepositoryInterface;
use App\Models\Order;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Support\Facades\Log;
use Throwable;

class OrderController extends Controller
{
    public function __construct(protected readonly OrderRepositoryInterface $orders)
    {
        $this->authorizeResource(Order::class, 'order');
    }

    public function index()
    {
        try {
            $filters = request()->only(['search', 'status']);
            $orders = $this->orders->paginateWithFilters($filters, 10);
            $statuses = OrderStatus::cases();

            return view('admin.orders.index', compact('orders', 'filters', 'statuses'));
        } catch (Throwable $e) {
            Log::error('Failed to load orders: ' . $e->getMessage());
            return back()->withErrors('Failed to load orders.');
        }
    }

    public function create()
    {
        try {
            $customers = Customer::latest()->get();
            $products = Product::latest()->get();
            $statuses = OrderStatus::cases();

            return view('admin.orders.create', compact('customers', 'products', 'statuses'));
        } catch (Throwable $e) {
            Log::error('Failed to open create form: ' . $e->getMessage());
            return back()->withErrors('Unable to open create form.');
        }
    }

    public function store(StoreOrderRequest $request)
    {
        try {
            $this->orders->create($request->validated());
            return redirect()->route('orders.index')->with('success', 'Order created successfully.');
        } catch (Throwable $e) {
            Log::error('Failed to create order: ' . $e->getMessage());
            return back()->withInput()->withErrors('Failed to create order.');
        }
    }

    public function show(Order $order)
    {
        $order->load('items.product');
        $statuses = OrderStatus::cases();

        return view('admin.orders.show', compact('order', 'statuses'));
    }

    public function edit(Order $order)
    {
        try {
            $customers = Customer::latest()->get();
            $products = Product::latest()->get();
            $statuses = OrderStatus::cases();
            $order->load('items.product');

            return view('admin.orders.edit', compact('order', 'customers', 'products', 'statuses'));
        } catch (Throwable $e) {
            Log::error('Failed to open edit form: ' . $e->getMessage());
            return back()->withErrors('Unable to open edit form.');
        }
    }

    public function update(UpdateOrderRequest $request, Order $order)
    {
        try {
            $this->orders->update($order, $request->validated());
            return redirect()->route('orders.index')->with('success', 'Order updated successfully.');
        } catch (Throwable $e) {
            Log::error('Failed to update order: ' . $e->getMessage());
            return back()->withInput()->withErrors('Failed to update order.');
        }
    }

    public function destroy(Order $order)
    {
        try {
            $this->orders->delete($order);
            return redirect()->route('orders.index')->with('success', 'Order deleted successfully.');
        } catch (Throwable $e) {
            Log::error('Failed to delete order: ' . $e->getMessage());
            return back()->withErrors('Failed to delete order.');
        }
    }
}