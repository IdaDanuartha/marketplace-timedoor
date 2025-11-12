<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Vendor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function index(Request $request)
    {
        $now = Carbon::now();
        $oneWeekAgo = $now->copy()->subWeek();

        // === Metric Cards ===
        $customersCount = Customer::count();
        $vendorsCount = Vendor::count();
        $ordersCount = Order::count();
        $productsCount = Product::count();

        $customersLastWeek = Customer::whereBetween('created_at', [$oneWeekAgo, $now])->count();
        $vendorsLastWeek = Vendor::whereBetween('created_at', [$oneWeekAgo, $now])->count();
        $ordersLastWeek = Order::whereBetween('created_at', [$oneWeekAgo, $now])->count();
        $productsLastWeek = Product::whereBetween('created_at', [$oneWeekAgo, $now])->count();

        $metrics = [
            'customers' => [
                'label' => 'Customers',
                'count' => $customersCount,
                'change' => $this->calculateChange($customersCount, $customersLastWeek),
            ],
            'vendors' => [
                'label' => 'Vendors',
                'count' => $vendorsCount,
                'change' => $this->calculateChange($vendorsCount, $vendorsLastWeek),
            ],
            'orders' => [
                'label' => 'Orders',
                'count' => $ordersCount,
                'change' => $this->calculateChange($ordersCount, $ordersLastWeek),
            ],
            'products' => [
                'label' => 'Products',
                'count' => $productsCount,
                'change' => $this->calculateChange($productsCount, $productsLastWeek),
            ],
        ];

        // === Orders by date (for bar chart) ===
        $ordersByDate = Order::select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(id) as total'))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $chartData = [
            'labels' => $ordersByDate->pluck('date'),
            'values' => $ordersByDate->pluck('total'),
        ];

        // === Top 10 products (pie chart) ===
        $topProducts = OrderItem::select('product_id', DB::raw('COUNT(*) as total'))
            ->with('product')
            ->groupBy('product_id')
            ->orderByDesc('total')
            ->take(7) // cuma 7 teratas
            ->get()
            ->map(fn($item) => [
                'name' => $item->product->name ?? 'Unknown',
                'total' => $item->total,
            ]);


        // === Recent Orders ===
        $recentOrders = Order::with(['customer', 'items.product'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard.index', compact('metrics', 'chartData', 'topProducts', 'recentOrders'));
    }

    private function calculateChange($total, $lastWeek)
    {
        if ($total == 0) return 0;
        return round(($lastWeek / max(1, $total)) * 100, 2);
    }

    public function getOrdersStats(Request $request)
    {
        $range = $request->query('range', 'week');
        $query = Order::select(
            DB::raw('COUNT(*) as total'),
            DB::raw('DATE(created_at) as date')
        )->groupBy('date');

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
                $weekEnd = $weekStart->copy()->endOfWeek();
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
