<?php $__env->startSection('title', 'Customers'); ?>

<?php $__env->startSection('content'); ?>
<div x-data="{ isModalOpen: false, title: '', deleteUrl: '' }" x-cloak>
  
  <nav class="mb-6 text-sm text-gray-500">
    <ol class="flex items-center space-x-2">
      <li><a href="<?php echo e(route('dashboard.index')); ?>" class="hover:underline">Dashboard</a></li>
      <li>/</li>
      <li class="text-gray-700 dark:text-gray-300">Customers</li>
    </ol>
  </nav>

  
  <?php if(session('success')): ?>
    <div class="mb-4 rounded-lg border border-green-200 bg-green-50 p-4 text-green-700 dark:border-green-700/40 dark:bg-green-900/30 dark:text-green-300">
      <?php echo e(session('success')); ?>

    </div>
  <?php endif; ?>

  
  <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-3">
    <form method="GET" class="flex items-center gap-2">
      <input type="text" name="search" value="<?php echo e($filters['search'] ?? ''); ?>" placeholder="Search customer..."
        class="border border-gray-300 dark:border-gray-700 rounded-lg px-3 py-2 w-64 bg-white dark:bg-gray-900 dark:text-gray-200 focus:ring-2 focus:ring-blue-500">
      <button class="px-3 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">Search</button>
    </form>
    <a href="<?php echo e(route('customers.create')); ?>" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">+ Add Customer</a>
  </div>

  
  <div class="overflow-hidden rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-900/50">
    <div class="max-w-full overflow-x-auto">
      <table class="min-w-full text-left text-sm">
        <thead class="border-b border-gray-100 dark:border-gray-800 bg-gray-50 dark:bg-gray-800/30">
          <tr>
            <th class="px-5 py-3 font-medium text-gray-600 dark:text-gray-300">Name</th>
            <th class="px-5 py-3 font-medium text-gray-600 dark:text-gray-300">Username</th>
            <th class="px-5 py-3 font-medium text-gray-600 dark:text-gray-300">Email</th>
            <th class="px-5 py-3 font-medium text-gray-600 dark:text-gray-300">Phone</th>
            <th class="px-5 py-3 font-medium text-gray-600 dark:text-gray-300 text-right">Actions</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
          <?php $__empty_1 = true; $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/40 cursor-pointer"
                onclick="window.location='<?php echo e(route('customers.show', $customer)); ?>'">
              <td class="px-5 py-3 text-gray-800 dark:text-gray-200 font-semibold"><?php echo e($customer->name); ?></td>
              <td class="px-5 py-3 text-gray-700 dark:text-gray-300"><?php echo e($customer->user->username); ?></td>
              <td class="px-5 py-3 text-gray-700 dark:text-gray-300"><?php echo e($customer->user->email); ?></td>
              <td class="px-5 py-3 text-gray-700 dark:text-gray-300"><?php echo e($customer->phone ?? '-'); ?></td>
              <td class="px-5 py-3 text-right">
                <a href="<?php echo e(route('customers.edit', $customer)); ?>" onclick="event.stopPropagation()" class="text-blue-600 hover:text-blue-800 dark:hover:text-blue-400 font-medium">Edit</a>
                <button 
                  @click.prevent="
                    event.stopPropagation();
                    title = '<?php echo e($customer->name); ?>';
                    deleteUrl = '<?php echo e(route('customers.destroy', $customer)); ?>';
                    isModalOpen = true
                  "
                  class="text-red-600 hover:text-red-700 dark:hover:text-red-400 ml-3 font-medium">
                  Delete
                </button>
              </td>
            </tr>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
              <td colspan="5" class="px-5 py-6 text-center text-gray-500 dark:text-gray-400">No customers found.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
    <div class="p-4"><?php echo e($customers->appends(request()->query())->links()); ?></div>
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
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/gusde/Documents/laravel/marketplace-timedoor/resources/views/admin/customers/index.blade.php ENDPATH**/ ?>