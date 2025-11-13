<?php $__env->startSection('title', 'Shopping Cart'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-5xl mx-auto py-8 space-y-6">
  <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-4">Shopping Cart</h1>

  <?php if(session('success')): ?>
    <div class="p-3 bg-green-100 border border-green-300 text-green-800 rounded-lg">
      <?php echo e(session('success')); ?>

    </div>
  <?php endif; ?>

  <?php $__empty_1 = true; $__currentLoopData = $cart->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <div class="flex items-center justify-between p-4 border dark:border-white/10 rounded-lg bg-white dark:bg-gray-900">
      <div class="flex items-center gap-4">
        <a href="<?php echo e(route('shop.products.show', $item->product)); ?>">
          <img src="<?php echo e(profile_image($item->product->image_path)); ?>" 
             class="w-16 h-16 rounded object-cover">
        </a>
        <div>
          <a href="<?php echo e(route('shop.products.show', $item->product)); ?>">
            <h3 class="font-semibold text-gray-900 dark:text-white"><?php echo e($item->product->name); ?></h3>
          </a>
          <p class="text-gray-500 dark:text-gray-400">Rp <?php echo e(number_format($item->product->price, 0, ',', '.')); ?></p>

          <form action="<?php echo e(route('shop.cart.update', $item)); ?>" method="POST" class="flex items-center gap-2 mt-2">
            <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
            <input type="number" name="qty" value="<?php echo e($item->qty); ?>" min="1"
              class="w-16 border rounded px-2 py-1 dark:bg-gray-900 dark:border-gray-700 dark:text-white">
            <button class="text-sm text-blue-600 hover:underline">Update</button>
          </form>
        </div>
      </div>

      <div class="text-right">
        <p class="font-semibold text-blue-600">Rp <?php echo e(number_format($item->subtotal, 0, ',', '.')); ?></p>
        <form action="<?php echo e(route('shop.cart.destroy', $item)); ?>" method="POST">
          <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
          <button class="text-sm text-red-500 hover:text-red-700 mt-1">Remove</button>
        </form>
      </div>
    </div>
  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <p class="text-gray-500 dark:text-gray-400">Your cart is empty.</p>
  <?php endif; ?>

  <?php if($cart->items->count()): ?>
    <div class="flex justify-between items-center mt-6">
      <h3 class="text-lg font-semibold text-gray-800 dark:text-white">
        Total: <span class="text-blue-600">Rp <?php echo e(number_format($total, 0, ',', '.')); ?></span>
      </h3>
      <div class="flex items-center gap-3">
        <form action="<?php echo e(route('shop.cart.clear')); ?>" method="POST">
          <?php echo csrf_field(); ?>
          <button class="px-5 py-3 text-sm bg-gray-100 dark:text-white dark:border-white/10 dark:bg-gray-800 border rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700">
            Clear Cart
          </button>
        </form>

        <form action="<?php echo e(route('shop.cart.checkout')); ?>" method="GET">
          <button class="px-5 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
            Proceed to Checkout
          </button>
        </form>
      </div>
    </div>
  <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/gusde/Documents/laravel/marketplace-timedoor/resources/views/shop/cart/index.blade.php ENDPATH**/ ?>