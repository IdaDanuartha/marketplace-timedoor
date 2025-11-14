<?php $__env->startSection('title', 'Customer Dashboard'); ?>

<?php $__env->startSection('content'); ?>

<?php if(session('success')): ?>
<div class="p-3 bg-green-100 border border-green-300 text-green-800 rounded-lg mb-4"><?php echo e(session('success')); ?></div>
<?php endif; ?>
<?php if($errors->any()): ?>
<div class="p-3 bg-red-100 border border-red-300 text-red-800 rounded-lg mb-4"><?php echo e($errors->first()); ?></div>
<?php endif; ?>

<div class="space-y-8" x-data="{ isModalOpen: false, deleteUrl: '', title: '' }">
  <!-- METRICS -->
  <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
    <?php $__currentLoopData = $metrics; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $metric): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <div class="p-5 rounded-xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 flex flex-col justify-between">
        <div class="flex items-center justify-between">
          <h3 class="text-sm text-gray-500 dark:text-gray-400 font-medium"><?php echo e($metric['label']); ?></h3>
          <?php if($key === 'pending'): ?>
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6l4 2m6-2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
          <?php elseif($key === 'processing'): ?>
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v6h6M20 20v-6h-6m1.42-9.42A9 9 0 0112 3a9 9 0 019 9m-1.42 5.42A9 9 0 0112 21a9 9 0 01-9-9" />
            </svg>
          <?php elseif($key === 'shipped'): ?>
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17V5a1 1 0 011-1h7l4 5v8a1 1 0 01-1 1h-1m-2 0a1 1 0 11-2 0m-8 0a1 1 0 102 0m-2 0H5a1 1 0 01-1-1v-3h16" />
            </svg>
          <?php elseif($key === 'delivered'): ?>
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2l4-4m6 2a9 9 0 11-18 0a9 9 0 0118 0z" />
            </svg>
          <?php endif; ?>
        </div>
        <p class="text-3xl font-bold text-gray-800 dark:text-white mt-2"><?php echo e($metric['count']); ?></p>
      </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </div>

  <!-- ORDER HISTORY -->
  <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-6">
    <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Recent Orders</h2>

    <?php if($orderHistory->isEmpty()): ?>
      <p class="text-gray-500 text-sm">No orders found.</p>
    <?php else: ?>
      <div class="overflow-x-auto">
        <table class="min-w-full text-sm text-left border-separate border-spacing-y-2">
          <thead class="text-gray-600 dark:text-gray-400 uppercase text-xs">
            <tr>
              <th class="py-2 px-3">Order</th>
              <th class="py-2 px-3">Items</th>
              <th class="py-2 px-3">Total</th>
              <th class="py-2 px-3">Status</th>
              <th class="py-2 px-3">Date</th>
              <th class="py-2 px-3 text-right">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php $__currentLoopData = $orderHistory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <tr class="bg-gray-50 dark:bg-gray-800/50 hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                <td class="py-2 px-3 font-medium text-gray-800 dark:text-white">
                  <a href="<?php echo e(route('shop.orders.show', $order->code)); ?>" class="hover:text-blue-600">
                    <?php echo e($order->code); ?>

                  </a>
                </td>
                <td class="py-2 px-3 text-gray-600 dark:text-gray-300"><?php echo e($order->items->sum('qty')); ?></td>
                <td class="py-2 px-3 text-gray-700 dark:text-gray-200">
                  Rp <?php echo e(number_format($order->grand_total ?? $order->total_price, 0, ',', '.')); ?>

                </td>
                <td class="py-2 px-3">
                  <?php
                    $color = match($order->status) {
                        \App\Enum\OrderStatus::PENDING => 'bg-yellow-100 text-yellow-700',
                        \App\Enum\OrderStatus::PROCESSING => 'bg-blue-100 text-blue-700',
                        \App\Enum\OrderStatus::CANCELED => 'bg-red-100 text-red-700',
                        \App\Enum\OrderStatus::SHIPPED => 'bg-indigo-100 text-indigo-700',
                        \App\Enum\OrderStatus::DELIVERED => 'bg-green-100 text-green-700',
                        default => 'bg-gray-100 text-gray-600',
                    };
                    ?>
                    <span class="px-2 py-1 rounded-full text-xs font-medium <?php echo e($color); ?>">
                    <?php echo e($order->status->label()); ?>

                    </span>
                </td>
                <td class="py-2 px-3 text-gray-600 dark:text-gray-300">
                  <?php echo e($order->created_at->format('d M Y')); ?>

                </td>
                <td class="py-2 px-3 text-right flex justify-end gap-2">
                  <a href="<?php echo e(route('shop.orders.show', $order->code)); ?>"
                     class="text-xs px-3 py-1.5 rounded-lg border dark:border-white/20 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">
                    View
                  </a>

                  <?php if($order->status->value === 'PENDING' && strtoupper($order->payment_status ?? '') === 'UNPAID'): ?>
                    <a href="<?php echo e(route('shop.orders.pay', $order)); ?>"
                       class="text-xs px-3 py-1.5 rounded-lg bg-blue-600 text-white hover:bg-blue-700">
                      Pay Now
                    </a>
                  <?php endif; ?>

                  <?php if($order->status->value === 'PENDING'): ?>
                    <button
                      @click="isModalOpen = true; deleteUrl = '<?php echo e(route('shop.orders.cancel', $order)); ?>'; title = '<?php echo e($order->code); ?>';"
                      type="button"
                      class="text-xs px-3 py-1.5 rounded-lg bg-red-600 text-white hover:bg-red-700">
                      Cancel
                    </button>
                  <?php endif; ?>
                </td>
              </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </tbody>
        </table>
      </div>
    <?php endif; ?>
  </div>

  <?php if (isset($component)) { $__componentOriginal1bb765878b9e0d6ed85f9c12a3781acf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1bb765878b9e0d6ed85f9c12a3781acf = $attributes; } ?>
<?php $component = App\View\Components\Modal\CancelOrderModal::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('modal.cancel-order-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Modal\CancelOrderModal::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1bb765878b9e0d6ed85f9c12a3781acf)): ?>
<?php $attributes = $__attributesOriginal1bb765878b9e0d6ed85f9c12a3781acf; ?>
<?php unset($__attributesOriginal1bb765878b9e0d6ed85f9c12a3781acf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1bb765878b9e0d6ed85f9c12a3781acf)): ?>
<?php $component = $__componentOriginal1bb765878b9e0d6ed85f9c12a3781acf; ?>
<?php unset($__componentOriginal1bb765878b9e0d6ed85f9c12a3781acf); ?>
<?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/gusde/Documents/laravel/marketplace-timedoor/resources/views/customer/dashboard/index.blade.php ENDPATH**/ ?>