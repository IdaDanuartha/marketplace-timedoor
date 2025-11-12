<?php $__env->startSection('title', $product->name); ?>

<?php $__env->startSection('content'); ?>

<?php if(session('success')): ?>
  <div class="p-3 bg-green-100 border border-green-300 text-green-800 rounded-lg mb-4"><?php echo e(session('success')); ?></div>
<?php endif; ?>
<?php if($errors->any()): ?>
  <div class="p-3 bg-red-100 border border-red-300 text-red-800 rounded-lg mb-4"><?php echo e($errors->first()); ?></div>
<?php endif; ?>

<div class="max-w-5xl mx-auto py-8 grid grid-cols-1 md:grid-cols-2 gap-8">
  
  <div>
    <img src="<?php echo e(profile_image($product->image_path)); ?>" alt="<?php echo e($product->name); ?>"
         class="w-full h-96 object-cover rounded-lg border dark:border-gray-700">
  </div>

  
  <div>
    <div class="flex items-start justify-between">
      <div>
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white"><?php echo e($product->name); ?></h1>
        <p class="text-gray-500 dark:text-gray-400 mt-1"><?php echo e($product->category->name ?? 'Uncategorized'); ?></p>
      </div>

      
      <form action="<?php echo e(route('shop.wishlist.toggle', $product)); ?>" method="POST"><?php echo csrf_field(); ?>
        <?php
          $isWished = Auth::check() && Auth::user()->customer
            ? Auth::user()->customer->wishlists()->where('product_id', $product->id)->exists()
            : false;
        ?>
        <button type="submit" title="Add to Wishlist">
          <?php if($isWished): ?>
            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-7 h-7 text-red-500 hover:text-red-600" viewBox="0 0 24 24">
              <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5a5.5 5.5 0 0111 0 5.5 5.5 0 0111 0c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
            </svg>
          <?php else: ?>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" class="w-7 h-7 text-gray-400 hover:text-red-500" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a5.5 5.5 0 017.778 0L12 6.939l-.096-.096a5.5 5.5 0 117.778 7.778L12 21l-7.682-7.379a5.5 5.5 0 010-7.303z" />
            </svg>
          <?php endif; ?>
        </button>
      </form>
    </div>

    <p class="text-2xl text-blue-600 font-semibold mt-4">Rp <?php echo e(number_format($product->price, 0, ',', '.')); ?></p>

    <p class="mt-6 text-gray-700 dark:text-gray-300 leading-relaxed">
      <?php echo $product->description ?? 'No description available for this product.'; ?>

    </p>

    <div class="mt-8 flex gap-3">
      <form action="<?php echo e(route('shop.cart.add', $product)); ?>" method="POST"><?php echo csrf_field(); ?>
        <button class="px-5 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700">Add to Cart</button>
      </form>
      <form action="<?php echo e(route('shop.cart.buyNow', $product)); ?>" method="POST"><?php echo csrf_field(); ?>
        <button class="px-5 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Buy Now</button>
      </form>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/gusde/Documents/laravel/marketplace-timedoor/resources/views/shop/products/show.blade.php ENDPATH**/ ?>