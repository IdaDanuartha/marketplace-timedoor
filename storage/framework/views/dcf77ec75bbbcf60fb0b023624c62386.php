<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Invoice <?php echo e($order->code); ?></title>

  <style>
    body {
      font-family: Arial, sans-serif;
      font-size: 12px;
      color: #333;
    }

    .container {
      width: 100%;
      max-width: 750px;
      margin: 0 auto;
      padding: 20px;
    }

    .header {
      background: #1e3a8a;
      color: #fff;
      padding: 20px;
    }

    .header h1 {
      margin: 0 0 5px 0;
      font-size: 26px;
    }

    .flex {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
    }

    .box {
      margin-top: 20px;
    }

    .title {
      font-weight: bold;
      font-size: 14px;
      margin-bottom: 5px;
    }

    .section-title {
      font-weight: bold;
      margin-bottom: 5px;
      margin-top: 20px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 15px;
    }

    table th, table td {
      border: 1px solid #ccc;
      padding: 8px;
    }

    table th {
      background: #f3f4f6;
      font-weight: bold;
      font-size: 11px;
      text-transform: uppercase;
    }

    .right {
      text-align: right;
    }

    .center {
      text-align: center;
    }

    .total-box {
      margin-top: 20px;
      width: 260px;
      float: right;
    }

    .total-box div {
      display: flex;
      justify-content: space-between;
      padding: 5px 0;
    }

    .paid-box {
      margin-top: 20px;
      padding: 10px;
      border: 1px solid #16a34a;
      color: #166534;
      background: #dcfce7;
    }

    .notes {
      margin-top: 20px;
      padding: 10px;
      background: #f9fafb;
      border: 1px solid #e5e7eb;
    }

    .terms {
      margin-top: 20px;
      font-size: 11px;
    }

    .footer {
      margin-top: 30px;
      padding-top: 10px;
      border-top: 1px solid #ddd;
      font-size: 11px;
      color: #666;
      text-align: right;
    }

    @page {
      margin: 20px;
    }
  </style>
</head>

<body>

<div class="container">

  <!-- HEADER -->
  <div class="header">
    <div class="flex">
      <div>
        <h1>INVOICE</h1>
        <p>Invoice Number: <strong><?php echo e($order->code); ?></strong></p>
      </div>

      <div>
        <h2 style="margin:0; font-size:20px; font-weight:bold;"><?php echo e(setting('site_name')); ?></h2>
        <p style="margin:0; font-size:12px;"><?php echo e(setting('site_description')); ?></p>
      </div>
    </div>
  </div>

  <!-- FROM / TO -->
  <div class="flex box">
    <div style="width:48%;">
      <div class="title">From:</div>
      <p><?php echo e(setting('site_name')); ?><br>
        <?php echo e(setting('address')); ?><br>
        Phone: <?php echo e(setting('phone_contact')); ?><br>
        Email: <?php echo e(setting('email_contact')); ?><br>
      </p>
    </div>

    <div style="width:48%;">
      <div class="title">Bill To:</div>
      <p>
        <strong><?php echo e($order->customer->name ?? '-'); ?></strong><br>
        <?php echo e($order->customer->user->email ?? '-'); ?><br>
        <?php echo e($order->customer->phone ?? '-'); ?><br>
        <?php if($order->address->full_address): ?>
          <?php echo e($order->address->full_address); ?>

        <?php endif; ?>
      </p>
    </div>
  </div>

  <!-- META INFO -->
  <div class="box">
    <table style="width:100%; border:1px solid #ccc;">
      <tr>
        <th>Invoice Date</th>
        <th>Payment Method</th>
        <th>Payment Status</th>
      </tr>
      <tr>
        <td><?php echo e($order->created_at->format('d M Y')); ?></td>
        <td><?php echo e(ucwords(str_replace('_',' ', $order->payment_method ?? 'N/A'))); ?></td>
        <td><?php echo e(strtoupper($order->payment_status)); ?></td>
      </tr>
    </table>
  </div>

  <!-- ITEMS -->
  <div class="box">
    <table>
      <thead>
        <tr>
          <th>Item</th>
          <th class="center">Qty</th>
          <th class="right">Unit Price</th>
          <th class="right">Amount</th>
        </tr>
      </thead>
      <tbody>
      <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
          <td>
            <?php echo e($item->product->name ?? '-'); ?><br>
          </td>
          <td class="center"><?php echo e($item->qty); ?></td>
          <td class="right">Rp<?php echo e(number_format($item->price,0,',','.')); ?></td>
          <td class="right">Rp<?php echo e(number_format($item->price * $item->qty,0,',','.')); ?></td>
        </tr>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </tbody>
    </table>
  </div>

  <!-- TOTAL -->
  <div class="total-box">
    <div>
      <span>Subtotal:</span>
      <strong>Rp<?php echo e(number_format($order->total_price,0,',','.')); ?></strong>
    </div>

    <div>
      <span>Shipping (<?php echo e($order->shipping_service); ?>):</span>
      <strong>Rp<?php echo e(number_format($order->shipping_cost,0,',','.')); ?></strong>
    </div>

    

    

    <div style="border-top:1px solid #aaa; margin-top:8px; padding-top:8px; font-size:14px;">
      <span><strong>Total:</strong></span>
      <strong style="color:#1e3a8a;">Rp<?php echo e(number_format($order->grand_total,0,',','.')); ?></strong>
    </div>
  </div>

  <div style="clear:both;"></div>

  <!-- PAID NOTICE -->
  <?php if($order->payment_status === 'paid'): ?>
    <div class="paid-box">
      <strong>Payment Received</strong><br>
      Thank you for your payment.<br>
      
    </div>
  <?php endif; ?>

  <!-- NOTES -->
  <?php if($order->notes): ?>
    <div class="notes">
      <div class="title">Notes:</div>
      <?php echo e($order->notes); ?>

    </div>
  <?php endif; ?>

  <!-- TERMS -->
  <div class="terms">
    <div class="title">Terms & Conditions:</div>
    <ul>
      <li>Payment due within 7 days from invoice date.</li>
      <li>Include the invoice number in payment reference.</li>
      <li>Contact support for any invoice questions.</li>
      <li>All prices in Indonesian Rupiah (IDR).</li>
    </ul>
  </div>

  <!-- FOOTER -->
  <div class="footer">
    Generated on <?php echo e(now()->format('d M Y, H:i')); ?>

  </div>
</div>

</body>
</html><?php /**PATH /Users/gusde/Documents/laravel/marketplace-timedoor/resources/views/admin/orders/invoice-pdf.blade.php ENDPATH**/ ?>