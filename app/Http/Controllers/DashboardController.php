<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Vendor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $now = Carbon::now();

        // ADMIN DASHBOARD
        if ($user->admin) {
            return $this->adminDashboard($now);
        }

        // VENDOR DASHBOARD
        if ($user->vendor) {
            return $this->vendorDashboard($user->vendor->id, $now);
        }

        // CUSTOMER DASHBOARD
        if ($user->customer) {
            return $this->customerDashboard($user->customer->id);
        }

        // fallback
        abort(404);
    }

    // ADMIN ROLE
    private function adminDashboard(Carbon $now)
    {
        $oneWeekAgo = $now->copy()->subWeek();

        $metrics = [
            'customers' => [
                'label' => 'Customers',
                'count' => Customer::count(),
                'change' => $this->calculateChange(Customer::count(), Customer::whereBetween('created_at', [$oneWeekAgo, $now])->count()),
            ],
            'vendors' => [
                'label' => 'Vendors',
                'count' => Vendor::count(),
                'change' => $this->calculateChange(Vendor::count(), Vendor::whereBetween('created_at', [$oneWeekAgo, $now])->count()),
            ],
            'orders' => [
                'label' => 'Orders',
                'count' => Order::count(),
                'change' => $this->calculateChange(Order::count(), Order::whereBetween('created_at', [$oneWeekAgo, $now])->count()),
            ],
            'products' => [
                'label' => 'Products',
                'count' => Product::count(),
                'change' => $this->calculateChange(Product::count(), Product::whereBetween('created_at', [$oneWeekAgo, $now])->count()),
            ],
        ];

        $chartData = $this->getOrdersChartData();
        $topProducts = $this->getTopProducts();
        $recentOrders = Order::with(['customer', 'items.product'])->latest()->take(5)->get();

        return view('admin.dashboard.index', compact('metrics', 'chartData', 'topProducts', 'recentOrders'));
    }

    // VENDOR ROLE
    private function vendorDashboard(int $vendorId, Carbon $now)
    {
        $oneWeekAgo = $now->copy()->subWeek();

        // Metric: orders & products
        $orders = Order::whereHas('items.product', fn($q) => $q->where('vendor_id', $vendorId));
        $products = Product::where('vendor_id', $vendorId);

        $metrics = [
            'orders' => [
                'label' => 'Orders',
                'count' => $orders->count(),
                'change' => $this->calculateChange(
                    $orders->count(),
                    $orders->whereBetween('created_at', [$oneWeekAgo, $now])->count()
                ),
            ],
            'products' => [
                'label' => 'Products',
                'count' => $products->count(),
                'change' => $this->calculateChange(
                    $products->count(),
                    $products->whereBetween('created_at', [$oneWeekAgo, $now])->count()
                ),
            ],
        ];

        // Chart (orders)
        $chartData = $this->getOrdersChartData($vendorId);

        // Top 7 products milik vendor ini
        $topProducts = OrderItem::whereHas('product', fn($q) => $q->where('vendor_id', $vendorId))
            ->select('product_id', DB::raw('COUNT(*) as total'))
            ->with('product')
            ->groupBy('product_id')
            ->orderByDesc('total')
            ->take(7)
            ->get()
            ->map(fn($item) => [
                'name' => $item->product->name ?? 'Unknown',
                'total' => $item->total,
            ]);

        // Recent orders milik vendor ini
        $recentOrders = Order::whereHas('items.product', fn($q) => $q->where('vendor_id', $vendorId))
            ->with(['customer', 'items.product'])
            ->latest()
            ->take(5)
            ->get();

        return view('vendor.dashboard.index', compact('metrics', 'chartData', 'topProducts', 'recentOrders'));
    }

    // CUSTOMER ROLE
    private function customerDashboard(int $customerId)
    {
        // Metric berdasarkan status
        $metrics = collect(['pending', 'processing', 'shipped', 'delivered'])
            ->mapWithKeys(function ($status) use ($customerId) {
                return [$status => [
                    'label' => ucfirst($status),
                    'count' => Order::where('customer_id', $customerId)
                        ->where('status', $status)
                        ->count(),
                ]];
            });

        // Orders history
        $orderHistory = Order::with(['items.product'])
            ->where('customer_id', $customerId)
            ->latest()
            ->get();

        // Log activity bisa pakai table lain, sementara dummy aja
        $orderLogs = $orderHistory->flatMap(function ($order) {
            return $order->items->map(function ($item) use ($order) {
                return [
                    'order_code' => $order->code,
                    'product' => $item->product->name ?? 'Unknown',
                    'qty' => $item->qty,
                    'status' => $order->status,
                    'updated_at' => $order->updated_at->format('Y-m-d H:i'),
                ];
            });
        });

        return view('customer.dashboard.index', compact('metrics', 'orderHistory', 'orderLogs'));
    }

    // ==============================================
    private function calculateChange($total, $lastWeek)
    {
        if ($total == 0) return 0;
        return round(($lastWeek / max(1, $total)) * 100, 2);
    }

    private function getOrdersChartData($vendorId = null)
    {
        $query = Order::select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(id) as total'))
            ->groupBy('date')
            ->orderBy('date');

        if ($vendorId) {
            $query->whereHas('items.product', fn($q) => $q->where('vendor_id', $vendorId));
        }

        $ordersByDate = $query->get();

        return [
            'labels' => $ordersByDate->pluck('date'),
            'values' => $ordersByDate->pluck('total'),
        ];
    }

    private function getTopProducts()
    {
        return OrderItem::select('product_id', DB::raw('COUNT(*) as total'))
            ->with('product')
            ->groupBy('product_id')
            ->orderByDesc('total')
            ->take(7)
            ->get()
            ->map(fn($item) => [
                'name' => $item->product->name ?? 'Unknown',
                'total' => $item->total,
            ]);
    }

    public function getOrdersStats(Request $request)
    {
        $user = Auth::user();

        $range = $request->query('range', 'week');
        $query = Order::select(
            DB::raw('COUNT(*) as total'),
            DB::raw('DATE(created_at) as date')
        )
        ->when($user->vendor, function ($q) use ($user) {
            // Filter order berdasarkan produk milik vendor
            $q->whereHas('items.product', function ($sub) use ($user) {
                $sub->where('vendor_id', $user->vendor->id);
            });
        })
        ->groupBy('date');

        $now = now();
        $labels = [];
        $values = [];

        if ($range === 'week') {
            // Minggu ini: 7 hari terakhir
            $start = $now->startOfWeek();
            $orders = $query->where('created_at', '>=', $start)->get();

            // Generate label harian
            $labels = collect(range(0, 6))->map(fn($i) => $now->copy()->startOfWeek()->addDays($i)->format('D'));
            $values = $labels->map(fn($label) => $orders->filter(
                fn($o) => Carbon::parse($o->date)->format('D') === $label
            )->sum('total'));

        } elseif ($range === 'month') {
            // Bulan ini: Kelompok mingguan
            $start = $now->startOfMonth();
            $orders = $query->where('created_at', '>=', $start)->get();

            $labels = collect(['Week 1', 'Week 2', 'Week 3', 'Week 4']);
            $values = collect(range(1, 4))->map(function ($week) use ($orders, $now) {
                $weekStart = $now->copy()->startOfMonth()->addWeeks($week - 1);
                $weekEnd = $week === 4
                    ? $now->copy()->endOfMonth()
                    : $weekStart->copy()->endOfWeek();

                return $orders->filter(fn($o) => Carbon::parse($o->date)->between($weekStart, $weekEnd))->sum('total');
            });

        } else {
            // Tahun ini: Per bulan
            $start = $now->startOfYear();
            $orders = $query->where('created_at', '>=', $start)->get();

            $labels = collect(['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec']);
            $values = $labels->map(fn($month, $i) => $orders->filter(
                fn($o) => Carbon::parse($o->date)->month === $i + 1
            )->sum('total'));
        }

        return response()->json([
            'labels' => $labels,
            'values' => $values,
        ]);
    }
}
