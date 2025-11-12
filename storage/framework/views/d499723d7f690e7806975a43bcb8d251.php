<?php $__env->startSection('title', 'My Wishlist'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-5xl mx-auto space-y-6">
  <h1 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">My Wishlist</h1>

  <?php if(session('success')): ?>
    <div class="p-3 bg-green-100 border border-green-300 text-green-800 rounded-lg">
      <?php echo e(session('success')); ?>

    </div>
  <?php endif; ?>

  <?php $__empty_1 = true; $__currentLoopData = $wishlist; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <div class="flex items-center justify-between p-4 border rounded-lg bg-white dark:bg-gray-900">
      <div class="flex items-center gap-4">
        <img src="<?php echo e($product->image_url ?? asset('images/placeholder-image.svg')); ?>" class="w-16 h-16 object-cover rounded">
        <div>
          <h3 class="font-medium text-gray-900 dark:text-white"><?php echo e($product->name); ?></h3>
          <p class="text-sm text-gray-600 dark:text-gray-400">Rp <?php echo e(number_format($product->price, 0, ',', '.')); ?></p>
        </div>
      </div>
      <div class="flex gap-2">
        <form action="<?php echo e(route('shop.wishlist.destroy', $product)); ?>" method="POST">
          <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
          <button class="px-3 py-1 text-sm text-red-500 hover:text-red-700">Remove</button>
        </form>
        <a href="<?php echo e(route('shop.products.show', $product)); ?>"
          class="px-3 py-1 text-sm text-blue-600 hover:text-blue-800">View</a>
      </div>
    </div>
  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <p class="text-gray-500 dark:text-gray-400 text-sm">Your wishlist is empty.</p>
  <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/gusde/Documents/laravel/marketplace-timedoor/resources/views/shop/wishlist/index.blade.php ENDPATH**/ ?>