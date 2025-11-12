<?php $__env->startSection('title', 'Checkout'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-5xl mx-auto py-8 space-y-8">
  <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Checkout</h1>

  <form action="<?php echo e(route('shop.checkout.process')); ?>" method="POST">
    <?php echo csrf_field(); ?>

    
    <div class="p-6 border rounded-lg bg-white dark:bg-gray-900">
      <h2 class="font-semibold text-gray-800 dark:text-white mb-4">Shipping Address</h2>

      <?php if($addresses->isEmpty()): ?>
        <div class="text-sm text-gray-500 dark:text-gray-400">
          You don’t have any saved addresses yet. 
          <a href="<?php echo e(route('profile.addresses.index')); ?>" class="text-blue-600 hover:underline">Add one here</a>.
        </div>
      <?php else: ?>
        <div class="grid sm:grid-cols-2 gap-4">
          <?php $__currentLoopData = $addresses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $address): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <label 
              class="relative flex flex-col justify-between border rounded-lg p-4 cursor-pointer transition 
                    hover:border-blue-500 dark:border-gray-700 dark:hover:border-blue-500
                    <?php echo e($address->is_default ? 'border-blue-600 ring-2 ring-blue-400' : 'border-gray-300'); ?>">
              <input 
                type="radio" 
                name="address_id" 
                value="<?php echo e($address->id); ?>" 
                class="absolute top-3 right-3 w-4 h-4 text-blue-600 focus:ring-blue-500"
                <?php echo e($address->is_default ? 'checked' : ''); ?> 
                required
              />
              
              <div class="space-y-1">
                <div class="flex items-center gap-2">
                  <span class="font-semibold text-gray-800 dark:text-gray-100"><?php echo e($address->label); ?></span>
                  <?php if($address->is_default): ?>
                    <span class="px-2 py-0.5 text-xs rounded-full bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300">
                      Default
                    </span>
                  <?php endif; ?>
                </div>
                <p class="text-sm text-gray-600 dark:text-gray-300 leading-snug"><?php echo e($address->full_address); ?></p>
                <?php if($address->additional_information): ?>
                  <p class="text-xs text-gray-500 dark:text-gray-400"><?php echo e($address->additional_information); ?></p>
                <?php endif; ?>
                <p class="text-xs text-gray-500 dark:text-gray-400">
                  Postal Code: <?php echo e($address->postal_code ?? '-'); ?>

                </p>
              </div>
            </label>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
      <?php endif; ?>
    </div>

    
    <div class="p-6 border rounded-lg bg-white dark:bg-gray-900 space-y-3">
      <h2 class="font-semibold mb-3 text-gray-800 dark:text-white">Order Summary</h2>
      
      <?php $__currentLoopData = $cart->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="flex justify-between items-center text-sm text-gray-700 dark:text-gray-300">
          <span class="truncate"><?php echo e($item->product->name); ?> × <?php echo e($item->qty); ?></span>
          <span>Rp <?php echo e(number_format($item->subtotal, 0, ',', '.')); ?></span>
        </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

      <hr class="my-3 border-gray-300 dark:border-gray-700">

      <div class="flex justify-between text-sm text-gray-700 dark:text-gray-300">
        <span>Subtotal</span><span>Rp <?php echo e(number_format($subtotal, 0, ',', '.')); ?></span>
      </div>
      <div class="flex justify-between text-sm text-gray-700 dark:text-gray-300">
        <span>Shipping</span><span>Rp <?php echo e(number_format($shippingCost, 0, ',', '.')); ?></span>
      </div>
      <div class="flex justify-between font-semibold text-lg text-gray-800 dark:text-white">
        <span>Total</span><span>Rp <?php echo e(number_format($grandTotal, 0, ',', '.')); ?></span>
      </div>
    </div>

    
    <div class="flex justify-end">
      <button 
        type="submit" 
        class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium mt-4">
        Proceed to Payment
      </button>
    </div>
  </form>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/gusde/Documents/laravel/marketplace-timedoor/resources/views/shop/checkout/index.blade.php ENDPATH**/ ?>