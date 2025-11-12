<div
  class="w-full col-span-2 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl p-6"
>
  <div class="flex items-center justify-between mb-4">
    <h3 class="text-base font-semibold text-gray-800 dark:text-white">
      Top 7 Products
    </h3>
    <div class="flex items-center gap-2">
      <button
        class="text-xs px-2 py-1 bg-gray-100 dark:bg-gray-800 rounded-md text-gray-600 dark:text-gray-300 cursor-default"
      >
        Updated: <span id="topProductsUpdate" class="font-medium">{{ now()->format('M j, Y') }}</span>
      </button>
    </div>
  </div>

  <div id="topProductsChart" class="min-h-[280px]"></div>

  @if(empty($topProducts) || count($topProducts) === 0)
    <p class="text-center text-gray-500 dark:text-gray-400 text-sm mt-6">
      No product data available
    </p>
  @endif
</div>