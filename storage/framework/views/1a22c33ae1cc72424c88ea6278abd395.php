<?php $__env->startSection('title', 'Order Details'); ?>

<?php $__env->startSection('content'); ?>


<?php if(session('success')): ?>
  <div class="p-3 bg-green-100 border border-green-300 text-green-800 rounded-lg mb-4">
    <?php echo e(session('success')); ?>

  </div>
<?php endif; ?>
<?php if($errors->any()): ?>
  <div class="p-3 bg-red-100 border border-red-300 text-red-800 rounded-lg mb-4">
    <?php echo e($errors->first()); ?>

  </div>
<?php endif; ?>

<div class="max-w-5xl mx-auto py-8 space-y-6" x-data="{ isModalOpen: false, deleteUrl: '', title: '' }">

  
  <div class="flex justify-between items-center">
    <h1 class="text-2xl font-bold text-gray-800 dark:text-white">
      Order #<?php echo e($order->code); ?>

    </h1>
    <a href="<?php echo e(route('shop.orders.index')); ?>" 
       class="text-blue-600 text-sm hover:underline">← Back to Orders</a>
  </div>

  
  <div class="p-6 border rounded-lg bg-white dark:bg-gray-900 space-y-6 dark:border-white/10">

    
    <div class="flex flex-col md:flex-row md:justify-between gap-4">

      
      <div>
        <p class="text-sm text-gray-500 dark:text-gray-400">Order Date</p>
        <p class="font-semibold text-gray-800 dark:text-white">
          <?php echo e($order->created_at->format('d M Y, H:i')); ?>

        </p>
      </div>

      
      <div class="text-left md:text-right">
        <p class="text-sm text-gray-500 dark:text-gray-400">Order Status</p>
        <?php
          $color = match($order->status->value ?? '') {
              'PENDING' => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-300',
              'PROCESSING' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300',
              'SHIPPED' => 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-300',
              'DELIVERED' => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300',
              'CANCELED' => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-300',
              default => 'bg-gray-200 text-gray-700 dark:bg-gray-800 dark:text-gray-300'
          };
        ?>
        <span class="px-3 py-1 text-xs rounded-full font-medium <?php echo e($color); ?>">
          <?php echo e($order->status->label()); ?>

        </span>
      </div>
    </div>

    <hr class="border-gray-300 dark:border-gray-700">

    
    <div class="space-y-1">
      <p class="text-sm text-gray-500 dark:text-gray-400">Shipping Method</p>
      <p class="font-medium text-gray-800 dark:text-white">
        <?php echo e($order->shipping_service ?? '-'); ?>

      </p>
    </div>

    <hr class="border-gray-300 dark:border-gray-700">

    
    <div class="space-y-4">
      <h2 class="font-semibold text-gray-800 dark:text-white">Order Items</h2>

      <div class="space-y-3">
        <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <div class="flex justify-between items-center border rounded-lg p-4 bg-gray-50 dark:bg-gray-800/40">
            <div>
              <p class="font-medium text-gray-800 dark:text-white">
                <?php echo e($item->product->name); ?>

              </p>
              <p class="text-sm text-gray-600 dark:text-gray-300">
                Qty: <?php echo e($item->qty); ?>

              </p>
            </div>

            <p class="font-semibold text-gray-800 dark:text-white">
              Rp <?php echo e(number_format($item->qty * $item->price, 0, ',', '.')); ?>

            </p>
          </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
    </div>

    <hr class="border-gray-300 dark:border-gray-700">

    
    <div class="space-y-2 text-sm text-gray-700 dark:text-gray-300">
      <div class="flex justify-between">
        <span>Subtotal</span>
        <span>Rp <?php echo e(number_format($order->total_price, 0, ',', '.')); ?></span>
      </div>
      <div class="flex justify-between">
        <span>Shipping</span>
        <span>Rp <?php echo e(number_format($order->shipping_cost, 0, ',', '.')); ?></span>
      </div>
      <div class="flex justify-between font-semibold text-lg text-gray-900 dark:text-white">
        <span>Total</span>
        <span>Rp <?php echo e(number_format($order->grand_total, 0, ',', '.')); ?></span>
      </div>
    </div>

    <hr class="border-gray-300 dark:border-gray-700">

    
    <div class="grid sm:grid-cols-2 gap-4">
      
      <div>
        <p class="text-sm text-gray-500 dark:text-gray-400">Payment Method</p>
        <p class="font-medium text-gray-800 dark:text-white">
          <?php echo e(strtoupper($order->payment_method ?? '-')); ?>

        </p>
      </div>

      <div>
        <p class="text-sm text-gray-500 dark:text-gray-400">Payment Status</p>

        <?php
          $payColor = $order->payment_status === 'PAID'
              ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300'
              : 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-300';
        ?>

        <span class="px-3 py-1 text-xs rounded-full font-medium <?php echo e($payColor); ?>">
          <?php echo e(strtoupper($order->payment_status ?? 'UNPAID')); ?>

        </span>
      </div>

    </div>

    
    <div class="flex justify-end gap-3 pt-4">
      <?php if($order->status->value === 'PENDING' && $order->payment_status === 'UNPAID'): ?>
        <a href="<?php echo e(route('shop.orders.pay', $order)); ?>"
           class="px-5 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm font-medium">
          Pay Now
        </a>

        <button 
          @click="isModalOpen = true; deleteUrl = '<?php echo e(route('shop.orders.cancel', $order)); ?>'; title = '<?php echo e($order->code); ?>';"
          class="px-5 py-2.5 bg-red-600 text-white rounded-lg hover:bg-red-700 text-sm font-medium">
          Cancel Order
        </button>
      <?php endif; ?>
    </div>

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
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/gusde/Documents/laravel/marketplace-timedoor/resources/views/shop/orders/show.blade.php ENDPATH**/ ?>