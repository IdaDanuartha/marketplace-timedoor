<?php $__env->startSection('title', 'My Orders'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-6xl mx-auto py-8 space-y-6" x-data="{ isModalOpen: false, deleteUrl: '', title: '' }">
  <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">My Orders</h1>

  <?php if($orders->isEmpty()): ?>
    <div class="p-6 text-center bg-white dark:bg-gray-900 border rounded-lg text-gray-600 dark:text-gray-300">
      You have no orders yet.
      <a href="<?php echo e(route('shop.products.index')); ?>" class="text-blue-600 hover:underline">Start shopping</a>
    </div>
  <?php else: ?>
    <div class="space-y-5">
      <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="border dark:border-white/10 rounded-lg bg-white dark:bg-gray-900 p-5 hover:shadow-md transition">
          <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
              <h2 class="font-semibold text-gray-800 dark:text-white">Order #<?php echo e($order->code); ?></h2>
              <p class="text-sm text-gray-500 dark:text-gray-400">
                <?php echo e($order->created_at->format('d M Y, H:i')); ?>

              </p>
            </div>

            <div class="flex items-center gap-2">
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
              <?php if($order->payment_status !== 'CANCELED'): ?>
                <span class="px-2 py-1 text-xs rounded-full uppercase <?php echo e($order->payment_status === 'PAID' || $order->payment_status === 'paid' ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600'); ?>">
                  <?php echo e($order->payment_status); ?>

                </span>
              <?php endif; ?>
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
            <a href="<?php echo e(route('shop.orders.show', $order->code)); ?>" 
               class="text-sm px-4 py-2 rounded-lg border text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">
              View Details
            </a>

            <?php if($order->status->value === 'PENDING'): ?>
              <button @click="isModalOpen = true; deleteUrl = '<?php echo e(route('shop.orders.cancel', $order)); ?>'; title = '<?php echo e($order->code); ?>';" class="text-sm px-4 py-2 rounded-lg bg-red-600 text-white hover:bg-red-700">
                Cancel
              </button>

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
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/gusde/Documents/laravel/marketplace-timedoor/resources/views/shop/orders/index.blade.php ENDPATH**/ ?>