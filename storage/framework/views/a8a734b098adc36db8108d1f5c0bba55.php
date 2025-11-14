<?php $__env->startSection('title', 'Address Detail'); ?>

<?php $__env->startSection('content'); ?>
<nav class="text-sm text-gray-500 mb-5">
  <ol class="flex items-center space-x-2">
    <li><a href="<?php echo e(route('dashboard.index')); ?>" class="hover:underline">Dashboard</a></li>
    <li>/</li>
    <li><a href="<?php echo e(route('profile.addresses.index')); ?>" class="hover:underline">My Addresses</a></li>
    <li>/</li>
    <li class="text-gray-700 dark:text-gray-300">Detail</li>
  </ol>
</nav>

<div class="max-w-6xl mx-auto space-y-6">
  <div class="flex justify-between items-center">
    <h1 class="text-xl font-semibold text-gray-800 dark:text-white">Address Detail</h1>
    <a href="<?php echo e(route('profile.addresses.index')); ?>" class="text-sm text-blue-600 hover:underline">← Back</a>
  </div>

  <div class="rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-900 p-5 space-y-3">
    <p><span class="font-semibold">Label:</span> <?php echo e($address->label); ?></p>
    <p><span class="font-semibold">Full Address:</span> <?php echo e($address->full_address); ?></p>
    <?php if($address->additional_information): ?>
      <p><span class="font-semibold">Additional Info:</span> <?php echo e($address->additional_information); ?></p>
    <?php endif; ?>
    <p><span class="font-semibold">Postal Code:</span> <?php echo e($address->postal_code ?? '-'); ?></p>
    <p><span class="font-semibold">Coordinates:</span> 
      <?php echo e($address->latitude ?? '-'); ?>, <?php echo e($address->longitude ?? '-'); ?>

    </p>
    <?php if($address->is_default): ?>
      <p><span class="px-2 py-0.5 text-xs bg-blue-100 text-blue-700 rounded-full">Default Address</span></p>
    <?php endif; ?>
  </div>

  
  <?php if($address->latitude && $address->longitude): ?>
  <div>
    <h2 class="text-lg font-medium text-gray-800 dark:text-white mb-2">Location Map</h2>
    <div id="map" class="w-full h-80 rounded-lg border border-gray-300 dark:border-gray-700 overflow-hidden"></div>
  </div>
  <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('js'); ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
  const lat = <?php echo e($address->latitude ?? 'null'); ?>;
  const lng = <?php echo e($address->longitude ?? 'null'); ?>;

  if (!lat || !lng) return;

  const map = L.map('map').setView([lat, lng], 15);

  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 18,
    attribution: '© OpenStreetMap contributors'
  }).addTo(map);

  const marker = L.marker([lat, lng]).addTo(map);
  marker.bindPopup(`<b><?php echo e($address->label); ?></b><br><?php echo e($address->full_address); ?>`).openPopup();
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/gusde/Documents/laravel/marketplace-timedoor/resources/views/profile/addresses/show.blade.php ENDPATH**/ ?>