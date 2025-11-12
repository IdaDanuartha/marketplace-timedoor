<?php $__env->startSection('title', 'My Reviews'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-6xl mx-auto py-8">
  <h1 class="text-2xl font-bold mb-6 text-gray-800 dark:text-white">My Reviews</h1>

  <?php if($reviews->isEmpty()): ?>
    <p class="text-gray-500 dark:text-gray-400">You haven’t reviewed any products yet.</p>
  <?php else: ?>
    <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
      <?php $__currentLoopData = $reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="border rounded-lg bg-white dark:bg-gray-900 dark:border-gray-800 p-4 space-y-3">
          <a href="<?php echo e(route('shop.products.show', $review->product)); ?>">
            <img src="<?php echo e(profile_image($review->product->image_path)); ?>" 
                 alt="<?php echo e($review->product->name); ?>"
                 class="w-full h-40 object-cover rounded-lg mb-2">
            <h2 class="font-semibold text-gray-800 dark:text-white"><?php echo e($review->product->name); ?></h2>
            <div class="flex items-center mt-1">
              <?php for($i = 1; $i <= 5; $i++): ?>
                <svg xmlns="http://www.w3.org/2000/svg" fill="<?php echo e($i <= $review->rating ? 'currentColor' : 'none'); ?>"
                  class="w-4 h-4 <?php echo e($i <= $review->rating ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-600'); ?>"
                  viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.948a1 1 0 00.95.69h4.148c.969 0 1.371 1.24.588 1.81l-3.36 2.44a1 1 0 00-.364 1.118l1.286 3.948c.3.921-.755 1.688-1.54 1.118l-3.36-2.44a1 1 0 00-1.176 0l-3.36 2.44c-.785.57-1.84-.197-1.54-1.118l1.286-3.948a1 1 0 00-.364-1.118l-3.36-2.44c-.783-.57-.38-1.81.588-1.81h4.148a1 1 0 00.95-.69l1.286-3.948z"/>
                </svg>
              <?php endfor; ?>
            </div>
          </a>
          <p class="text-sm text-gray-600 dark:text-gray-300"><?php echo e($review->comment ?? 'No comment.'); ?></p>
          <form action="<?php echo e(route('shop.reviews.destroy', $review)); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <?php echo method_field('DELETE'); ?>
            <button class="text-xs text-red-600 hover:underline mt-1">Delete</button>
          </form>
        </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
  <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/gusde/Documents/laravel/marketplace-timedoor/resources/views/shop/reviews/index.blade.php ENDPATH**/ ?>