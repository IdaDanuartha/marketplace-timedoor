<?php $__env->startSection('title', 'Payment Success'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-xl mx-auto text-center py-10">
  <h1 class="text-2xl font-bold text-green-600 mb-4">Payment Successful!</h1>
  <p class="text-gray-700 dark:text-gray-300">Thank you for your purchase. Your order <strong><?php echo e($order->code); ?></strong> is being processed.</p>
  <a href="<?php echo e(route('shop.products.index')); ?>" class="mt-6 inline-block px-5 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Continue Shopping</a>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/gusde/Documents/laravel/marketplace-timedoor/resources/views/shop/checkout/success.blade.php ENDPATH**/ ?>