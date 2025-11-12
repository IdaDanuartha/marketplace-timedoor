<?php $__env->startSection('title', 'Shop Products'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-6xl mx-auto py-8">
  <h1 class="text-2xl font-bold mb-6 text-gray-800 dark:text-white">Shop Products</h1>

  
  <?php if(session('success')): ?>
    <div class="p-3 bg-green-100 border border-green-300 text-green-800 rounded-lg mb-4"><?php echo e(session('success')); ?></div>
  <?php endif; ?>
  <?php if($errors->any()): ?>
    <div class="p-3 bg-red-100 border border-red-300 text-red-800 rounded-lg mb-4"><?php echo e($errors->first()); ?></div>
  <?php endif; ?>

  
  <form method="GET" class="mb-6 flex gap-2 mt-4">
    <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Search products..."
      class="w-full border rounded-lg px-3 py-2 dark:bg-gray-900 dark:border-gray-700 dark:text-white">
    <button class="bg-blue-600 text-white px-4 rounded-lg hover:bg-blue-700">Search</button>
  </form>

  
  <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
    <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
      <div class="border rounded-lg bg-white dark:bg-gray-900 dark:border-gray-800 p-4 flex flex-col justify-between relative">
        
        <form action="<?php echo e(route('shop.wishlist.toggle', $product)); ?>" method="POST" class="absolute top-3 right-3"><?php echo csrf_field(); ?>
          <?php
            $isWished = Auth::check() && Auth::user()->customer
              ? Auth::user()->customer->wishlists()->where('product_id', $product->id)->exists()
              : false;
          ?>
          <button type="submit" title="Add to Wishlist">
            <?php if($isWished): ?>
              <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-6 h-6 text-red-500 hover:text-red-600" viewBox="0 0 24 24">
                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5a5.5 5.5 0 0111 0 5.5 5.5 0 0111 0c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
              </svg>
            <?php else: ?>
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" class="w-6 h-6 text-gray-400 hover:text-red-500" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a5.5 5.5 0 017.778 0L12 6.939l-.096-.096a5.5 5.5 0 117.778 7.778L12 21l-7.682-7.379a5.5 5.5 0 010-7.303z" />
              </svg>
            <?php endif; ?>
          </button>
        </form>

        <a href="<?php echo e(route('shop.products.show', $product)); ?>">
          <img src="<?php echo e(profile_image($product->image_path)); ?>" alt="<?php echo e($product->name); ?>"
            class="w-full h-48 object-cover rounded mb-3">
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