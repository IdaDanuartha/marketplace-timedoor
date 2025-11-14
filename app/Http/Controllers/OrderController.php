<?php

namespace App\Http\Controllers;

use App\Enum\OrderStatus;
use App\Http\Requests\Order\StoreOrderRequest;
use App\Http\Requests\Order\UpdateOrderRequest;
use App\Interfaces\OrderRepositoryInterface;
use App\Models\Address;
use App\Models\Order;
use App\Models\Customer;
use App\Models\Product;
use App\Services\RajaOngkirService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class OrderController extends Controller
{
    public function __construct(protected readonly OrderRepositoryInterface $orders, protected readonly RajaOngkirService $rajaOngkir)
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
        if ($user->vendo1r && !$order->items->contains(fn($i) => $i->product->vendor_id === $user->vendor->id)) {
            abort(403);
        }

        return view('admin.orders.show', compact('order', 'statuses'));
    }

    public function create()
    {
        try {
            $user = Auth::user();
            $statuses = OrderStatus::cases();

            $customers = Customer::latest()->get();

            $addresses = Address::latest()->get();

            $products = $user->vendor
                ? Product::where('vendor_id', $user->vendor->id)->get()
                : Product::latest()->get();

            return view('admin.orders.create', compact(
                'customers',
                'addresses',
                'products',
                'statuses'
            ));
        } catch (Throwable $e) {
            Log::error('Failed to open create form: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

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
            $addresses = Address::latest()->get();

            return view('admin.orders.edit', compact('order', 'customers', 'products', 'statuses', 'addresses'));
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

    public function getAddresses(Customer $customer)
    {
        $addresses = $customer->addresses()
            ->select('addresses.id', 'addresses.label', 'addresses.full_address', 'addresses.district_id')
            ->orderBy('addresses.created_at', 'desc')
            ->get();

        return response()->json($addresses);
    }

    public function calculateShipping(\Illuminate\Http\Request $request)
    {
        try {
            $validated = $request->validate([
                'destination' => 'required|integer',
                'weight' => 'required|integer|min:1'
            ]);

            $rajaOngkir = app(\App\Services\RajaOngkirService::class);
            
            $result = $rajaOngkir->calculateDomesticCost(
                destination: (int) $validated['destination'],
                weight: (int) $validated['weight'],
            );

            return response()->json([
                'success' => true,
                'data' => $result
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'error' => 'Validation failed',
                'messages' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Shipping calculation error: ' . $e->getMessage(), [
                'request' => $request->all()
            ]);

            return response()->json([
                'success' => false,
                'error' => 'Failed to calculate shipping cost',
                'message' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }
}