<?php $__env->startSection('title', 'Orders'); ?>

<?php $__env->startSection('content'); ?>
<div 
  x-data="{ isModalOpen: false, title: '', deleteUrl: '' }"
  x-cloak
>
  <!-- Breadcrumb -->
  <nav class="mb-6 text-sm text-gray-500">
    <ol class="flex items-center space-x-2">
      <li><a href="<?php echo e(route('dashboard.index')); ?>" class="hover:underline">Dashboard</a></li>
      <li>/</li>
      <li class="text-gray-700 dark:text-gray-300">Orders</li>
    </ol>
  </nav>

  <!-- Flash Messages -->
  <?php if(session('success')): ?>
    <div class="mb-4 rounded-lg border border-green-200 bg-green-50 p-4 text-green-700 dark:border-green-700/40 dark:bg-green-900/30 dark:text-green-300">
      <div class="flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
        </svg>
        <span><?php echo e(session('success')); ?></span>
      </div>
    </div>
  <?php endif; ?>

  <?php if($errors->any()): ?>
    <div class="mb-4 rounded-lg border border-red-200 bg-red-50 p-4 text-red-700 dark:border-red-700/40 dark:bg-red-900/30 dark:text-red-300">
      <div class="flex items-start gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M12 5a7 7 0 100 14 7 7 0 000-14z" />
        </svg>
        <ul class="space-y-1">
          <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li><?php echo e($error); ?></li>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
      </div>
    </div>
  <?php endif; ?>

  <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-3">
    <form method="GET" class="flex sm:flex-nowrap flex-wrap items-center gap-2">
      <input type="text" name="search" value="<?php echo e($filters['search'] ?? ''); ?>" placeholder="Search order..."
        class="border border-gray-300 dark:border-gray-700 rounded-lg px-3 py-2 w-64 bg-white dark:bg-gray-900 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">

      <select name="status" class="select2 w-20">
        <option value="">All Status</option>
        <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <option value="<?php echo e($status->name); ?>" <?php echo e(($filters['status'] ?? '') === $status->name ? 'selected' : ''); ?>>
            <?php echo e($status->label()); ?>

          </option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </select>

      <button class="px-3 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
        Filter
      </button>
    </form>

    <a href="<?php echo e(route('orders.create')); ?>" 
       class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
      + Add Order
    </a>
  </div>

  <!-- Table -->
  <div class="overflow-hidden rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-900/50">
    <div class="max-w-full overflow-x-auto">
      <table class="min-w-full text-left text-sm">
        <thead class="border-b border-gray-100 dark:border-gray-800 bg-gray-50 dark:bg-gray-800/30">
          <tr>
            <th class="px-5 py-3 font-medium text-gray-600 dark:text-gray-300">
              <a href="<?php echo e(route('orders.index', [
                'sort_by' => 'code',
                'sort_dir' => ($filters['sort_by'] ?? '') === 'code' && ($filters['sort_dir'] ?? '') === 'asc' ? 'desc' : 'asc',
                'search' => $filters['search'] ?? '',
              ])); ?>" class="flex items-center gap-1 hover:underline">
                Code
                <?php if(($filters['sort_by'] ?? '') === 'code'): ?>
                  <?php if(($filters['sort_dir'] ?? '') === 'asc'): ?>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
                    </svg>
                  <?php else: ?>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                  <?php endif; ?>
                <?php endif; ?>
              </a>
            </th>

            <th class="px-5 py-3 font-medium text-gray-600 dark:text-gray-300">Customer</th>

            <th class="px-5 py-3 font-medium text-gray-600 dark:text-gray-300">
              <a href="<?php echo e(route('orders.index', [
                'sort_by' => 'total_price',
                'sort_dir' => ($filters['sort_by'] ?? '') === 'total_price' && ($filters['sort_dir'] ?? '') === 'asc' ? 'desc' : 'asc',
                'search' => $filters['search'] ?? '',
              ])); ?>" class="flex items-center gap-1 hover:underline">
                Total
                <?php if(($filters['sort_by'] ?? '') === 'total_price'): ?>
                  <?php if(($filters['sort_dir'] ?? '') === 'asc'): ?>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
                    </svg>
                  <?php else: ?>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                  <?php endif; ?>
                <?php endif; ?>
              </a>
            </th>

            <th class="px-5 py-3 font-medium text-gray-600 dark:text-gray-300">
              <a href="<?php echo e(route('orders.index', [
                'sort_by' => 'shipping_cost',
                'sort_dir' => ($filters['sort_by'] ?? '') === 'shipping_cost' && ($filters['sort_dir'] ?? '') === 'asc' ? 'desc' : 'asc',
                'search' => $filters['search'] ?? '',
              ])); ?>" class="flex items-center gap-1 hover:underline">
                Shipping
                <?php if(($filters['sort_by'] ?? '') === 'shipping_cost'): ?>
                  <?php if(($filters['sort_dir'] ?? '') === 'asc'): ?>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
                    </svg>
                  <?php else: ?>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                  <?php endif; ?>
                <?php endif; ?>
              </a>
            </th>

            <th class="px-5 py-3 font-medium text-gray-600 dark:text-gray-300">
              <a href="<?php echo e(route('orders.index', [
                'sort_by' => 'status',
                'sort_dir' => ($filters['sort_by'] ?? '') === 'status' && ($filters['sort_dir'] ?? '') === 'asc' ? 'desc' : 'asc',
                'search' => $filters['search'] ?? '',
              ])); ?>" class="flex items-center gap-1 hover:underline">
                Status
                <?php if(($filters['sort_by'] ?? '') === 'status'): ?>
                  <?php if(($filters['sort_dir'] ?? '') === 'asc'): ?>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
                    </svg>
                  <?php else: ?>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                  <?php endif; ?>
                <?php endif; ?>
              </a>
            </th>

            <th class="px-5 py-3 font-medium text-gray-600 dark:text-gray-300 text-right">Actions</th>
          </tr>
        </thead>

        <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
          <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr
              onclick="window.location='<?php echo e(route('orders.show', $order)); ?>'"
              class="cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-800/40 transition-colors"
            >
              <td class="px-5 py-3 font-semibold text-gray-800 dark:text-gray-100"><?php echo e($order->code); ?></td>
              <td class="px-5 py-3 text-gray-700 dark:text-gray-300"><?php echo e($order->customer->name ?? '-'); ?></td>
              <td class="px-5 py-3 text-gray-700 dark:text-gray-300">Rp<?php echo e(number_format($order->total_price, 0, ',', '.')); ?></td>
              <td class="px-5 py-3 text-gray-700 dark:text-gray-300">Rp<?php echo e(number_format($order->shipping_cost, 0, ',', '.')); ?></td>
              <td class="px-5 py-3 text-center">
                <?php
                  $color = match($order->status) {
                    \App\Enum\OrderStatus::PENDING => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-300',
                    \App\Enum\OrderStatus::PROCESSING => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300',
                    \App\Enum\OrderStatus::SHIPPED => 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-300',
                    \App\Enum\OrderStatus::DELIVERED => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300',
                    \App\Enum\OrderStatus::CANCELED => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-300',
                  };
                ?>
                <span class="px-2 py-1 rounded-full text-xs font-medium text-nowrap <?php echo e($color); ?>">
                  <?php echo e($order->status->label()); ?>

                </span>
              </td>
              <td class="px-5 py-3 text-right">
                <a href="<?php echo e(route('orders.edit', $order)); ?>" onclick="event.stopPropagation()"
                  class="text-blue-600 hover:text-blue-800 dark:hover:text-blue-400 font-medium transition">
                  Edit
                </a>
                <button 
                  @click.prevent="
                    event.stopPropagation();
                    title = '<?php echo e($order->code); ?>'; 
                    deleteUrl = '<?php echo e(route('orders.destroy', $order)); ?>'; 
                    isModalOpen = true
                  "
                  class="text-red-600 hover:text-red-700 dark:hover:text-red-400 ml-3 font-medium transition">
                  Delete
                </button>
              </td>
            </tr>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
              <td colspan="7" class="px-5 py-6 text-center text-gray-500 dark:text-gray-400">
                No orders found.
              </td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

    <div class="p-4">
      <?php echo e($orders->appends(request()->query())->links()); ?>

    </div>
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


<script>
  document.addEventListener('DOMContentLoaded', function () {
    $('.select2').select2({
      width: '100%',
      minimumResultsForSearch: 0,
    });
  });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/gusde/Documents/laravel/marketplace-timedoor/resources/views/admin/orders/index.blade.php ENDPATH**/ ?>