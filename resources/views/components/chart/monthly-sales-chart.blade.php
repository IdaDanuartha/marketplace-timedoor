<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    {{-- Bar Chart (Orders by Period) --}}
    <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/3">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Orders Overview</h3>
            <select id="ordersRange" class="text-sm border rounded-lg px-2 py-1 bg-gray-50 dark:bg-gray-800 dark:text-white">
            <option value="week" selected>This Week</option>
            <option value="month">This Month</option>
            <option value="year">This Year</option>
            </select>
        </div>

        <div id="ordersBarChart" class="w-full h-[260px]"></div>
    </div>
    <div>
        <div id="ordersBarChartContainer"></div>
        <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/3">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90 mb-4">Top Selling Products</h3>
            <div id="topProductsChart" class="h-[260px]"></div>
        </div>
    </div>
</div>

{{-- Pie Chart (Top Products) --}}
{{-- <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div id="ordersBarChartContainer"></div>
    <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/3">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90 mb-4">Top Products</h3>
        <div id="topProductsChart" class="h-[260px]"></div>
    </div>
</div> --}}
