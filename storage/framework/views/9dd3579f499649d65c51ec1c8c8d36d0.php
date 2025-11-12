<?php $__env->startSection('title', $product->name); ?>

<?php $__env->startSection('content'); ?>
  
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

<div class="max-w-5xl mx-auto py-8 grid grid-cols-1 md:grid-cols-2 gap-8">
  
  <div>
    <img src="<?php echo e(profile_image($product->image_path)); ?>" 
         alt="<?php echo e($product->name); ?>" class="w-full h-96 object-cover rounded-lg border dark:border-gray-700">
  </div>

  
  <div>
    <h1 class="text-2xl font-bold text-gray-800 dark:text-white"><?php echo e($product->name); ?></h1>
    <p class="text-gray-500 dark:text-gray-400 mt-1"><?php echo e($product->category->name ?? 'Uncategorized'); ?></p>
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