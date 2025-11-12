<?php $__env->startSection('title', 'Order Details'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-5xl mx-auto py-8 space-y-6">
  <div class="flex justify-between items-center">
    <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Order #<?php echo e($order->code); ?></h1>
    <a href="<?php echo e(route('shop.orders.index')); ?>" class="text-blue-600 text-sm hover:underline">← Back to Orders</a>
  </div>

  <div class="p-6 border rounded-lg bg-white dark:bg-gray-900 space-y-5">
    <div class="flex justify-between items-center">
      <div>
        <span class="block text-sm text-gray-500 dark:text-gray-400">Order Date:</span>
        <span class="font-semibold text-gray-800 dark:text-white"><?php echo e($order->created_at->format('d M Y, H:i')); ?></span>
      </div>

      <div class="text-right">
        <span class="block text-sm text-gray-500 dark:text-gray-400">Status:</span>
        <span class="font-semibold text-gray-800 dark:text-white"><?php echo e($order->status->label()); ?></span>
      </div>
    </div>

    <hr class="border-gray-300 dark:border-gray-700">

    
    <div class="space-y-3">
      <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="flex justify-between text-sm text-gray-700 dark:text-gray-300">
          <span><?php echo e($item->product->name); ?> × <?php echo e($item->qty); ?></span>
          <span>Rp <?php echo e(number_format($item->qty * $item->price, 0, ',', '.')); ?></span>
        </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <hr class="border-gray-300 dark:border-gray-700">

    
    <div class="text-sm text-gray-700 dark:text-gray-300 space-y-1">
      <div class="flex justify-between"><span>Subtotal:</span><span>Rp <?php echo e(number_format($order->total_price, 0, ',', '.')); ?></span></div>
      <div class="flex justify-between"><span>Shipping:</span><span>Rp <?php echo e(number_format($order->shipping_cost, 0, ',', '.')); ?></span></div>
      <div class="flex justify-between font-semibold text-gray-900 dark:text-white text-lg">
        <span>Total:</span><span>Rp <?php echo e(number_format($order->grand_total, 0, ',', '.')); ?></span>
      </div>
    </div>

    <hr class="border-gray-300 dark:border-gray-700">

    
    <div class="flex justify-between items-center">
      <div>
        <span class="block text-sm text-gray-500 dark:text-gray-400">Payment Method:</span>
        <span class="font-medium text-gray-800 dark:text-white"><?php echo e(strtoupper($order->payment_method ?? '-')); ?></span>
      </div>
      <div>
        <span class="block text-sm text-gray-500 dark:text-gray-400">Payment Status:</span>
        <span class="font-medium text-gray-800 dark:text-white"><?php echo e(strtoupper($order->payment_status ?? 'UNPAID')); ?></span>
      </div>
    </div>

    
    <div class="flex justify-end gap-3 pt-4">
      <?php if($order->status->value === 'PENDING' && $order->payment_status === 'UNPAID'): ?>
        <a href="<?php echo e(route('shop.orders.pay', $order)); ?>"
           class="px-5 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm font-medium">
          Pay Now
        </a>
        <form action="<?php echo e(route('shop.orders.cancel', $order)); ?>" method="POST" onsubmit="return confirm('Cancel this order?')">
          <?php echo csrf_field(); ?>
          <?php echo method_field('PATCH'); ?>
          <button type="submit" class="px-5 py-2.5 bg-red-600 text-white rounded-lg hover:bg-red-700 text-sm font-medium">
            Cancel Order
          </button>
        </form>
      <?php endif; ?>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/gusde/Documents/laravel/marketplace-timedoor/resources/views/shop/orders/show.blade.php ENDPATH**/ ?>