<?php $__env->startSection('title', $customer->name); ?>

<?php $__env->startSection('content'); ?>
<nav class="mb-6 text-sm text-gray-500">
  <ol class="flex items-center space-x-2">
    <li><a href="<?php echo e(route('dashboard.index')); ?>" class="hover:underline">Dashboard</a></li>
    <li>/</li>
    <li><a href="<?php echo e(route('customers.index')); ?>" class="hover:underline">Customers</a></li>
    <li>/</li>
    <li class="text-gray-700 dark:text-gray-300">Detail</li>
  </ol>
</nav>

<div class="max-w-4xl mx-auto space-y-6" x-data="{ isModalOpen: false, title: '', deleteUrl: '' }" x-cloak>

  
  <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/3 p-6">
    <div class="flex flex-col sm:flex-row items-center sm:items-start gap-5">
      <img src="<?php echo e(profile_image($customer->user->profile_image)); ?>" 
           class="w-24 h-24 rounded-full object-cover border dark:border-gray-700">
      <div class="text-center sm:text-left">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white"><?php echo e($customer->name); ?></h2>
        <p class="text-gray-600 dark:text-gray-300 text-sm"><?php echo e($customer->user->email); ?></p>
        <p class="text-gray-600 dark:text-gray-300 text-sm">Phone: <?php echo e($customer->phone ?? '-'); ?></p>
      </div>
    </div>
  </div>

  
  <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/3 p-6">
    <h3 class="text-lg font-medium text-gray-800 dark:text-white/90 mb-4">Addresses</h3>

    <div class="space-y-5">
      <?php $__empty_1 = true; $__currentLoopData = $customer->addresses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $address): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="border rounded-xl p-5 relative overflow-hidden dark:border-gray-700 <?php echo e($address->is_default ? 'bg-blue-50 dark:bg-blue-900/20' : 'bg-gray-50 dark:bg-gray-900/30'); ?>">
          <div class="flex justify-between items-start">
            <div>
              <p class="font-medium text-gray-800 dark:text-gray-100 mb-1">
                <?php echo e($address->label ?? 'Home'); ?>

              </p>
              <p class="text-sm text-gray-600 dark:text-gray-400 whitespace-pre-line">
                <?php echo e($address->full_address); ?>

              </p>
              <?php if($address->additional_information): ?>
                <p class="text-xs text-gray-500 mt-1 italic">
                  Note: <?php echo e($address->additional_information); ?>

                </p>
              <?php endif; ?>
              <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">
                Postal Code: <?php echo e($address->postal_code ?? '-'); ?>

              </p>
              <p class="text-xs text-gray-500 dark:text-gray-400">
                Lat: <?php echo e($address->latitude ?? '-'); ?>, Lng: <?php echo e($address->longitude ?? '-'); ?>

              </p>
            </div>

            <?php if($address->is_default): ?>
              <span class="text-xs px-2 py-1 bg-blue-100 text-blue-700 dark:bg-blue-800/50 dark:text-blue-300 rounded-md font-medium">
                Default
              </span>
            <?php endif; ?>
          </div>

          
          <?php if($address->latitude && $address->longitude): ?>
            <div class="mt-4 rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700 h-80" 
                 id="map-preview-<?php echo e($loop->index); ?>"></div>
          <?php endif; ?>
        </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <p class="text-gray-500 text-sm">No addresses available.</p>
      <?php endif; ?>
    </div>
  </div>

  
  <div class="flex justify-end gap-3">
    <a href="<?php echo e(route('customers.edit', $customer)); ?>" 
       class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm">Edit</a>
    <form action="<?php echo e(route('customers.destroy', $customer)); ?>" method="POST" 
          onsubmit="return confirm('Are you sure you want to delete this customer?')">
      <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
      <button 
        @click.prevent="
          event.stopPropagation();
          title = '<?php echo e($customer->name); ?>';
          deleteUrl = '<?php echo e(route('customers.destroy', $customer)); ?>';
          isModalOpen = true
        " 
        class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 text-sm">Delete</button>
    </form>
  </div>

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

<?php $__env->startPush('js'); ?>
<script>
document.addEventListener('DOMContentLoaded', () => {
  <?php $__currentLoopData = $customer->addresses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $address): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php if($address->latitude && $address->longitude): ?>
      const map<?php echo e($index); ?> = L.map('map-preview-<?php echo e($index); ?>', {
        zoomControl: false,
        scrollWheelZoom: false,
        // dragging: false
      }).setView([<?php echo e($address->latitude); ?>, <?php echo e($address->longitude); ?>], 13);

      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 18
      }).addTo(map<?php echo e($index); ?>);

      L.marker([<?php echo e($address->latitude); ?>, <?php echo e($address->longitude); ?>]).addTo(map<?php echo e($index); ?>);
    <?php endif; ?>
  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/gusde/Documents/laravel/marketplace-timedoor/resources/views/admin/customers/show.blade.php ENDPATH**/ ?>