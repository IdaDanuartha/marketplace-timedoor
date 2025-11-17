<div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-3 mb-6">
    <form method="GET" class="flex flex-wrap items-center gap-2 w-full lg:w-auto">
      <input type="text" 
        name="search" 
        value="<?php echo e($filters['search'] ?? ''); ?>" 
        placeholder="Search order or customer..." 
        class="border border-gray-300 rounded-lg px-3 py-2 w-full sm:w-64 bg-white dark:bg-transparent dark:border-white/20 dark:text-white text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
      >

      <select name="status" class="select2 rounded-lg border border-gray-300 px-3 py-2 w-[150px]">
        <option value="">All Status</option>
        <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <option value="<?php echo e($status->value); ?>" <?php if(($filters['status'] ?? '') === $status->value): echo 'selected'; endif; ?>>
            <?php echo e($status->label()); ?>

          </option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </select>

      <select name="payment_status" class="select2 rounded-lg border border-gray-300 px-3 py-2 w-[150px]">
        <option value="">All Payment</option>
        <?php $__currentLoopData = ['unpaid', 'paid', 'failed']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ps): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <option value="<?php echo e($ps); ?>" <?php if(($filters['payment_status'] ?? '') === $ps): echo 'selected'; endif; ?>>
            <?php echo e(ucfirst($ps)); ?>

          </option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </select>

      <select name="payment_method" class="select2 rounded-lg border border-gray-300 px-3 py-2 w-[160px]">
        <option value="">All Methods</option>
        <?php $__currentLoopData = ['bank_transfer', 'gopay', 'qris', 'credit_card']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $method): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <option value="<?php echo e($method); ?>" <?php if(($filters['payment_method'] ?? '') === $method): echo 'selected'; endif; ?>>
            <?php echo e(ucwords(str_replace('_', ' ', $method))); ?>

          </option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </select>

      <div class="flex gap-3">
        <input type="date" 
          name="date_from" 
          value="<?php echo e($filters['date_from'] ?? ''); ?>" 
          class="border border-gray-300 rounded-lg px-3 py-2 w-40"
        >
        <input type="date" 
          name="date_to" 
          value="<?php echo e($filters['date_to'] ?? ''); ?>" 
          class="border border-gray-300 rounded-lg px-3 py-2 w-40"
        >
      </div>

      <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition whitespace-nowrap">
        Filter
      </button>
    </form>
  </div><?php /**PATH /Users/gusde/Documents/laravel/marketplace-timedoor/resources/views/admin/orders/partials/filters.blade.php ENDPATH**/ ?>