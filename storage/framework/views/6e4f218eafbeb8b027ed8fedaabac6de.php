<?php $__env->startSection('title', 'Vendors'); ?>

<?php $__env->startSection('content'); ?>
<div 
  x-data="{ isModalOpen: false, title: '', deleteUrl: '' }"
  x-cloak
>
  
  <nav class="mb-6 text-sm text-gray-500">
    <ol class="flex items-center space-x-2">
      <li><a href="<?php echo e(route('dashboard.index')); ?>" class="hover:underline">Dashboard</a></li>
      <li>/</li>
      <li class="text-gray-700 dark:text-gray-300">Vendors</li>
    </ol>
  </nav>

  
  <?php if(session('success')): ?>
    <div class="mb-4 rounded-lg border border-green-200 bg-green-50 p-4 text-green-700 dark:border-green-700/40 dark:bg-green-900/30 dark:text-green-300">
      <div class="flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
        </svg>
        <span><?php echo e(session('success')); ?></span>
      </div>
    </div>
  <?php endif; ?>

  <?php if($errors->any()): ?>
    <div class="mb-4 rounded-lg border border-red-200 bg-red-50 p-4 text-red-700 dark:border-red-700/40 dark:bg-red-900/30 dark:text-red-300">
      <ul class="space-y-1 list-disc pl-4">
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <li><?php echo e($error); ?></li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </ul>
    </div>
  <?php endif; ?>

  
  <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-3">
    <form method="GET" class="flex items-center gap-2 sm:flex-nowrap flex-wrap">
      <input type="text" name="search" value="<?php echo e($filters['search'] ?? ''); ?>" placeholder="Search vendor..."
        class="border border-gray-300 dark:border-gray-700 rounded-lg px-3 py-2 w-64 bg-white dark:bg-gray-900 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">

      <select name="status" class="select2">
        <option value="">All Status</option>
        <option value="1" <?php echo e(($filters['status'] ?? '') === '1' ? 'selected' : ''); ?>>Approved</option>
        <option value="0" <?php echo e(($filters['status'] ?? '') === '0' ? 'selected' : ''); ?>>Pending</option>
      </select>

      <button class="px-3 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">Filter</button>
    </form>

    <a href="<?php echo e(route('vendors.create')); ?>" 
        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
      + Add Vendor
    </a>
  </div>

  
  <div class="overflow-hidden rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-900/50">
    <div class="max-w-full overflow-x-auto">
      <table class="min-w-full text-left text-sm">
        <thead class="border-b border-gray-100 dark:border-gray-800 bg-gray-50 dark:bg-gray-800/30">
          <tr>
            
            <th class="px-5 py-3 font-medium text-gray-600 dark:text-gray-300">
              <a href="<?php echo e(route('vendors.index', array_merge(request()->query(), [
                'sort_by' => 'name',
                'sort_dir' => ($filters['sort_by'] ?? '') === 'name' && ($filters['sort_dir'] ?? '') === 'asc' ? 'desc' : 'asc'
              ]))); ?>" class="flex items-center gap-1 hover:underline">
                Vendor Name
                <?php if(($filters['sort_by'] ?? '') === 'name'): ?>
                  <?php if(($filters['sort_dir'] ?? '') === 'asc'): ?>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 text-gray-500" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/></svg>
                  <?php else: ?>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 text-gray-500" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                  <?php endif; ?>
                <?php endif; ?>
              </a>
            </th>

            <th class="px-5 py-3 font-medium text-gray-600 dark:text-gray-300">Username</th>

            <th class="px-5 py-3 font-medium text-gray-600 dark:text-gray-300">
              <a href="<?php echo e(route('vendors.index', array_merge(request()->query(), [
                'sort_by' => 'email',
                'sort_dir' => ($filters['sort_by'] ?? '') === 'email' && ($filters['sort_dir'] ?? '') === 'asc' ? 'desc' : 'asc'
              ]))); ?>" class="flex items-center gap-1 hover:underline">
                Email
                <?php if(($filters['sort_by'] ?? '') === 'email'): ?>
                  <?php if(($filters['sort_dir'] ?? '') === 'asc'): ?>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 text-gray-500" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/></svg>
                  <?php else: ?>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 text-gray-500" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                  <?php endif; ?>
                <?php endif; ?>
              </a>
            </th>

            <th class="px-5 py-3 font-medium text-gray-600 dark:text-gray-300 text-center">
              <a href="<?php echo e(route('vendors.index', array_merge(request()->query(), [
                'sort_by' => 'is_approved',
                'sort_dir' => ($filters['sort_by'] ?? '') === 'is_approved' && ($filters['sort_dir'] ?? '') === 'asc' ? 'desc' : 'asc'
              ]))); ?>" class="flex items-center justify-center gap-1 hover:underline">
                Approved
                <?php if(($filters['sort_by'] ?? '') === 'is_approved'): ?>
                  <?php if(($filters['sort_dir'] ?? '') === 'asc'): ?>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 text-gray-500" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/></svg>
                  <?php else: ?>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 text-gray-500" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                  <?php endif; ?>
                <?php endif; ?>
              </a>
            </th>

            <th class="px-5 py-3 font-medium text-gray-600 dark:text-gray-300 text-right">Actions</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
          <?php $__empty_1 = true; $__currentLoopData = $vendors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vendor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/40 cursor-pointer" 
                onclick="window.location='<?php echo e(route('vendors.show', $vendor)); ?>'">
              <td class="px-5 py-3 text-gray-800 dark:text-gray-200 font-semibold"><?php echo e($vendor->name); ?></td>
              <td class="px-5 py-3 text-gray-700 dark:text-gray-300"><?php echo e($vendor->user->username); ?></td>
              <td class="px-5 py-3 text-gray-700 dark:text-gray-300"><?php echo e($vendor->user->email); ?></td>
              <td class="px-5 py-3 text-center">
                <?php if($vendor->is_approved): ?>
                  <span class="px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300">
                    Approved
                  </span>
                <?php else: ?>
                  <span class="px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-300">
                    Pending
                  </span>
                <?php endif; ?>
              </td>
              <td class="px-5 py-3 text-right">
                <a href="<?php echo e(route('vendors.edit', $vendor)); ?>" onclick="event.stopPropagation()"
                  class="text-blue-600 hover:text-blue-800 dark:hover:text-blue-400 font-medium transition">
                  Edit
                </a>
                <button 
                  @click.prevent="
                    event.stopPropagation();
                    title = '<?php echo e($vendor->name); ?>'; 
                    deleteUrl = '<?php echo e(route('vendors.destroy', $vendor)); ?>'; 
                    isModalOpen = true
                  "
                  class="text-red-600 hover:text-red-700 dark:hover:text-red-400 ml-3 font-medium transition">
                  Delete
                </button>
              </td>
            </tr>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
              <td colspan="5" class="px-5 py-6 text-center text-gray-500 dark:text-gray-400">
                No vendors found.
              </td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

    <div class="p-4">
      <?php echo e($vendors->appends(request()->query())->links()); ?>

    </div>
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
  document.addEventListener('DOMContentLoaded', function () {
    $('.select2').select2({
      width: '100%',
      minimumResultsForSearch: 0,
    });
  });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/gusde/Documents/laravel/marketplace-timedoor/resources/views/admin/vendors/index.blade.php ENDPATH**/ ?>