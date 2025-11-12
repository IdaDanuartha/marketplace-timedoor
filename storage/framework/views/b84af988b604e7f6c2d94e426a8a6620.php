<?php $__env->startSection('title', 'My Orders'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-6xl mx-auto py-8 space-y-6">
  <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">My Orders</h1>

  <?php if($orders->isEmpty()): ?>
    <div class="p-6 text-center bg-white dark:bg-gray-900 border rounded-lg text-gray-600 dark:text-gray-300">
      You have no orders yet.
      <a href="<?php echo e(route('shop.products.index')); ?>" class="text-blue-600 hover:underline">Start shopping</a>
    </div>
  <?php else: ?>
    <div class="space-y-5">
      <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="border rounded-lg bg-white dark:bg-gray-900 p-5 hover:shadow-md transition">
          <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
              <h2 class="font-semibold text-gray-800 dark:text-white">Order #<?php echo e($order->code); ?></h2>
              <p class="text-sm text-gray-500 dark:text-gray-400">
                <?php echo e($order->created_at->format('d M Y, H:i')); ?>

              </p>
            </div>

            <div class="flex items-center gap-2">
              <span class="px-2 py-1 text-xs font-semibold rounded-full 
                class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                  'bg-yellow-100 text-yellow-700' => $order->status->value === 'PENDING',
                  'bg-blue-100 text-blue-700' => $order->status->value === 'PROCESSING',
                  'bg-purple-100 text-purple-700' => $order->status->value === 'SHIPPED',
                  'bg-green-100 text-green-700' => $order->status->value === 'DELIVERED',
                  'bg-red-100 text-red-700' => $order->status->value === 'CANCELED',
                ]); ?>"">
                <?php echo e($order->status->label()); ?>

              </span>
              <span class="px-2 py-1 text-xs rounded bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-300">
                <?php echo e($order->payment_status); ?>

              </span>
            </div>
          </div>

          <hr class="my-3 border-gray-200 dark:border-gray-700">

          
          <div class="space-y-3">
            <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <div class="flex justify-between items-center text-sm text-gray-700 dark:text-gray-300">
                <span><?php echo e($item->product->name); ?> × <?php echo e($item->qty); ?></span>
                <span>Rp <?php echo e(number_format($item->qty * $item->price, 0, ',', '.')); ?></span>
              </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </div>

          <div class="flex justify-between items-center mt-4 font-semibold text-gray-800 dark:text-white">
            <span>Total:</span>
            <span>Rp <?php echo e(number_format($order->grand_total, 0, ',', '.')); ?></span>
          </div>

          
          <div class="flex justify-end gap-3 mt-4">
            <a href="<?php echo e(route('shop.orders.show', $order)); ?>" 
               class="text-sm px-4 py-2 rounded-lg border text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">
              View Details
            </a>

            <?php if($order->status->value === 'PENDING'): ?>
              <form action="<?php echo e(route('shop.orders.cancel', $order)); ?>" method="POST" onsubmit="return confirm('Cancel this order?')">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PATCH'); ?>
                <button type="submit" class="text-sm px-4 py-2 rounded-lg bg-red-600 text-white hover:bg-red-700">
                  Cancel
                </button>
              </form>

              <?php if($order->payment_status === 'UNPAID'): ?>
                <a href="<?php echo e(route('shop.orders.pay', $order)); ?>" 
                   class="text-sm px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700">
                  Pay Now
                </a>
              <?php endif; ?>
            <?php endif; ?>
          </div>
        </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
  <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/gusde/Documents/laravel/marketplace-timedoor/resources/views/shop/orders/index.blade.php ENDPATH**/ ?>