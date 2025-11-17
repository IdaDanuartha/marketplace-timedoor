<?php $__env->startSection('title', 'Orders'); ?>

<?php $__env->startSection('content'); ?>
<div 
  x-data="{ 
    isModalOpen: false, 
    title: '', 
    deleteUrl: '',
    selectedOrders: [],
    selectAll: false,
    toggleAll() {
      if (this.selectAll) {
        this.selectedOrders = Array.from(document.querySelectorAll('.order-checkbox')).map(el => el.value);
      } else {
        this.selectedOrders = [];
      }
    },
    updateSelectAll() {
      const checkboxes = document.querySelectorAll('.order-checkbox');
      this.selectAll = checkboxes.length > 0 && this.selectedOrders.length === checkboxes.length;
    }
  }"
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

  <?php if(session('warning')): ?>
    <div class="mb-4 rounded-lg border border-yellow-200 bg-yellow-50 p-4 text-yellow-700 dark:border-yellow-700/40 dark:bg-yellow-900/30 dark:text-yellow-300">
      <div class="flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
        </svg>
        <span><?php echo e(session('warning')); ?></span>
      </div>
    </div>
  <?php endif; ?>

  <?php if($errors->any()): ?>
    <div class="mb-4 rounded-lg border border-red-200 bg-red-50 p-4 text-red-700 dark:border-red-700/40 dark:bg-red-900/30 dark:text-red-300">
      <ul class="space-y-1">
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <li><?php echo e($error); ?></li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </ul>
    </div>
  <?php endif; ?>

  <!-- Filters -->
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
  </div>

  <!-- Action Buttons -->
  <div class="flex justify-between items-center gap-4 mb-4">
    <!-- Send Email Button -->
    <div x-show="selectedOrders.length > 0" class="flex gap-2">
      <button 
        @click="
          if (confirm(`Send invoice emails to ${selectedOrders.length} selected order(s)?`)) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '<?php echo e(route('orders.send-invoices')); ?>';
            
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '<?php echo e(csrf_token()); ?>';
            form.appendChild(csrfToken);
            
            selectedOrders.forEach(id => {
              const input = document.createElement('input');
              input.type = 'hidden';
              input.name = 'order_ids[]';
              input.value = id;
              form.appendChild(input);
            });
            
            const sendPdf = document.createElement('input');
            sendPdf.type = 'hidden';
            sendPdf.name = 'send_pdf';
            sendPdf.value = '1';
            form.appendChild(sendPdf);
            
            document.body.appendChild(form);
            form.submit();
          }
        "
        class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition whitespace-nowrap flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
        </svg>
        Send Invoices (<span x-text="selectedOrders.length"></span>)
      </button>
    </div>

    <div class="flex gap-4 ml-auto">
      <a href="<?php echo e(route('orders.export', request()->query())); ?>" 
        class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition whitespace-nowrap">
        Export Excel
      </a>

      <?php if(auth()->user()?->admin): ?>
        <a href="<?php echo e(route('orders.create')); ?>" 
          class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition whitespace-nowrap w-full sm:w-auto text-center">
          + Add Order
        </a>
      <?php endif; ?>
    </div>
  </div>

  <!-- Table -->
  <div class="overflow-hidden rounded-xl border border-gray-200 bg-white dark:bg-transparent dark:border-white/20 shadow-sm">
    <div class="max-w-full overflow-x-auto">
      <table class="min-w-full text-left text-sm">
        <thead class="border-b border-gray-100 bg-gray-50 dark:border-white/20 dark:bg-white/5">
          <tr>
            <?php if(auth()->user()?->admin): ?>
              <th class="px-5 py-3 w-12">
                <input 
                  type="checkbox" 
                  x-model="selectAll"
                  @change="toggleAll()"
                  class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                >
              </th>
            <?php endif; ?>
            <th class="px-5 py-3 font-medium text-gray-600 dark:text-white">Code</th>
            <th class="px-5 py-3 font-medium text-gray-600 dark:text-white">Customer</th>
            <th class="px-5 py-3 font-medium text-gray-600 dark:text-white">Total</th>
            <th class="px-5 py-3 font-medium text-gray-600 dark:text-white">Shipping</th>
            <th class="px-5 py-3 font-medium text-gray-600 dark:text-white">Grand Total</th>
            <th class="px-5 py-3 font-medium text-gray-600 dark:text-white">Payment</th>
            <th class="px-5 py-3 font-medium text-gray-600 dark:text-white">Status</th>
            <?php if(auth()->user()?->admin): ?>
              <th class="px-5 py-3 font-medium text-gray-600 dark:text-white text-right">Actions</th>
            <?php endif; ?>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
          <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr class="hover:bg-gray-50 transition-colors">
              <?php if(auth()->user()?->admin): ?>
                <td class="px-5 py-3">
                  <input 
                    type="checkbox" 
                    value="<?php echo e($order->id); ?>"
                    x-model="selectedOrders"
                    @change="updateSelectAll()"
                    class="order-checkbox rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                    onclick="event.stopPropagation()"
                  >
                </td>
              <?php endif; ?>
              <td class="px-5 py-3 font-semibold text-gray-800 cursor-pointer" onclick="window.location='<?php echo e(route('orders.show', $order)); ?>'">
                <?php echo e($order->code); ?>

              </td>
              <td class="px-5 py-3 text-gray-700 cursor-pointer" onclick="window.location='<?php echo e(route('orders.show', $order)); ?>'">
                <?php echo e($order->customer->name ?? '-'); ?>

              </td>
              <td class="px-5 py-3 text-gray-700 cursor-pointer" onclick="window.location='<?php echo e(route('orders.show', $order)); ?>'">
                Rp<?php echo e(number_format($order->total_price, 0, ',', '.')); ?>

              </td>
              <td class="px-5 py-3 text-gray-700 cursor-pointer" onclick="window.location='<?php echo e(route('orders.show', $order)); ?>'">
                Rp<?php echo e(number_format($order->shipping_cost, 0, ',', '.')); ?>

              </td>
              <td class="px-5 py-3 font-semibold text-gray-900 cursor-pointer" onclick="window.location='<?php echo e(route('orders.show', $order)); ?>'">
                Rp<?php echo e(number_format($order->grand_total, 0, ',', '.')); ?>

              </td>
              <td class="px-5 py-3 text-gray-700 space-y-1 cursor-pointer" onclick="window.location='<?php echo e(route('orders.show', $order)); ?>'">
                <span class="block text-xs font-semibold"><?php echo e(strtoupper($order->payment_status)); ?></span>
                <span class="block text-xs text-gray-500"><?php echo e(strtoupper($order->payment_method ?? '-')); ?></span>
              </td>
              <td class="px-5 py-3 cursor-pointer" onclick="window.location='<?php echo e(route('orders.show', $order)); ?>'">
                <?php
                  $color = match($order->status) {
                    \App\Enum\OrderStatus::PENDING => 'bg-yellow-100 text-yellow-700',
                    \App\Enum\OrderStatus::PROCESSING => 'bg-blue-100 text-blue-700',
                    \App\Enum\OrderStatus::CANCELED => 'bg-red-100 text-red-700',
                    \App\Enum\OrderStatus::SHIPPED => 'bg-indigo-100 text-indigo-700',
                    \App\Enum\OrderStatus::DELIVERED => 'bg-green-100 text-green-700',
                    default => 'bg-gray-100 text-gray-600',
                  };
                ?>
                <span class="px-2 py-1 rounded-full text-xs font-medium <?php echo e($color); ?>">
                  <?php echo e($order->status); ?>

                </span>
              </td>
              <?php if(auth()->user()?->admin): ?>
                <td class="px-5 py-3 text-right">
                  <a href="<?php echo e(route('orders.edit', $order)); ?>" 
                    onclick="event.stopPropagation()" 
                    class="text-blue-600 hover:text-blue-800 font-medium mr-3">
                    Edit
                  </a>
                  <button 
                    @click.prevent="
                      event.stopPropagation();
                      title = '<?php echo e($order->code); ?>';
                      deleteUrl = '<?php echo e(route('orders.destroy', $order)); ?>';
                      isModalOpen = true
                    "
                    class="text-red-600 hover:text-red-700 font-medium">
                    Delete
                  </button>
                </td>
              <?php endif; ?>
            </tr>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
              <td colspan="9" class="px-5 py-6 text-center text-gray-500">
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
      width: 'resolve',
      minimumResultsForSearch: Infinity,
      dropdownAutoWidth: true,
    });
  });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/gusde/Documents/laravel/marketplace-timedoor/resources/views/admin/orders/index.blade.php ENDPATH**/ ?>