<div class="col-span-12 mt-8">
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/3 p-6">
      <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Recent Orders</h3>
        <a href="<?php echo e(route('orders.index')); ?>"
          class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-theme-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/3 dark:hover:text-gray-200"
        >
          See all
        </a>
      </div>
      <div class="max-w-full overflow-x-auto">
        <table class="min-w-full text-left text-sm">
          <thead class="border-b border-gray-100 dark:border-gray-800 bg-gray-50 dark:bg-gray-800/30">
            <tr>
              <th class="px-5 py-3 font-medium text-gray-600 dark:text-gray-300">Code</th>
              <th class="px-5 py-3 font-medium text-gray-600 dark:text-gray-300">Customer</th>
              <th class="px-5 py-3 font-medium text-gray-600 dark:text-gray-300">Total</th>
              <th class="px-5 py-3 font-medium text-gray-600 dark:text-gray-300">Shipping</th>
              <th class="px-5 py-3 font-medium text-gray-600 dark:text-gray-300 text-center">Status</th>
            </tr>
          </thead>

          <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
            <?php $__empty_1 = true; $__currentLoopData = $recentOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
              <tr
                onclick="window.location='<?php echo e(route('orders.show', $order)); ?>'"
                class="cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-800/40 transition-colors"
              >
                <td class="px-5 py-3 font-semibold text-gray-800 dark:text-gray-100"><?php echo e($order->code); ?></td>
                <td class="px-5 py-3 text-gray-700 dark:text-gray-300"><?php echo e($order->customer->name ?? '-'); ?></td>
                <td class="px-5 py-3 text-gray-700 dark:text-gray-300">Rp<?php echo e(number_format($order->total_price, 0, ',', '.')); ?></td>
                <td class="px-5 py-3 text-gray-700 dark:text-gray-300">Rp<?php echo e(number_format($order->shipping_cost, 0, ',', '.')); ?></td>
                <td class="px-5 py-3 text-center">
                  <?php
                    $color = match($order->status) {
                      \App\Enum\OrderStatus::PENDING => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-300',
                      \App\Enum\OrderStatus::PROCESSING => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300',
                      \App\Enum\OrderStatus::SHIPPED => 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-300',
                      \App\Enum\OrderStatus::DELIVERED => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300',
                      \App\Enum\OrderStatus::CANCELED => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-300',
                    };
                  ?>
                  <span class="px-2 py-1 rounded-full text-xs font-medium text-nowrap <?php echo e($color); ?>">
                    <?php echo e($order->status->label()); ?>

                  </span>
                </td>
              </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
              <tr>
                <td colspan="7" class="px-5 py-6 text-center text-gray-500 dark:text-gray-400">
                  No orders found.
                </td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div><?php /**PATH /Users/gusde/Documents/laravel/marketplace-timedoor/resources/views/components/table/recent-orders-table.blade.php ENDPATH**/ ?>