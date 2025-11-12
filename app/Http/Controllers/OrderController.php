<?php

namespace App\Http\Controllers;

use App\Enum\OrderStatus;
use App\Http\Requests\Order\StoreOrderRequest;
use App\Http\Requests\Order\UpdateOrderRequest;
use App\Interfaces\OrderRepositoryInterface;
use App\Models\Order;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            $filters = request()->only(['search', 'status', 'payment_status', 'payment_method', 'date_from', 'date_to']);
            $user = Auth::user();

            if ($user->vendor) {
                $filters['vendor_id'] = $user->vendor->id;
            }

            $orders = $this->orders->paginateWithFilters($filters, 10);

            $statuses = OrderStatus::cases();
            return view('admin.orders.index', compact('orders', 'filters', 'statuses'));
        } catch (Throwable $e) {
            Log::error('Failed to load orders: ' . $e->getMessage());
            return back()->withErrors('Failed to load orders.');
        }
    }

    public function show(Order $order)
    {
        $order->load(['customer', 'items.product']);
        $statuses = OrderStatus::cases();

        $user = Auth::user();
        if ($user->vendor && !$order->items->contains(fn($i) => $i->product->vendor_id === $user->vendor->id)) {
            abort(403);
        }

        return view('admin.orders.show', compact('order', 'statuses'));
    }

    public function create()
    {
        try {
            $user = Auth::user();
            $customers = Customer::latest()->get();
            $statuses = OrderStatus::cases();

            // Vendor hanya bisa membuat order dengan produknya sendiri
            $products = $user->vendor
                ? Product::where('vendor_id', $user->vendor->id)->get()
                : Product::latest()->get();

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

    public function edit(Order $order)
    {
        try {
            $user = Auth::user();

            if ($user->vendor && !$order->items()->whereHas('product', fn($q) =>
                $q->where('vendor_id', $user->vendor->id)
            )->exists()) {
                abort(403);
            }

            $customers = Customer::latest()->get();
            $statuses = OrderStatus::cases();
            $products = $user->vendor
                ? Product::where('vendor_id', $user->vendor->id)->get()
                : Product::latest()->get();

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

    public function updateStatus(Request $request, Order $order)
    {
        try {
            $request->validate([
                'status' => 'required|in:' . implode(',', array_map(fn($s) => $s->value, OrderStatus::cases())),
            ]);

            $this->orders->update($order, ['status' => $request->input('status')]);
            return back()->with('success', 'Order status updated successfully.');
        } catch (Throwable $e) {
            Log::error('Failed to update order: ' . $e->getMessage());
            return back()->withInput()->withErrors('Failed to update order.');
        }
    }

    public function destroy(Order $order)
    {
        try {
            $user = Auth::user();

            if ($user->vendor && !$order->items()->whereHas('product', fn($q) =>
                $q->where('vendor_id', $user->vendor->id)
            )->exists()) {
                abort(403);
            }

            $this->orders->delete($order);
            return redirect()->route('orders.index')->with('success', 'Order deleted successfully.');
        } catch (Throwable $e) {
            Log::error('Failed to delete order: ' . $e->getMessage());
            return back()->withErrors('Failed to delete order.');
        }
    }

    public function export(Request $request)
    {
        try {
            return $this->orders->export($request->all());
        } catch (\Throwable $e) {
            Log::error('Failed to export orders: ' . $e->getMessage());
            return back()->withErrors('Failed to export orders.');
        }
    }
}