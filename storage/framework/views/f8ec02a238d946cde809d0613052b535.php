<?php $__env->startSection('title', 'Checkout'); ?>

<?php $__env->startSection('content'); ?>
<nav class="text-sm text-gray-500">
  <ol class="flex items-center space-x-2">
    <li><a href="<?php echo e(route('dashboard.index')); ?>" class="hover:underline">Dashboard</a></li>
    <li>/</li>
    <li><a href="<?php echo e(route('shop.cart.index')); ?>" class="hover:underline">Carts</a></li>
    <li>/</li>
    <li class="text-gray-700 dark:text-gray-300">Checkout</li>
  </ol>
</nav>

<div class="max-w-6xl mx-auto py-8 space-y-8">
  <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Checkout</h1>

  <form x-data="checkoutData(<?php echo e($subtotal); ?>, <?php echo e($shippingCost); ?>)" action="<?php echo e(route('shop.checkout.process')); ?>" method="POST">
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

    
    <?php if(!empty($shippingOptions)): ?>
    <div class="p-6 border rounded-lg my-4 bg-white dark:bg-gray-900">
      <h2 class="font-semibold text-gray-800 dark:text-white mb-4">Shipping Method</h2>

      <div class="grid sm:grid-cols-2 gap-4">
        <?php $__currentLoopData = $shippingOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <?php
            $value = $option['code'].'|'.$option['service'].'|'.$option['cost'];
          ?>

          <label 
            class="flex flex-col justify-between border rounded-lg p-4 cursor-pointer transition 
                  hover:border-blue-500 dark:border-gray-700 dark:hover:border-blue-500">

            <div class="flex items-start gap-3">
              <input 
                type="radio" 
                name="shipping_service" 
                value="<?php echo e($value); ?>" 
                required
                @click="updateShipping(<?php echo e($option['cost']); ?>)"
                class="mt-1 w-4 h-4 text-blue-600 focus:ring-blue-500"
              />

              <div class="space-y-0.5">
                <p class="font-semibold text-gray-800 dark:text-gray-100">
                  <?php echo e($option['name']); ?> — <?php echo e($option['service']); ?>

                </p>

                <?php if(!empty($option['description'])): ?>
                <p class="text-sm text-gray-600 dark:text-gray-300">
                  <?php echo e($option['description'] === 'Unknown Service' ? '-' : $option['description']); ?>

                </p>
                <?php endif; ?>

                <p class="text-xs text-gray-500 dark:text-gray-400">
                  Estimation: <?php echo e($option['etd'] ?? 'N/A'); ?>

                </p>
              </div>
            </div>

            <span class="font-semibold text-gray-900 dark:text-white mt-3 text-right">
              Rp <?php echo e(number_format($option['cost'], 0, ',', '.')); ?>

            </span>
          </label>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
    </div>
    <?php endif; ?>

    
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
        <span>Shipping</span><span x-text="'Rp ' + shipping.toLocaleString('id-ID')"></span>
      </div>
      <div class="flex justify-between font-semibold text-lg text-gray-800 dark:text-white">
        <span>Total</span><span x-text="'Rp ' + grandTotal.toLocaleString('id-ID')" class="font-semibold text-lg text-gray-800 dark:text-white"></span>
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

<?php $__env->startPush('js'); ?>
<script>
  function checkoutData(subtotal, initialShipping) {
      return {
          subtotal: subtotal,
          shipping: initialShipping,
          get grandTotal() {
              return this.subtotal + this.shipping;
          },
          updateShipping(cost) {
              this.shipping = parseInt(cost);
          }
      }
  }
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/gusde/Documents/laravel/marketplace-timedoor/resources/views/shop/checkout/index.blade.php ENDPATH**/ ?>