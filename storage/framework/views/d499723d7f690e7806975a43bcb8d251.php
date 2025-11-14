<?php $__env->startSection('title', 'My Wishlist'); ?>

<?php $__env->startSection('content'); ?>

<nav class="text-sm text-gray-500">
  <ol class="flex items-center space-x-2">
    <li><a href="<?php echo e(route('dashboard.index')); ?>" class="hover:underline">Dashboard</a></li>
    <li>/</li>
    <li class="text-gray-700 dark:text-gray-300">Wishlists</li>
  </ol>
</nav>

<div class="max-w-6xl mx-auto py-8">
  <h1 class="text-2xl font-bold mb-6 text-gray-800 dark:text-white">My Wishlist</h1>

  
  <?php if(session('success')): ?>
    <div class="p-3 bg-green-100 border border-green-300 text-green-800 rounded-lg mb-4"><?php echo e(session('success')); ?></div>
  <?php endif; ?>
  <?php if($errors->any()): ?>
    <div class="p-3 bg-red-100 border border-red-300 text-red-800 rounded-lg mb-4"><?php echo e($errors->first()); ?></div>
  <?php endif; ?>
  
  <?php if($wishlist->isEmpty()): ?>
    <p class="text-gray-500 dark:text-gray-400">Your wishlist is empty.</p>
  <?php else: ?>
    <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
      <?php $__currentLoopData = $wishlist; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="border rounded-lg bg-white dark:bg-gray-900 dark:border-gray-800 p-4 flex flex-col justify-between relative">
          <form action="<?php echo e(route('shop.wishlist.toggle', $item->product)); ?>" method="POST" class="absolute top-3 right-3"><?php echo csrf_field(); ?>
            <button type="submit" title="Remove from Wishlist">
              <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-6 h-6 text-red-500 hover:text-red-600" viewBox="0 0 24 24">
                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5a5.5 5.5 0 0111 0 5.5 5.5 0 0111 0c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
              </svg>
            </button>
          </form>
          <a href="<?php echo e(route('shop.products.show', $item->product->slug)); ?>">
            <img src="<?php echo e(profile_image($item->product->image_path)); ?>" 
                 alt="<?php echo e($item->product->name); ?>" class="w-full h-48 object-cover rounded mb-3">
            <h2 class="font-semibold text-gray-800 dark:text-white truncate"><?php echo e($item->product->name); ?></h2>
            <p class="text-sm text-gray-500"><?php echo e($item->product->category->name ?? 'Uncategorized'); ?></p>
            <p class="text-blue-600 font-semibold mt-2">Rp <?php echo e(number_format($item->product->price, 0, ',', '.')); ?></p>
          </a>
        </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
  <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/gusde/Documents/laravel/marketplace-timedoor/resources/views/shop/wishlist/index.blade.php ENDPATH**/ ?>