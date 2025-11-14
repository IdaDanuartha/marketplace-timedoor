<?php $__env->startSection('title', 'My Addresses'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-4xl mx-auto space-y-8" x-data="{ openDelete: false, deleteUrl: '' }">
  
  <nav class="text-sm text-gray-500">
    <ol class="flex items-center space-x-2">
      <li><a href="<?php echo e(route('dashboard.index')); ?>" class="hover:underline">Dashboard</a></li>
      <li>/</li>
      <li class="text-gray-700 dark:text-gray-300">My Addresses</li>
    </ol>
  </nav>

  <div class="flex items-center justify-between">
    <h1 class="text-xl font-semibold text-gray-800 dark:text-white">My Addresses</h1>
    <a href="<?php echo e(route('profile.addresses.create')); ?>" 
      class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm rounded-lg">
      + Add Address
    </a>
  </div>

  
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

  
  <div class="space-y-4">
    <?php $__empty_1 = true; $__currentLoopData = $addresses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $address): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
      <div class="p-5 rounded-xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900">
        <div class="flex justify-between items-center">
          <div>
            <h3 class="font-semibold text-gray-900 dark:text-white flex items-center gap-2">
              <?php echo e($address->label); ?>

              <?php if($address->is_default): ?>
                <span class="px-2 py-0.5 text-xs rounded-full bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300">
                  Default
                </span>
              <?php endif; ?>
            </h3>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1"><?php echo e($address->full_address); ?></p>
            <?php if($address->additional_information): ?>
              <p class="text-xs text-gray-500 dark:text-gray-500"><?php echo e($address->additional_information); ?></p>
            <?php endif; ?>
          </div>
          <div class="flex items-center gap-2">
            <a href="<?php echo e(route('profile.addresses.show', $address->id)); ?>" 
              class="text-gray-600 hover:text-blue-600 dark:text-gray-300 dark:hover:text-blue-400 text-sm">View</a>
            <a href="<?php echo e(route('profile.addresses.edit', $address->id)); ?>" 
              class="text-gray-600 hover:text-green-600 dark:text-gray-300 dark:hover:text-green-400 text-sm">Edit</a>
            <button @click.prevent="
                      event.stopPropagation();
                      title = '<?php echo e($address->label); ?>'; 
                      deleteUrl = '<?php echo e(route('profile.addresses.destroy', $address->id)); ?>'; 
                      isModalOpen = true
                    "
              class="text-red-500 hover:text-red-600 text-sm">Delete</button>
          </div>
        </div>
      </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
      <p class="text-gray-500 dark:text-gray-400 text-sm">You don’t have any addresses yet.</p>
    <?php endif; ?>
  </div>

  <!-- Delete Modal -->
<?php if (isset($component)) { $__componentOriginalacfa148ccbbfb47f9db0a9452e7e721a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalacfa148ccbbfb47f9db0a9452e7e721a = $attributes; } ?>
<?php $component = App\View\Components\Modal\ModalDelete::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('modal.modal-delete'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Modal\ModalDelete::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalacfa148ccbbfb47f9db0a9452e7e721a)): ?>
<?php $attributes = $__attributesOriginalacfa148ccbbfb47f9db0a9452e7e721a; ?>
<?php unset($__attributesOriginalacfa148ccbbfb47f9db0a9452e7e721a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalacfa148ccbbfb47f9db0a9452e7e721a)): ?>
<?php $component = $__componentOriginalacfa148ccbbfb47f9db0a9452e7e721a; ?>
<?php unset($__componentOriginalacfa148ccbbfb47f9db0a9452e7e721a); ?>
<?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/gusde/Documents/laravel/marketplace-timedoor/resources/views/profile/addresses/index.blade.php ENDPATH**/ ?>