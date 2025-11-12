<?php $__env->startSection('title', 'Shop Products'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-6xl mx-auto py-8">
  <h1 class="text-2xl font-bold mb-6 text-gray-800 dark:text-white">Shop Products</h1>

  
  <?php if(session('success')): ?>
    <div class="p-3 bg-green-100 border border-green-300 text-green-800 rounded-lg">
      <?php echo e(session('success')); ?>

    </div>
  <?php endif; ?>
  <?php if($errors->any()): ?>
    <div class="p-3 bg-red-100 border border-red-300 text-red-800 rounded-lg">
      <?php echo e($errors->first()); ?>

    </div>
  <?php endif; ?>

  
  <form method="GET" class="mb-6 flex gap-2 mt-4">
    <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Search products..."
      class="w-full border rounded-lg px-3 py-2 dark:bg-gray-900 dark:border-gray-700 dark:text-white">
    <button class="bg-blue-600 text-white px-4 rounded-lg hover:bg-blue-700">Search</button>
  </form>

  
  <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
    <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
      <div class="border rounded-lg bg-white dark:bg-gray-900 dark:border-gray-800 p-4 flex flex-col justify-between">
        <a href="<?php echo e(route('shop.products.show', $product)); ?>">
          <img src="<?php echo e(profile_image($product->image_path)); ?>" 
               alt="<?php echo e($product->name); ?>" class="w-full h-48 object-cover rounded mb-3">
          <h2 class="font-semibold text-gray-800 dark:text-white truncate"><?php echo e($product->name); ?></h2>
          <p class="text-sm text-gray-500"><?php echo e($product->category->name ?? 'Uncategorized'); ?></p>
          <p class="text-blue-600 font-semibold mt-2">Rp <?php echo e(number_format($product->price, 0, ',', '.')); ?></p>
        </a>
        <div class="mt-4 flex gap-2">
          <form action="<?php echo e(route('shop.cart.add', $product)); ?>" method="POST"><?php echo csrf_field(); ?>
            <button class="px-3 py-2 bg-green-600 text-white text-sm rounded-lg hover:bg-green-700 w-full">Add to Cart</button>
          </form>
          <form action="<?php echo e(route('shop.cart.buyNow', $product)); ?>" method="POST"><?php echo csrf_field(); ?>
            <button class="px-3 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 w-full">Buy Now</button>
          </form>
        </div>
      </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
      <p class="text-gray-500 dark:text-gray-400 col-span-full">No products found.</p>
    <?php endif; ?>
  </div>

  <div class="mt-8"><?php echo e($products->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/gusde/Documents/laravel/marketplace-timedoor/resources/views/shop/products/index.blade.php ENDPATH**/ ?>