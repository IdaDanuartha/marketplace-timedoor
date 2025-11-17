<?php $__env->startSection('title', 'Invoice - ' . $order->code); ?>

<?php $__env->startSection('content'); ?>
<!-- Breadcrumb -->
<nav class="mb-6 text-sm text-gray-500">
  <ol class="flex items-center space-x-2">
    <li><a href="<?php echo e(route('dashboard.index')); ?>" class="hover:underline">Dashboard</a></li>
    <li>/</li>
    <li>
      <a href="<?php echo e(route('orders.index')); ?>" class="hover:underline">Orders</a>
    </li>
    <li>/</li>
    <li>
      <a href="<?php echo e(route('orders.show', $order)); ?>" class="hover:underline">Detail Order</a>
    </li>
    <li>/</li>
    <li class="text-gray-700 dark:text-gray-300">Invoice</li>
  </ol>
</nav>

<div class="max-w-6xl mx-auto">
  <!-- Action Buttons -->
  <div class="flex justify-end items-center mb-6">
    <div class="flex gap-3">
      <a href="<?php echo e(route('orders.downloadInvoice', $order)); ?>" 
         class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm print:hidden">
        Download Invoice (PDF)
      </a>
    </div>
  </div>

  <!-- Invoice Container -->
  <div class="bg-white rounded-xl shadow-lg overflow-hidden print:shadow-none">
    <!-- Header with Brand -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-8 py-10">
      <div class="flex justify-between items-start">
        <div>
          <h1 class="text-3xl font-bold mb-2">INVOICE</h1>
          <p class="text-blue-100 text-sm">Invoice Number: <span class="font-semibold"><?php echo e($order->code); ?></span></p>
        </div>
        <div class="text-right">
          <!-- Logo/Brand Name -->
          <div class="text-2xl font-bold mb-2"><?php echo e(setting('site_name')); ?></div>
          <p class="text-blue-100 text-sm"><?php echo e(setting('site_description')); ?></p>
        </div>
      </div>
    </div>

    <!-- Invoice Details -->
    <div class="px-8 py-6">
      <div class="grid grid-cols-2 gap-8 mb-8">
        <!-- From (Company Info) -->
        <div>
          <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-3">From:</h3>
          <div class="text-gray-800">
            <p class="font-bold text-lg mb-1"><?php echo e(setting('site_name')); ?></p>
            <p class="text-sm"><?php echo e(setting('address')); ?></p>
            <p class="text-sm mt-2">Phone: <?php echo e(setting('phone_contact')); ?></p>
            <p class="text-sm">Email: <?php echo e(setting('email_contact')); ?></p>
            
          </div>
        </div>

        <!-- To (Customer Info) -->
        <div>
          <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-3">Bill To:</h3>
          <div class="text-gray-800">
            <p class="font-bold text-lg mb-1"><?php echo e($order->customer->name ?? '-'); ?></p>
            <p class="text-sm"><?php echo e($order->customer->user->email ?? '-'); ?></p>
            <p class="text-sm"><?php echo e($order->customer->phone ?? '-'); ?></p>
            <?php if($order->address->full_address): ?>
              <p class="text-sm mt-2"><?php echo e($order->address->full_address); ?></p>
            <?php endif; ?>
          </div>
        </div>
      </div>

      <!-- Invoice Meta Info -->
      <div class="grid grid-cols-3 gap-4 mb-8 p-4 bg-gray-50 rounded-lg">
        <div>
          <p class="text-xs text-gray-500 uppercase font-semibold mb-1">Invoice Date</p>
          <p class="text-sm font-medium text-gray-800"><?php echo e($order->created_at->format('d M Y')); ?></p>
        </div>
        <div>
          <p class="text-xs text-gray-500 uppercase font-semibold mb-1">Payment Method</p>
          <p class="text-sm font-medium text-gray-800"><?php echo e(ucwords(str_replace('_', ' ', $order->payment_method ?? 'N/A'))); ?></p>
        </div>
        <div>
          <p class="text-xs text-gray-500 uppercase font-semibold mb-1">Payment Status</p>
          <?php
            $paymentColor = match($order->payment_status) {
              'paid' => 'bg-green-100 text-green-700',
              'unpaid' => 'bg-yellow-100 text-yellow-700',
              'failed' => 'bg-red-100 text-red-700',
              default => 'bg-gray-100 text-gray-700',
            };
          ?>
          <span class="inline-block px-2 py-1 rounded text-xs font-semibold <?php echo e($paymentColor); ?>">
            <?php echo e(strtoupper($order->payment_status)); ?>

          </span>
        </div>
      </div>

      <!-- Items Table -->
      <div class="mb-8">
        <table class="w-full">
          <thead>
            <tr class="border-b-2 border-gray-300">
              <th class="text-left py-3 px-2 text-xs font-semibold text-gray-600 uppercase tracking-wide">Item</th>
              <th class="text-center py-3 px-2 text-xs font-semibold text-gray-600 uppercase tracking-wide w-20">Qty</th>
              <th class="text-right py-3 px-2 text-xs font-semibold text-gray-600 uppercase tracking-wide w-32">Unit Price</th>
              <th class="text-right py-3 px-2 text-xs font-semibold text-gray-600 uppercase tracking-wide w-32">Amount</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-200">
            <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <tr>
                <td class="py-4 px-2">
                  <p class="font-medium text-gray-800"><?php echo e($item->product->name ?? '-'); ?></p>
                </td>
                <td class="py-4 px-2 text-center text-gray-700">
                  <?php echo e($item->qty); ?>

                </td>
                <td class="py-4 px-2 text-right text-gray-700">
                  Rp<?php echo e(number_format($item->price, 0, ',', '.')); ?>

                </td>
                <td class="py-4 px-2 text-right font-medium text-gray-800">
                  Rp<?php echo e(number_format($item->price * $item->qty, 0, ',', '.')); ?>

                </td>
              </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </tbody>
        </table>
      </div>

      <!-- Totals -->
      <div class="flex justify-end mb-8">
        <div class="w-80">
          <div class="flex justify-between py-2 text-sm">
            <span class="text-gray-600">Subtotal:</span>
            <span class="font-medium text-gray-800">Rp<?php echo e(number_format($order->total_price, 0, ',', '.')); ?></span>
          </div>
          
          <div class="flex justify-between py-2 text-sm border-t border-gray-200">
            <span class="text-gray-600">Shipping (<?php echo e($order->shipping_service); ?>):</span>
            <span class="font-medium text-gray-800">Rp<?php echo e(number_format($order->shipping_cost, 0, ',', '.')); ?></span>
          </div>

          <?php if($order->discount > 0): ?>
            <div class="flex justify-between py-2 text-sm border-t border-gray-200">
              <span class="text-gray-600">Discount:</span>
              <span class="font-medium text-red-600">-Rp<?php echo e(number_format($order->discount, 0, ',', '.')); ?></span>
            </div>
          <?php endif; ?>

          <?php if($order->tax > 0): ?>
            <div class="flex justify-between py-2 text-sm border-t border-gray-200">
              <span class="text-gray-600">Tax (11%):</span>
              <span class="font-medium text-gray-800">Rp<?php echo e(number_format($order->tax, 0, ',', '.')); ?></span>
            </div>
          <?php endif; ?>

          <div class="flex justify-between py-4 text-lg font-bold border-t-2 border-gray-300 mt-2">
            <span class="text-gray-800">Total:</span>
            <span class="text-blue-600">Rp<?php echo e(number_format($order->grand_total, 0, ',', '.')); ?></span>
          </div>
        </div>
      </div>

      <!-- Payment Info (if paid) -->
      <?php if($order->payment_status === 'paid'): ?>
        <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-8">
          <div class="flex items-center gap-2 mb-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <p class="font-semibold text-green-800">Payment Received</p>
          </div>
          <p class="text-sm text-green-700">Thank you for your payment. This invoice has been marked as paid.</p>
          <?php if($order->payment_date): ?>
            <p class="text-xs text-green-600 mt-1">Paid on: <?php echo e($order->payment_date->format('d M Y, H:i')); ?></p>
          <?php endif; ?>
        </div>
      <?php endif; ?>

      <!-- Notes -->
      <?php if($order->notes): ?>
        <div class="mb-8">
          <h4 class="text-sm font-semibold text-gray-700 mb-2">Notes:</h4>
          <p class="text-sm text-gray-600 bg-gray-50 p-3 rounded"><?php echo e($order->notes); ?></p>
        </div>
      <?php endif; ?>

      <!-- Terms & Conditions -->
      <div class="border-t border-gray-200 pt-6">
        <h4 class="text-sm font-semibold text-gray-700 mb-3">Terms & Conditions:</h4>
        <ul class="text-xs text-gray-600 space-y-1 list-disc list-inside">
          <li>Payment is due within 7 days from the invoice date</li>
          <li>Please include the invoice number in your payment reference</li>
          <li>For any questions regarding this invoice, please contact our support team</li>
          <li>All prices are in Indonesian Rupiah (IDR)</li>
        </ul>
      </div>
    </div>

    <!-- Footer -->
    <div class="bg-gray-50 px-8 py-6 border-t border-gray-200">
      <div class="flex justify-between items-center text-xs text-gray-600">
        <p>Thank you for your business!</p>
        <p>Generated on <?php echo e(now()->format('d M Y, H:i')); ?></p>
      </div>
    </div>
  </div>
</div>

<?php $__env->startPush('css'); ?>
<style>
  @media print {
    body {
      margin: 0;
      padding: 0;
    }
    .max-w-4xl {
      max-width: 100%;
      margin: 0;
    }
    .rounded-xl {
      border-radius: 0;
    }
    @page {
      margin: 1cm;
    }
  }
</style>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/gusde/Documents/laravel/marketplace-timedoor/resources/views/admin/orders/invoice.blade.php ENDPATH**/ ?>