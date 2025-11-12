<?php $__env->startSection('title', 'Customer Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-8">

  <!-- Metrics: Order Status -->
  <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
    <?php $__currentLoopData = $metrics; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $metric): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <div class="p-4 rounded-lg border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900">
        <h3 class="text-sm text-gray-500 dark:text-gray-400 font-medium"><?php echo e($metric['label']); ?></h3>
        <p class="text-2xl font-bold text-gray-800 dark:text-white mt-1"><?php echo e($metric['count']); ?></p>
      </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </div>

  <!-- Order History -->
  <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-6">
    <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Order History</h2>
    <?php if($orderHistory->isEmpty()): ?>
      <p class="text-gray-500 text-sm">No orders found.</p>
    <?php else: ?>
      <div class="overflow-x-auto">
        <table class="min-w-full text-sm text-left">
          <thead class="border-b border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-400">
            <tr>
              <th class="py-2 px-3">Order Code</th>
              <th class="py-2 px-3">Total Items</th>
              <th class="py-2 px-3">Total Price</th>
              <th class="py-2 px-3">Status</th>
              <th class="py-2 px-3">Date</th>
            </tr>
          </thead>
          <tbody class="text-gray-700 dark:text-gray-300">
            <?php $__currentLoopData = $orderHistory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <tr class="border-b border-gray-100 dark:border-gray-800">
                <td class="py-2 px-3 font-medium"><?php echo e($order->code); ?></td>
                <td class="py-2 px-3"><?php echo e($order->items->sum('qty')); ?></td>
                <td class="py-2 px-3">Rp <?php echo e(number_format($order->total_price, 0, ',', '.')); ?></td>
                <td class="py-2 px-3">
                  <span class="px-2 py-1 rounded text-xs font-medium
                    <?php if($order->status === 'pending'): ?> bg-yellow-100 text-yellow-700
                    <?php elseif($order->status === 'processing'): ?> bg-blue-100 text-blue-700
                    <?php elseif($order->status === 'shipped'): ?> bg-purple-100 text-purple-700
                    <?php elseif($order->status === 'delivered'): ?> bg-green-100 text-green-700
                    <?php endif; ?>">
                    <?php echo e(ucfirst($order->status)); ?>

                  </span>
                </td>
                <td class="py-2 px-3"><?php echo e($order->created_at->format('Y-m-d')); ?></td>
              </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </tbody>
        </table>
      </div>
    <?php endif; ?>
  </div>

  <!-- Order Log Activity -->
  <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-6">
    <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Order Activity Log</h2>
    <?php if($orderLogs->isEmpty()): ?>
      <p class="text-gray-500 text-sm">No recent activities.</p>
    <?php else: ?>
      <div class="overflow-x-auto">
        <table class="min-w-full text-sm text-left">
          <thead class="border-b border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-400">
            <tr>
              <th class="py-2 px-3">Order Code</th>
              <th class="py-2 px-3">Product</th>
              <th class="py-2 px-3">Qty</th>
              <th class="py-2 px-3">Status</th>
              <th class="py-2 px-3">Updated At</th>
            </tr>
          </thead>
          <tbody class="text-gray-700 dark:text-gray-300">
            <?php $__currentLoopData = $orderLogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <tr class="border-b border-gray-100 dark:border-gray-800">
                <td class="py-2 px-3"><?php echo e($log['order_code']); ?></td>
                <td class="py-2 px-3"><?php echo e($log['product']); ?></td>
                <td class="py-2 px-3"><?php echo e($log['qty']); ?></td>
                <td class="py-2 px-3 capitalize"><?php echo e($log['status']); ?></td>
                <td class="py-2 px-3"><?php echo e($log['updated_at']); ?></td>
              </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </tbody>
        </table>
      </div>
    <?php endif; ?>
  </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/gusde/Documents/laravel/marketplace-timedoor/resources/views/customer/dashboard/index.blade.php ENDPATH**/ ?>